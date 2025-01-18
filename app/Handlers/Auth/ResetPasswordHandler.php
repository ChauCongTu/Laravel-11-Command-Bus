<?php
namespace App\Handlers\Auth;

use App\Commands\Auth\ResetPasswordCommand;
use App\Exceptions\ServerException;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordHandler
{
    public function handle(ResetPasswordCommand $command)
    {
        DB::beginTransaction();
        try {
            $status = Password::reset(
                [
                    'email' => $command->getEmail(),
                    'password' => $command->getPassword(),
                    'password_confirmation' => $command->getPassword(),
                    'token' => $command->getToken(),
                ],
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ServerException($th->getMessage());
        }
    }
}
