<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ── Customer ──────────────────────────────────────────────────────
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('order_number')->unique();

            // ── Contact / Billing ─────────────────────────────────────────────
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country', 10);
            $table->string('postal_code')->nullable();

            // ── Shipping to different address ─────────────────────────────────
            $table->enum('billing_type', ['same', 'different'])->default('same');
            $table->string('ship_first_name')->nullable();
            $table->string('ship_last_name')->nullable();
            $table->string('ship_address')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_postal')->nullable();
            $table->string('ship_country', 10)->nullable();

            // ── Payment ───────────────────────────────────────────────────────
            $table->enum('payment_method', ['cod', 'bank_transfer', 'paypal', 'stripe'])->default('cod');

            // ── Financials ────────────────────────────────────────────────────
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // ── Status ────────────────────────────────────────────────────────
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');

            // ── Notes ─────────────────────────────────────────────────────────
            $table->text('order_notes')->nullable();

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // selling price (after discount)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
