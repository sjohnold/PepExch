<?php

use App\Models\User;
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
        Schema::create('report_sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'seller_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'reporter_id')->constrained()->cascadeOnDelete();
            $table->string('report_type');
            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_sellers');
    }
};
