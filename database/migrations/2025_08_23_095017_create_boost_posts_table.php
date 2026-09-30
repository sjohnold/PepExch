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
        Schema::create('boost_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selling_post_id')->constrained('selling_posts')->cascadeOnDelete();
            $table->foreignId('boost_plan_id')->constrained('boost_plans');
            $table->boolean('auto_pay')->default(false);
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boost_posts');
    }
};
