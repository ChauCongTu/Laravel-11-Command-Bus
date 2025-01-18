<?php
namespace App\Http\Services\Repositories;

use App\Commands\Auth\RegisterCommand;
use App\Commands\Users\CreateUserCommand;

interface UserServiceInterface
{
    public function store(CreateUserCommand | RegisterCommand $command);
}
