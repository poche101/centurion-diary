<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giving_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount_espees', 10, 2);
            $table->string('category')->default('offering');
            // tithe | offering | missions | welfare | building_fund | special_seed | other
            $table->string('description')->nullable();
            $table->date('date_given');
            $table->timestamps();

            $table->index(['user_id', 'date_given']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giving_logs');
    }
};
