<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\NotificationStatus;
use App\Mail\NotificationMail;
use App\Models\BitcoinTrade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class GetTrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the latest trade from the Bitfinex API
                              and notify the user via email if the price has exceeded';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $tradeData = Http::get('https://api.bitfinex.com/v1/pubticker/btcusd');

        $bitcoinTrade = BitcoinTrade::create([
            'last_price' => $tradeData['last_price'],
            'current_time' => Carbon::createFromTimestamp($tradeData['timestamp'])->toDateTime()
        ]);

        $this->info(
            'The trade is saved with:'.
            ' Price:'.$bitcoinTrade->last_price.
            ' at:'.$bitcoinTrade->current_time->format('H:i:s')
        );

        $users = User::select('id','email','price_limit')
                    ->where('price_limit', '<' ,$bitcoinTrade->last_price)
                    ->where('is_notified', '=', NotificationStatus::NotNotified)
                    ->get()
                    ->toArray();

        foreach ($users as $user) {
            Mail::to($user['email'])->queue(new NotificationMail($user['price_limit']));
            User::where('id', $user['id'])->update(['is_notified' => NotificationStatus::Notified]);
        }


        return Command::SUCCESS;
    }
}
