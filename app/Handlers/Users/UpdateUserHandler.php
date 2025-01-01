<?php
namespace App\Handlers\Users;

use App\Constants\RoleUuid;
use App\Exceptions\ServerException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateUserHandler
{
    public function handle($command)
    {
        DB::beginTransaction();
        try {
            $command->user->update([
                'email' => $command->email,
                'password' => Hash::make($command->password),
                'first_name' => $command->first_name,
                'last_name' => $command->last_name,
                'gender' => $command->gender,
                'phone' => $command->phone,
                'bio' => $command->bio,
            ]);

            DB::commit();
            return;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
