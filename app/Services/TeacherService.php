<?php

namespace App\Services;


use App\Constants\SchoolTeacherLevel;
use App\Events\Teacher\Register;
use App\Models\Invite;
use App\Models\SchoolTeacher;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherService
{

    public function __construct(public Teacher $teacher)
    {
    }

    public static function register(string $email, string $password): Teacher
    {
        $teacher = Teacher::create(compact('email', 'password'));
        event(new Register($teacher));
        return $teacher;
    }

    public function accept(Invite $invite): SchoolTeacher
    {
        return DB::transaction(function () use ($invite) {
            $invite->update(['teacher_id' => $this->teacher->id]);
            return SchoolTeacher::firstOrCreate(
                [
                    'school_id' => $invite->school_id,
                    'teacher_id' => $this->teacher->id,
                ],
                [
                    'level' => SchoolTeacherLevel::Common
                ]
            );
        });
    }

    public function addFollower(Student $student): array
    {
        return $this->teacher->followers()->sync($student);
    }

    public function removeFollower(Student $student): int
    {
        return $this->teacher->followers()->detach($student);
    }
}
