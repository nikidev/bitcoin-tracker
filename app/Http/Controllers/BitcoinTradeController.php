<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BitcoinTrade;
use App\Services\BitcoinTradeService;
use Illuminate\Database\Eloquent\Collection;

class BitcoinTradeController extends Controller
{
    /**
     * Get all Bitcoin trades for the last 24 hours.
     *
     * @return BitcoinTrade[]|Collection
     */
    public function index(BitcoinTradeService $service): Collection|array
    {
        return $service->getLatestTrades();
    }
}
