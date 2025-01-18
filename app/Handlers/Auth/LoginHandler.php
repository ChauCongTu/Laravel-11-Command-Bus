<?php
namespace App\Handlers\Auth;

use App\Commands\Auth\LoginCommand;
use App\Constants\ResponseMessage;
use App\Exceptions\AuthException;
use App\Exceptions\ServerException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginHandler
{
    public function handle(LoginCommand $command)
    {
        $credential = User::where('email', $command->getEmail())->first();

        if (!$credential || !Hash::check($command->getPassword(), $credential->password)) {
            throw new AuthException(ResponseMessage::INVALID_CREDENTIALS);
        }

        $bearerToken = JWTAuth::fromUser($credential);

        return [
            'user' => new UserResource($credential->load(['role', 'address'])),
            'token' => $bearerToken,
        ];
    }
}
