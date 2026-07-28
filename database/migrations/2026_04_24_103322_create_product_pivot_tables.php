<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ── author_product (pivot) ───────────────────────────────────────────────────
return new class extends Migration
{
    public function up(): void
    {
        // Pivot: product ↔ author (many-to-many)
        Schema::create('author_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->primary(['product_id', 'author_id']);
        });

        // Pivot: category ↔ product (many-to-many)
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->primary(['product_id', 'category_id']);
        });

        // 1-to-1: product specifications
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title')->nullable();          // book title (if different)
            $table->string('publisher')->nullable();
            $table->string('edition')->nullable();
            $table->unsignedSmallInteger('number_of_pages')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->default('Bengali');
            $table->string('isbn')->nullable()->index();
            $table->year('publication_year')->nullable();
            $table->timestamps();
        });

        // 1-to-many: product gallery images
        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['image', 'pdf_sample', 'pdf'])->default('image');
            $table->string('file_path');
            $table->boolean('is_primary')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 1-to-many: "Also Available On" (Rokomari, Amazon, etc.)
        Schema::create('related_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('platform_name');             // e.g. "Rokomari", "Amazon"
            $table->string('platform_url');
            $table->decimal('platform_price', 10, 2)->nullable();
            $table->timestamps();
        });

        // Product reviews
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->tinyInteger('rating');               // 1-5
            $table->text('comment');
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('related_products');
        Schema::dropIfExists('product_media');
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('author_product');
    }
};
