<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Administrator::find(1);
        Teacher::create([
            'email' => 'teacher@localhost',
            'password' => Hash::make('123456'),
            'creator_type' => $admin::class,
            'creator_id' => $admin->getAuthIdentifier(),
        ]);
    }
}
