<?php

namespace App\Constants;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use RuntimeException;

enum Target: string
{
    case Teacher = 'teacher';
    case Student = 'student';
    case Administrator = 'administrator';

    public static function fromModel(string $model): Target
    {
        return match ($model) {
            Student::class => self::Student,
            Teacher::class => self::Teacher,
            Admin::class => self::Administrator,
            default => throw new RuntimeException('Unknown Target'),
        };
    }
}
