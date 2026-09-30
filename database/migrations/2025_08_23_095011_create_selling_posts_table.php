<?php

use App\Enums\PostStatus;
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
        Schema::create('selling_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('conditions');
            $table->float('asking_price');
            $table->float('sold_price')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->longText('description');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('warranty_left')->nullable();
            $table->string('model')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('number_of_view')->default(0);
            $table->string('status')->default(PostStatus::Pending->value);
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_negotiable')->default(false);
            $table->foreignId('media_id')->nullable()->constrained('medias')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_posts');
    }
};
