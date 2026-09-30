<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\UserVerify;

class UserVerifyRepository extends Repository
{
    public static function model()
    {
        return UserVerify::class;
    }

    //Shakil -> this function is calling from UserRepository - eta otp genrate and save korbe and return o kore dibe. 
    public static function createOtp($userId, $contact)
    {
        $otp = rand(1000, 9999);
        self::create([
            'user_id' => $userId,
            'otp' => $otp,
            'contact' => $contact,
        ]);
        return $otp;
    }
}
