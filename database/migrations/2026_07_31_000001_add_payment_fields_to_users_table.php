<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->string('bkash_number')->nullable()->after('payment_status');
            $table->string('bkash_transaction_id')->nullable()->unique()->after('bkash_number');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('bkash_transaction_id');
            $table->timestamp('payment_approved_at')->nullable()->after('payment_amount');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'bkash_number', 'bkash_transaction_id', 'payment_amount', 'payment_approved_at']);
        });
    }
};
