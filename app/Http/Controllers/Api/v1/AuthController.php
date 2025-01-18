<?php

namespace App\Http\Controllers\Api\v1;

use App\Commands\Auth\ForgotPasswordCommand;
use App\Commands\Auth\LoginCommand;
use App\Commands\Auth\RegisterCommand;
use App\Commands\Auth\ResetPasswordCommand;
use App\Handlers\Auth\ForgotPasswordHandler;
use App\Handlers\Auth\LoginHandler;
use App\Handlers\Auth\RegisterHandler;
use App\Handlers\Auth\ResetPasswordHandler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
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
        $command = new LoginCommand($request->validated());
        $this->commandBus->addHandler(LoginCommand::class, LoginHandler::class);
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
        $this->commandBus->addHandler(ForgotPasswordCommand::class, ForgotPasswordHandler::class);
        $command = new ForgotPasswordCommand($request->validated());
        $data = $this->commandBus->dispatch($command);

        return ResponseHelper::success($data);
    }
    public function reset(ResetPasswordRequest $request)
    {
        $this->commandBus->addHandler(ResetPasswordCommand::class, ResetPasswordHandler::class);
        $command = new ResetPasswordCommand($request->validated());
        $data = $this->commandBus->dispatch($command);

        return ResponseHelper::success($data);
    }
}
