<?php

namespace App\Observers;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherObserver
{
    public function creating(Teacher $teacher)
    {
        $teacher->password = Hash::make($teacher->password);
    }
}
