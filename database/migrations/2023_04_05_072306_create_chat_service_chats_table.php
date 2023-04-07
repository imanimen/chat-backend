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
        Schema::create('chat_service_chats', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('channel_id');
            $table->uuid("message_id")->nullable();
            $table->foreignId('channel_id')->references('id')->on('chat_service_channels')->onDelete('cascade');
            $table->morphs('sender');
            $table->morphs('receiver');
            $table->longText('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_service_chats');
    }
};
