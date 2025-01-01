<?php

namespace App\Http\Controllers\Api\v1;

use App\Commands\Users\CreateUserCommand;
use App\Handlers\Users\CreateUserHandler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class UserController extends Controller
{
    protected CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    public function index()
    {
        $users = User::hasMoreThanAddress(1)->with(['role', 'address'])->get();
        $usersCollection = UserResource::collection($users);
        return ResponseHelper::success($usersCollection);
    }
    public function show(User $user)
    {
        $user->load(['role', 'address']);
        $userResource = new UserResource($user);
        return ResponseHelper::success($userResource);
    }
    public function store(CreateUserRequest $createUserRequest)
    {
        $this->commandBus->addHandler(CreateUserCommand::class, CreateUserHandler::class);
        $command = new CreateUserCommand($createUserRequest->validated());
        $data = $this->commandBus->dispatch($command);
        return response()->json($data);
    }
    public function update(User $user, CreateUserRequest $createUserRequest)
    {
        $user = User::hasMoreThanAddress(1)->get();
        return $user;
    }
    public function destroy(User $user)
    {
        $user = User::hasMoreThanAddress(1)->get();
        return $user;
    }
}
