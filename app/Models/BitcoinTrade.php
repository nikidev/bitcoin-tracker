<?php

namespace App\Models;

class BitcoinTrade extends BaseModel
{
    protected $fillable = ['last_price','current_time'];

    protected $hidden = ['id'];
}
