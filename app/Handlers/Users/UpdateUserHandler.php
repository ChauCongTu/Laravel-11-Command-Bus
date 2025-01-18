<?php
namespace App\Handlers\Users;

use App\Exceptions\ServerException;
use Illuminate\Support\Facades\DB;

class UpdateUserHandler
{
    public function handle($command)
    {
        DB::beginTransaction();
        try {
            $command->user->update([
                'email' => $command->email,
                'first_name' => $command->firstName,
                'last_name' => $command->lastName,
                'gender' => $command->gender,
                'phone' => $command->phone,
                'bio' => $command->bio,
            ]);

            DB::commit();
            return $command->user->refresh()->load('role', 'address');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
