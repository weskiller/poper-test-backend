<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Administrator
{
    use HasApiTokens;

    public function findForPassport($username): static|null
    {
        return $this->where('username', $username)->first();
    }
}
