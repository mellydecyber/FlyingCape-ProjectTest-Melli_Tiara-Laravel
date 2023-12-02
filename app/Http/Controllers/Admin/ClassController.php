<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\ClassRequest;
use App\Services\ClassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClassController extends BaseApiController
{
    private ClassService $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index(): JsonResponse
    {
        $classes = $this->classService->getAllClasses();
        return $this->sendSuccess(
            $classes,
            ['message' => 'List all class']
        );
    }

    public function show($classId): JsonResponse
    {
        if (is_null($this->classService->getClassById($classId))) {
            return $this->sendError('Class not found', null, 404);
        }

        $class = $this->classService->getClassById($classId);
        return $this->sendSuccess(
            $class,
            ['message' => 'Class Details']
        );
    }

    public function store(ClassRequest $request): JsonResponse
    {
        $class = $this->classService->createClass($request->all());
        return $this->sendSuccess(
            $class,
            ['message' => 'Class was created successfully'],
            Response::HTTP_CREATED
        );
    }

    public function update(ClassRequest $request, $classId): JsonResponse
    {
        if (is_null($this->classService->getClassById($classId))) {
            return $this->sendError('Class not found', null, 404);
        }

        $class = $this->classService->updateClass($classId, $request->all());
        return $this->sendSuccess(
            $class,
            ['message' => 'Class was updated successfully']
        );
    }

    public function destroy($classId): JsonResponse
    {
        if (is_null($this->classService->getClassById($classId))) {
            return $this->sendError('Class not found', null, 404);
        }

        $this->classService->deleteClass($classId);
        return $this->sendSuccess(
            [],
            ['message' => 'Class deleted successfully']
        );
    }
}
