<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\NotificationStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function handleUpdateOrCreateUser($email, $price_limit): Model|User
    {
        return  User::updateOrCreate(
            ['email'=> $email],
            [
                'email' => $email,
                'price_limit' => $price_limit,
                'is_notified' => NotificationStatus::NotNotified
            ]
        );
    }
}
