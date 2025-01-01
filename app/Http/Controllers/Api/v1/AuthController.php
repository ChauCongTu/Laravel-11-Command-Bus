<?php

namespace App\Http\Controllers\Api\v1;

use App\Commands\Auth\LoginCommand;
use App\Commands\Auth\RegisterCommand;
use App\Handlers\Auth\LoginHandler;
use App\Handlers\Auth\RegisterHandler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class AuthController extends Controller
{
    protected CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    public function login(LoginRequest $request)
    {
        $this->commandBus->addHandler(LoginCommand::class, LoginHandler::class);
        $command = new LoginCommand($request->validated());
        $data = $this->commandBus->dispatch($command);

        return ResponseHelper::success($data);
    }
    public function register(RegisterRequest $request)
    {
        $this->commandBus->addHandler(RegisterCommand::class, RegisterHandler::class);
        $command = new RegisterCommand($request->validated());
        $data = $this->commandBus->dispatch($command);

        return ResponseHelper::success($data);
    }
    public function forgot(ForgotRequest $request)
    {

    }
}
