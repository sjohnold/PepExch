<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Wallet;

class WalletRepository extends Repository
{
    public static function model()
    {
        return Wallet::class;    
    }
}