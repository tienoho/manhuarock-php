<?php

namespace Models;

class Deposit extends Model
{
    protected $table = 'deposits';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_membership_id');
    }

    public static function getAllDepositsWithUsers()
    {
        return self::with('user')->get();
    }
}