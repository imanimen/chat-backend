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
        Schema::create('chat_service_channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->morphs('receiver');
            $table->morphs('sender');
            $table->json('last_message')->nullable();
            $table->unsignedBigInteger('archived_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_service_channels');
    }
};
