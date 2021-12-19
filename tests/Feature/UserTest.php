<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_user_update_or_create()
    {
        $response = $this->put('/api/user', [
            'email' => 'testmail@mail.com',
            'price_limit' => "45000.88"
        ]);

        $response->assertStatus(200);
    }
}
