<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('souls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('soul_name');
            $table->date('date_won');
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->boolean('baptized')->default(false);
            $table->text('follow_up_notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'date_won']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('souls');
    }
};
