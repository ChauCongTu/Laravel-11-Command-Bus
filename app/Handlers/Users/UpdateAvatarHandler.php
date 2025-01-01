<?php
namespace App\Handlers\Users;

use App\Commands\Files\SaveFileCommand;
use App\Commands\Users\UpdateAvatarCommand;
use App\Constants\Extension;
use App\Exceptions\ServerException;
use App\Http\Services\FileService;
use Illuminate\Support\Facades\DB;

class UpdateAvatarHandler
{
    public function __construct(private FileService $fileService)
    {}
    public function handle(UpdateAvatarCommand $command)
    {
        DB::beginTransaction();
        try {
            if (empty($command->getAvatar())) {
                $this->fileService->destroy($command->getUser()->avatar);
                $command->getUser()->avatar = null;
                $command->getUser()->save();
                return $command->getUser();
            }

            $fileName = "{$command->getUser()['id']}";
            $file = $this->fileService->upload($command->getAvatar(), 'avatars', $fileName, Extension::JPG);
            $saveCommand = new SaveFileCommand(
                $file['path'],
                $file['originalName'],
                $file['ext'],
                $file['fileName'],
                $file['url'],
                $command->getUser()['id']
            );

            $this->fileService->save($saveCommand);
            $command->getUser()->avatar = $file['url'];
            $command->getUser()->save();
            DB::commit();
            return $command->getUser();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
