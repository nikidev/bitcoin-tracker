<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BitcoinTrade;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BitcoinTradeService
{
    public function getLatestTrades(): Collection|array
    {
        return BitcoinTrade::where('current_time', '>=', Carbon::now()->subDay())->get();
    }
}
