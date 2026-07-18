<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->date('check_in_date');
            $table->integer('streak')->default(1);
            $table->integer('points')->default(10);
            $table->timestamps();

            $table->unique(['customer_id', 'check_in_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
