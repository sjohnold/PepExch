<?php

use App\Models\Banner;
use App\Models\Media;
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
        Schema::create('banner_thumbnails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Banner::class, 'banner_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Media::class, 'media_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_thumbnails');
    }
};
