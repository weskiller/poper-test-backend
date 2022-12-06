<?php

namespace App\Services;

use App\Constants\SchoolStatus;
use App\Constants\SchoolTeacherLevel;
use App\Events\School\Approved;
use App\Events\School\EmailInvite;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;

class SchoolService
{

    public function __construct(public School $school)
    {
    }

    public function approve(): School
    {
        $this->school->update(['status' => SchoolStatus::Approved]);
        event(new Approved($this->school));
        /** @var Teacher $founder */
        $founder = $this->school->founder;
        $founder->schools()->attach($this->school->id, ['level' => SchoolTeacherLevel::Administrator]);
        return $this->school;
    }

    public function invite(string $email): bool|Teacher
    {
        if ($this->school->teachers()->where('email', $email)->exists()) {
            return false;
        }
        $invite = $this->school->invites()->create([
            'code' => Str::uuid(),
            'email' => $email
        ]);
        event(new EmailInvite($invite));
        return true;
    }

    public function createStudent(string $email, string $password): Student
    {
        return $this->school->students()->create([
            'email' => $email,
            'password' => $password
        ]);
    }
}
