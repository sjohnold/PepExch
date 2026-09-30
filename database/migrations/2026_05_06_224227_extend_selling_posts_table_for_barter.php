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
        Schema::table('selling_posts', function (Blueprint $table) {
            // Making financial fields nullable as per PEPEXCH_CHECKS.md
            $table->float('asking_price')->nullable()->default(0)->change();
            $table->float('sold_price')->nullable()->default(0)->change();
            
            // Adding barter-specific fields
            $table->enum('exchange_type', ['bilo_sta', 'opisi', 'kategorije'])->default('bilo_sta')->after('asking_price');
            $table->text('exchange_description')->nullable()->after('exchange_type');
            $table->json('exchange_categories_json')->nullable()->after('exchange_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selling_posts', function (Blueprint $table) {
            $table->float('asking_price')->nullable(false)->change();
            // sold_price was already nullable
            
            $table->dropColumn(['exchange_type', 'exchange_description', 'exchange_categories_json']);
        });
    }
};
