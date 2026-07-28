<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Add product_type column to products table.
     * Existing rows default to 'book' so no data is lost.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Product type — determines which extra fields/tabs are shown
            $table->string('product_type')->default('book')->index()->after('is_featured');
            // e.g. 'book', 'clothing', 'hat', 'accessory', 'other'

            // Generic short attributes (brand, material, weight, etc.)
            // stored as JSON so no extra columns needed per type
            $table->json('attributes')->nullable()->after('product_type');
            // Example: {"brand":"Adidas","material":"Cotton","weight":"200g"}

            // SKU / barcode (useful for non-book products)
            $table->string('sku')->nullable()->unique()->after('attributes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_type', 'attributes', 'sku']);
        });
    }
};
