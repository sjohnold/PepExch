<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Contact;

class ContactRepository extends Repository
{
    public static function model()
    {
        return Contact::class;
    }

    public static function storeContact($request)
    {

        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
    }
}
