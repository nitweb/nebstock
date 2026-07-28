<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->unique();
            $table->string('coupon_type')->default('fixed'); // fixed | percent
            $table->decimal('coupon_value', 10, 2);
            $table->decimal('minimum_amount', 10, 2)->default(0); // এর নিচে order করলে কুপন কাজ করবে না
            $table->integer('usage_limit')->nullable(); // null = unlimited | মোট কতবার use করা যাবে
            $table->integer('used_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
