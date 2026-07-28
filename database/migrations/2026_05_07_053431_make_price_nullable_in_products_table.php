<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->default(0)->change();
            $table->unsignedInteger('quantity')->nullable()->default(0)->change();
            $table
                ->enum('stock_status', ['in_stock', 'out_of_stock'])
                ->default('in_stock')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable(false)->change();
            $table->unsignedInteger('quantity')->nullable(false)->default(0)->change();
            $table
                ->enum('stock_status', ['in_stock', 'out_of_stock'])
                ->nullable(false)
                ->default('in_stock')
                ->change();
        });
    }
};
