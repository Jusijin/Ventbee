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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('event_name');
            $table->text('description');
            $table->string('location');
            $table->dateTime('date');
            $table->integer('total_quota')->default(0);
            $table->integer('quota_taken')->default(0);
            $table->dateTime('registration_open')->nullable();
            $table->dateTime('registration_close')->nullable();
            $table->enum('status', ['open', 'closed', 'on_progress', 'finished'])->default('open');
            $table->string('role');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
