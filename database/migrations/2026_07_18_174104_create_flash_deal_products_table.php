<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flash_deal_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_deal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->decimal('flash_price', 10, 2);
            $table->integer('stock_limit')->default(0);
            $table->integer('sold_count')->default(0);
            $table->timestamps();

            $table->unique(['flash_deal_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flash_deal_products');
    }
};
