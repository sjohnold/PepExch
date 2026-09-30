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
            $table->text('description')->nullable()->after('sustain_days'); // add nullable description
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boost_plans', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
