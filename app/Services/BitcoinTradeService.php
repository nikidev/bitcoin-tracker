<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BitcoinTrade;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as ISCollection;

class BitcoinTradeService
{
    public function getLatestTrades(): Collection|array
    {
        return BitcoinTrade::where('current_time', '>=', Carbon::now()->subDay())->get();
    }

    public function getLastPrice(): ISCollection
    {

        return BitcoinTrade::all()->sortByDesc('current_time')->take(1)->pluck('last_price');
    }
}
