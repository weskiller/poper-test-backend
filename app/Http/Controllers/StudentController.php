<?php

namespace App\Http\Controllers;

use App\Constants\SchoolTeacherLevel;
use App\Http\Requests\Student\StoreRequest;
use App\Http\Resources\Student as StudentResource;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\SchoolService;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class StudentController
{
    public function index()
    {
        /** @var Teacher $teacher */
        $teacher = auth()->user();

        $query = Student::with('school')
            ->whereHas('school.teachers', static fn($query) => $query->where('teachers.id', $teacher->id));

        return StudentResource::collection($query->paginate());
    }

    public function store(StoreRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        /** @var Teacher $teacher */
        $teacher = auth()->user();
        /** @var School $school */
        $school = School::whereHas(
            'teachers',
            static fn($query) => $query->where('teachers.id', $teacher->id)
                ->where('school_teacher.level', SchoolTeacherLevel::Administrator)
        )->where('schools.id', $request->input('school_id'))
            ->firstOrFail();

        if ($school->students()->where('email', $email)->exists()) {
            return response()->json(['message' => 'student already exists']);
        }
        $student = (new SchoolService($school))
            ->createStudent($email, $password);
        return new StudentResource($student);
    }

    public function follow(Request $request, string $id)
    {
        /** @var Student $student */
        $student = auth()->user();
        $teacher = Teacher::whereHas('schools', static fn($query) => $query->where('schools.id', $student->school_id))->findOrFail($id);
        $service = (new TeacherService($teacher));
        switch ($request->method()) {
            case 'POST':
                $service->addFollower($student);
                break;
            case 'DELETE':
                $service->removeFollower($student);
                break;
        }
    }
}
