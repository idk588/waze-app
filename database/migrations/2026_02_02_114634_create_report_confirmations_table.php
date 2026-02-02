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
    Schema::create('report_confirmations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->boolean('is_helpful')->default(true); // thumbs up/down
        $table->timestamps();
        
        // Prevent duplicate confirmations from same user
        $table->unique(['report_id', 'user_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_confirmations');
    }
};
