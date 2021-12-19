<?php

namespace Tests\Feature;

use Tests\TestCase;

class BitcoinTradesTest extends TestCase
{

    public function test_get_latest_trades()
    {
        $response = $this->get('/api/bitcoin-trades');

        $response->assertStatus(200);
    }

    public function test_get_last_price()
    {
        $response = $this->get('/api/bitcoin-last-price');

        $response->assertStatus(200);
    }
}
