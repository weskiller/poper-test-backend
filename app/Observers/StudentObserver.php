<?php

namespace App\Observers;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentObserver
{
    public function creating(Student $student)
    {
        $student->password = Hash::make($student->password);
    }
}
