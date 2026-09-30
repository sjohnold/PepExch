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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('selling_post_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('boost_plan_id')->nullable()->constrained('boost_plans')->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_gateways')->onDelete('set null');

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();

            $table->boolean('auto_pay')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->timestamp('paid_at')->nullable();

            $table->string('identifier')->unique(); // unique transaction identifier
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'complete', 'cancel'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
