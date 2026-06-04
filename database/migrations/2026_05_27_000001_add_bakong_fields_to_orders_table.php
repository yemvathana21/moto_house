<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $columns = DB::select('SHOW COLUMNS FROM orders');
        $columnNames = array_column($columns, 'Field');

        if (!in_array('transaction_id', $columnNames)) {
            DB::statement('ALTER TABLE orders ADD COLUMN transaction_id VARCHAR(255) NULL AFTER payment_status');
        }

        if (!in_array('paid_at', $columnNames)) {
            DB::statement('ALTER TABLE orders ADD COLUMN paid_at TIMESTAMP NULL AFTER transaction_id');
        }
    }

    public function down(): void
    {
        $columns = DB::select('SHOW COLUMNS FROM orders');
        $columnNames = array_column($columns, 'Field');

        if (in_array('transaction_id', $columnNames)) {
            DB::statement('ALTER TABLE orders DROP COLUMN transaction_id');
        }

        if (in_array('paid_at', $columnNames)) {
            DB::statement('ALTER TABLE orders DROP COLUMN paid_at');
        }
    }
};
