<?php
namespace App\Handlers\Users;

use App\Http\Services\Repositories\UserServiceInterface;

class CreateUserHandler
{
    public function __construct(private UserServiceInterface $userService)
    {}
    public function handle($command)
    {
        $data = $this->userService->store($command);
        return $data;
    }
}
