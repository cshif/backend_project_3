<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $casts = [
        'user_ids' => 'array',
    ];

    private mixed $user_ids;

    public function userIds(): Collection
    {
        return User::whereIn('id', $this->user_ids)->get();
    }
}
