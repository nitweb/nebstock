<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // ---------- Basic Info ----------
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            // ---------- Pricing ----------
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            // ---------- Stock ----------
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock'])->default('in_stock')->index();

            // ---------- Media (primary only; gallery → product_media) ----------
            $table->string('cover_image')->nullable();
            $table->string('pdf_sample')->nullable();   // free preview PDF
            $table->string('pdf_file')->nullable();     // full PDF (paid)

            // ---------- Flags ----------
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active')->index();
            $table->boolean('is_featured')->default(false)->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
