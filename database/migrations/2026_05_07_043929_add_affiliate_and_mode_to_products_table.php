<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Product mode — selling বা affiliate
            $table->string('product_mode')->default('selling')->index()->after('id');
            // e.g. 'selling', 'affiliate'

            // Affiliate fields
            $table->string('affiliate_platform')->nullable()->after('product_mode');
            $table->string('affiliate_url', 500)->nullable()->after('affiliate_platform');
            $table->decimal('affiliate_price', 10, 2)->nullable()->after('affiliate_url');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_mode', 'affiliate_platform', 'affiliate_url', 'affiliate_price']);
        });
    }
};
