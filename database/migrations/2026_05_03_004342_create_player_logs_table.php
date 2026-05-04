<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('prayer_date');
            $table->unsignedSmallInteger('duration_minutes');   // 1–720
            $table->string('prayer_type')->default('general');  // intercession|worship|tongues|meditation|general
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'prayer_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_logs');
    }
};
