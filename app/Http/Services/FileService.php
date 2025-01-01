<?php

namespace App\Infrastucture\Service;

use Illuminate\Support\Facades\Storage;
use Str;

class FileService
{
    private string $storageType;
    public function __construct()
    {
        $this->storageType = app()->isLocal() ? 'public' : 's3';
    }
    public function upload($file, $path)
    {
        $path = date('Y-m-d') . '/' . $path;
        $extension = $file->getClientOriginalExtension();
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $filenameToStore = $path . '/' . $filename . '_' . time() . '.' . $extension;

        $isUploaded = Storage::disk($this->storageType)->put($filenameToStore, file_get_contents($file->getRealPath()));
        $url = $isUploaded ? Storage::disk($this->storageType)->url($filenameToStore) : '';

        return [
            'path' => app()->isLocal() ? 'storage/' . $filenameToStore : $filenameToStore,
            'originalName' => $filename,
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
}
