<?php
namespace App\Http\Services;

use App\Commands\Auth\RegisterCommand;
use App\Commands\Users\CreateUserCommand;
use App\Constants\RoleUuid;
use App\Exceptions\ServerException;
use App\Http\Services\Repositories\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function store(CreateUserCommand | RegisterCommand $command)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $command->getEmail(),
                'password' => Hash::make($command->getPassword()),
                'first_name' => $command->getFirstName(),
                'last_name' => $command->getLastName(),
                'gender' => $command->getGender(),
                'phone' => $command->getPhone(),
                'role_id' => RoleUuid::USER,
            ]);
            $user->address()->create([
                'name' => $user->first_name . ' ' . $user->last_name,
                'phone' => $user->phone,
                'prefecture' => $command->getPrefecture(),
                'city' => $command->getCity(),
                'address' => $command->getAddress(),
                'etc_address' => $command->getEtcAddress(),
            ]);
            DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
