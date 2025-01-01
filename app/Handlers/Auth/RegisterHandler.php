<?php
namespace App\Handlers\Auth;

use App\Commands\Auth\RegisterCommand;
use App\Http\Services\Repositories\UserServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterHandler
{
    public function __construct(private UserServiceInterface $userService)
    {}
    public function handle(RegisterCommand $command)
    {
        $data = $this->userService->store($command);
        $bearerToken = JWTAuth::fromUser($data);

        return [
            'user' => $data,
            'token' => $bearerToken,
        ];
    }
}
