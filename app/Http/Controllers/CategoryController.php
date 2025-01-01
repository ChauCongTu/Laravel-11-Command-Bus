<?php

namespace App\Http\Controllers;

use App\Commands\Users\CreateUserCommand;
use App\Handlers\Users\CreateUserHandler;
use App\Helpers\ResponseHelper;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class CategoryController extends Controller
{
    protected CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    public function index()
    {
        $data = User::hasMoreThanAddress(1)->with(['role', 'address'])->get();
        $collection = UserResource::collection($data);
        return ResponseHelper::success($collection);
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

    }
    public function destroy(User $user)
    {

    }
}
