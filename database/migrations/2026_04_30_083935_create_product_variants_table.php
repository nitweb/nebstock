<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Product variants — for clothing/hats that come in sizes & colours.
     *
     * One product can have many variants, each with its own:
     *   - size   (S / M / L / XL / Free Size / 7.5 etc.)
     *   - color  (Red / Navy / etc.)
     *   - price override (optional — uses parent price if null)
     *   - stock
     *   - image  (optional swatch / variant image)
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('size')->nullable(); // 'S','M','L','XL','Free Size','7','7.5' …
            $table->string('color')->nullable(); // 'Red', 'Navy Blue', 'Black' …
            $table->string('color_hex', 10)->nullable(); // '#FF0000' — for colour swatches

            // Price & stock override
            $table->decimal('price_override', 10, 2)->nullable(); // null → use product.price
            $table->decimal('discount_override', 10, 2)->nullable(); // null → use product.discount_price
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock');

            $table->string('variant_image')->nullable(); // optional per-variant image
            $table->string('sku')->nullable()->unique(); // optional per-variant SKU

            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['product_id', 'is_active']);
        });

        // ── Attribute definitions (admin-managed) ─────────────────────────────
        // e.g. "Size", "Color", "Material" — per product_type
        Schema::create('attribute_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'Size', 'Color', 'Material'
            $table->string('slug')->unique(); // 'size', 'color', 'material'
            $table->string('type')->default('text'); // 'text','select','color','number'
            $table->json('applicable_types')->nullable(); // ["clothing","hat"] — null = all types
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_definitions');
        Schema::dropIfExists('product_variants');
    }
};
