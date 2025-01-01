<?php
namespace App\Handlers\Users;

use App\Constants\RoleUuid;
use App\Exceptions\ServerException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserHandler
{
    public function handle($command)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $command->email,
                'password' => Hash::make($command->password),
                'first_name' => $command->first_name,
                'last_name' => $command->last_name,
                'gender' => $command->gender,
                'phone' => $command->phone,
                'role_id' => RoleUuid::USER,
            ]);
            $user->address()->create([
                'name' => $user->first_name . ' ' . $user->last_name,
                'phone' => $user->phone,
                'prefecture' => $command->prefecture,
                'city' => $command->city,
                'address' => $command->address,
                'etc_address' => $command->etc_address,
            ]);
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
