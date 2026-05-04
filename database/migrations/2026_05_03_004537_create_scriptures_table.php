<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scriptures', function (Blueprint $table) {
            $table->id();
            $table->string('date', 10)->unique(); // stored as plain "Y-m-d" string
            $table->string('reference');
            $table->text('text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scriptures');
    }
};
