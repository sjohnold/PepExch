<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Events\NotifyManagementEvent;
use App\Models\ReportSeller;

class ReportSellerRepository extends Repository
{
    public static function model()
    {
        return ReportSeller::class;
    }

    public static function storeReport($request)
    {
        return self::create([
            'seller_id' => $request->seller_id,
            'reporter_id' => $request->reporter_id,
            'report_type' => $request->report_type,
            'details' => $request->details,
        ]);
    }
}
