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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Laravel pakai UUID, bukan ID angka biasa
            $table->string('type');
            $table->morphs('notifiable'); // Ini otomatis buat kolom notifiable_id & notifiable_type
            $table->text('data'); // Data JSON (pesan, event_id, dll masuk sini)
            $table->timestamp('read_at')->nullable(); // Penanda sudah dibaca
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};