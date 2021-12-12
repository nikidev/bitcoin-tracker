<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\NotificationStatus;
use App\Mail\NotificationMail;
use App\Models\BitcoinTrade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class GetTradeAndNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $tradeData = Http::get('https://api.bitfinex.com/v1/pubticker/btcusd');

        $bitcoinTrade = BitcoinTrade::create([
            'last_price' => $tradeData['last_price'],
            'current_time' => Carbon::createFromTimestamp($tradeData['timestamp'])->toDateTime()
        ]);

        $users = User::select('id','email','price_limit')
            ->where('price_limit', '<' ,$bitcoinTrade->last_price)
            ->where('is_notified', '=', NotificationStatus::NotNotified)
            ->get()
            ->toArray();

        foreach ($users as $user) {
            Mail::to($user['email'])->send(new NotificationMail($user['price_limit']));
            User::where('id', $user['id'])->update(['is_notified' => NotificationStatus::Notified]);
        }
    }
}
