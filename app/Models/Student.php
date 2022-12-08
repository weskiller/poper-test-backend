<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['email', 'password', 'school_id'];

    public function findForPassport($username): static|null
    {
        return $this->where('email', $username)->first();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function oauth(): BelongsTo
    {
        return $this->belongsTo(OAuth::class);
    }

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'send');
    }
}
