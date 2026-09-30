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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('selling_post_id');
            
            $table->json('sender_items')->comment('Items offered by the sender');
            $table->json('receiver_items')->nullable()->comment('Items from the receiver side (usually the ad items)');
            
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'withdrawn', 'disputed'])->default('pending');
            
            $table->boolean('sender_confirmed')->default(false);
            $table->boolean('receiver_confirmed')->default(false);
            
            $table->timestamps();

            // Foreign Keys
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('selling_post_id')->references('id')->on('selling_posts')->onDelete('cascade');

            // Indexes for fast rendering of "My Offers" page
            $table->index(['sender_id', 'status']);
            $table->index(['receiver_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
