<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teacher\StoreRequest;
use App\Http\Resources\Student as StudentResource;
use App\Http\Resources\Teacher as TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;

class TeacherController
{
    public function register(StoreRequest $request)
    {
        $teacher = TeacherService::register($request->input('email'), $request->input('password'));
        return new TeacherResource($teacher);
    }

    public function followers()
    {
        /** @var Teacher $teacher */
        $teacher = auth()->user();
        return StudentResource::collection($teacher->followers()->with('school')->paginate());
    }
}
