<?php

namespace App\Http\Services;

use App\Commands\Files\SaveFileCommand;
use App\Models\FileStorage;
use Illuminate\Support\Facades\Storage;

class FileService
{
    private string $storageType;
    public function __construct()
    {
        $this->storageType = app()->isLocal() ? 'public' : 's3';
    }
    public function upload($file, $path, $fileName = null, $extension = null)
    {
        $path = $fileName ? $path : date('Y-m-d') . '/' . $path;
        $extension = $extension ?? $file->getClientOriginalExtension();
        $filename = $fileName ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $storagePath = $path . '/' . $filename . '.' . $extension;

        if ($fileName && Storage::disk($this->storageType)->exists($storagePath)) {
            Storage::disk($this->storageType)->delete($storagePath);
        }

        $isUploaded = Storage::disk($this->storageType)->putFileAs($path, $file, $filename . '.' . $extension);

        if (!$isUploaded) {
            throw new \Exception('File upload failed.');
        }

        $url = Storage::disk($this->storageType)->url($storagePath);

        return [
            'path' => app()->isLocal() ? 'storage/' . $storagePath : $storagePath,
            'fileName' => $fileName . '.' . $extension,
            'originalName' => $file->getClientOriginalName(),
            'ext' => $extension,
            'url' => $url,
        ];
    }

    public function delete($path)
    {
        $storagePath = str_replace('storage/', '', $path);

        if (Storage::disk($this->storageType)->exists($storagePath)) {
            Storage::disk($this->storageType)->delete($storagePath);
            return true;
        }
        return false;
    }
    public function save(SaveFileCommand $saveFileCommand)
    {
        $files = FileStorage::create([
            'path' => $saveFileCommand->getPath(),
            'original_name' => $saveFileCommand->getOriginalName(),
            'ext' => $saveFileCommand->getExt(),
            'file_name' => $saveFileCommand->getFileName(),
            'url' => $saveFileCommand->getUrl(),
            'upload_by' => $saveFileCommand->getUploadBy(),
        ]);

        return $files;
    }
    public function destroy($url)
    {
        FileStorage::where('url', $url)->delete();
    }
}
