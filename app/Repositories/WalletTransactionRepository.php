<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\WalletTransaction;

class WalletTransactionRepository extends Repository
{
    public static function model()
    {
        return WalletTransaction::class;    
    }
}