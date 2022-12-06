<?php

namespace App\Http\Controllers;

use App\Constants\SchoolTeacherLevel;
use App\Http\Requests\School\AcceptRequest;
use App\Http\Requests\Teacher\SendRequest;
use App\Http\Resources\SchoolTeacher as SchoolTeacherResource;
use App\Models\Invite;
use App\Models\School;
use App\Models\Teacher;
use App\Services\SchoolService;
use App\Services\TeacherService;
use Symfony\Component\HttpFoundation\Response;

class InviteController
{

    public function store(SendRequest $request)
    {
        $email = $request->input('email');
        /** @var Teacher $administrator */
        $administrator = auth()->user();
        /** @var School $school */
        $school = $administrator->schools()
            ->where('level', SchoolTeacherLevel::Administrator)
            ->where('schools.id', $request->input('school_id'))
            ->firstOrFail();

        if ($school->teachers()->where('email', $email)->exists()) {
            return response()->json(['message' => 'Teacher already exists'])
                ->setStatusCode(Response::HTTP_CONFLICT);
        }
        (new SchoolService($school))->invite($request->input('email'));
        return response()->json(['message' => 'Invitation email sent']);
    }

    public function accept(AcceptRequest $request)
    {
        /** @var Teacher $teacher */
        $teacher = auth()->user();
        $invite = Invite::with('school')
            ->whereCode($request->input('code'))
            ->whereEmail($teacher->email)
            ->whereNull('teacher_id')
            ->firstOrFail();
        $schoolTeacher = (new TeacherService($teacher))->accept($invite);
        return new SchoolTeacherResource($schoolTeacher);
    }
}
