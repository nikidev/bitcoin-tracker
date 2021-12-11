<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function update(StoreUserRequest $request, UserService $service): array
    {
        $user = $service->handleUpdateOrCreateUser($request->email, $request->price_limit);

        if($user->wasChanged()) {
            return [
              'message' => 'The user was saved successfully !'
            ];
        }
        else {
            return [
                'message' => 'There was a problem saving the user !'
            ];
        }
    }
}
