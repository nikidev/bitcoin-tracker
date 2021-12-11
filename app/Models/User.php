<?php

namespace App\Models;

class User extends BaseModel
{
    protected $fillable = ['email','price_limit','is_notified'];
}
