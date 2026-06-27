<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'transaction_id')) {
            DB::statement('ALTER TABLE orders ADD COLUMN transaction_id VARCHAR(255) NULL');
        }

        if (!Schema::hasColumn('orders', 'paid_at')) {
            DB::statement('ALTER TABLE orders ADD COLUMN paid_at TIMESTAMP NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'transaction_id')) {
            DB::statement('ALTER TABLE orders DROP COLUMN transaction_id');
        }

        if (Schema::hasColumn('orders', 'paid_at')) {
            DB::statement('ALTER TABLE orders DROP COLUMN paid_at');
        }
    }
};
