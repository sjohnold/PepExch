<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('boost_plans', function (Blueprint $table) {
            // Existing float columns → decimal conversion
            $table->decimal('payable_amount', 10, 2)->nullable()->change();
            $table->decimal('discount_amount', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boost_plans', function (Blueprint $table) {
            // Undo decimal conversion → float
            $table->float('payable_amount')->change();
            $table->float('discount_amount')->default(0)->change();
        });
    }
};
