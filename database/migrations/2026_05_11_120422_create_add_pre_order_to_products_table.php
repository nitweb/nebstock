<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Pre-order enabled flag
            $table->boolean('is_pre_order')->default(false)->after('is_featured');

            // Expected delivery / release date (nullable)
            $table->date('pre_order_date')->nullable()->after('is_pre_order');

            // Optional note shown to customer ("Ships in 2–3 weeks", etc.)
            $table->string('pre_order_note', 500)->nullable()->after('pre_order_date');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_pre_order', 'pre_order_date', 'pre_order_note']);
        });
    }
};
