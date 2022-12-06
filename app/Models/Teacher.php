<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'status', 'email', 'password', 'creator_type', 'creator_id',
    ];

    public function findForPassport($username): static|null
    {
        return $this->where('email', $username)->first();
    }

    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, SchoolTeacher::class)
            ->using(SchoolTeacher::class)
            ->as('st')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function foundedSchools(): MorphMany
    {
        return $this->morphMany(School::class, 'founder');
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

    public function oauth(): BelongsTo
    {
        return $this->belongsTo(OAuth::class);
    }

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'receive');
    }


    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, Follow::class)
            ->using(Follow::class)
            ->withTimestamps();
    }
}
