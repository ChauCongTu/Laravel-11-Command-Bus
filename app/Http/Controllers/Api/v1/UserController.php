<?php

namespace App\Http\Controllers\Api\v1;

use App\Commands\Users\CreateUserCommand;
use App\Commands\Users\UpdateAvatarCommand;
use App\Commands\Users\UpdateUserCommand;
use App\Handlers\Users\CreateUserHandler;
use App\Handlers\Users\UpdateAvatarHandler;
use App\Handlers\Users\UpdateUserHandler;
use App\Helpers\CommandBus;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateUserRequest;
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
        $userCollections = UserResource::collection($users);
        return ResponseHelper::success($userCollections);
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
        return ResponseHelper::success(new UserResource($data));
    }
    public function update(User $user, UpdateUserRequest $updateUserRequest)
    {
        $command = new UpdateUserCommand($user, $updateUserRequest->validated());
        $this->commandBus->addHandler(UpdateUserCommand::class, UpdateUserHandler::class);
        $data = $this->commandBus->dispatch($command);
        return ResponseHelper::success(new UserResource($data));
    }
    public function destroy(User $user)
    {
        $user->delete();
        return ResponseHelper::success([$user->id]);
    }
    public function avatar(UpdateAvatarRequest $updateAvatarRequest)
    {
        $user = auth()->user();
        $command = new UpdateAvatarCommand($user, $updateAvatarRequest->validated());
        $this->commandBus->addHandler(UpdateAvatarCommand::class, UpdateAvatarHandler::class);
        $data = $this->commandBus->dispatch($command);
        return ResponseHelper::success(new UserResource($data));
    }
}
