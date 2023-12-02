<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return $this->sendSuccess(
            $users,
            ['message' => 'List all users']
        );
    }

    public function show($userId): JsonResponse
    {
        if (is_null($this->userService->getUserById($userId))) {
            return $this->sendError('User not found', null, 404);
        }

        $user = $this->userService->getUserById($userId);
        return $this->sendSuccess(
            $user,
            ['message' => 'User details']
        );
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->all());
        return $this->sendSuccess(
            $user,
            ['message' => 'User created successfully'],
            201
        );
    }

    public function update(UserRequest $request, $userId): JsonResponse
    {
        if (is_null($this->userService->getUserById($userId))) {
            return $this->sendError('User not found', null, 404);
        }

        $user = $this->userService->updateUser($userId, $request->all());
        return $this->sendSuccess(
            $user,
            ['message' => 'User updated successfully']
        );
    }

    public function destroy($userId): JsonResponse
    {
        if (is_null($this->userService->getUserById($userId))) {
            return $this->sendError('User not found', null, 404);
        }

        $this->userService->deleteUser($userId);
        return $this->sendSuccess([], ['message' => 'User deleted successfully']);
    }
}
