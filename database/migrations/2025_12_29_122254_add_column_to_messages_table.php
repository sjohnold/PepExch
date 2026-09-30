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
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'sender_id')) {
                // $table->dropForeign(['sender_id']);
                try {
                    $table->dropForeign(['sender_id']);
                } catch (\Exception $e) {
                    $table->unsignedBigInteger('sender_id')->nullable()->change();
                }

                $table->dropColumn('sender_id');
            }
            $table->foreignIdFor(User::class,'sender_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(User::class,'sender_id');
        });
    }
};
