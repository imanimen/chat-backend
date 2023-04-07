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
        Schema::create('chat_service_message_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->references('id')->on('chat_service_chats')->onDelete('cascade');
            $table->foreignId('file_id')->references('id')->on('chat_service_files')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_service_message_file');
    }
};
