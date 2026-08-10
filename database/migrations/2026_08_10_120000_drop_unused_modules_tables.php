<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drops tables belonging to modules that were removed from the app
     * (Author, Blog, Coupon, Cart, Product Reviews, Product Specification/Variant,
     * Related Products, Slider, Tax Rate, and the legacy Order/OrderItem checkout flow).
     *
     * Order matters: child/pivot tables are dropped before their parents to avoid
     * foreign key constraint errors.
     */
    public function up(): void
    {
        Schema::dropIfExists('author_product');   // pivot — depends on authors, products
        Schema::dropIfExists('authors');

        Schema::dropIfExists('blogs');
        Schema::dropIfExists('blog_categories');

        Schema::dropIfExists('carts');

        Schema::dropIfExists('coupons');

        Schema::dropIfExists('order_items');      // depends on orders, products
        Schema::dropIfExists('orders');

        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('related_products');

        Schema::dropIfExists('sliders');
        Schema::dropIfExists('tax_rates');
        Schema::dropIfExists('attribute_definitions');
    }

    /**
     * Not reversible — recreating these would mean restoring 15 old table
     * schemas for modules that no longer exist in the app. If you ever need
     * this data back, restore from a database backup instead.
     */
    public function down(): void
    {
        // Intentionally left empty — see note above.
    }
};