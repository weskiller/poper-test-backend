<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = Teacher::find(1);
        Student::create([
            'email' => 'student@localhost',
            'password' => Hash::make('123456'),
            'creator_type' => $teacher::class,
            'creator_id' => $teacher->getAuthIdentifier(),
            'school_id' => 1,
        ]);
    }
}
