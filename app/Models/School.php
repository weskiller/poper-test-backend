<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'name'];

    public function founder(): MorphTo
    {
        return $this->morphTo();
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, SchoolTeacher::class)
            ->using(SchoolTeacher::class)
            ->as('st')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }
}
