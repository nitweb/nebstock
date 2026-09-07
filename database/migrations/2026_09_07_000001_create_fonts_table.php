<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fonts', function (Blueprint $table) {
            $table->id();

            // ---------- Basic Info ----------
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('description')->nullable();

            // ---------- Font Meta (1001fonts style) ----------
            $table->string('designer')->nullable();
            $table->string('license')->default('free')->index(); // free, personal_use, premium, open_font_license
            $table->string('style')->nullable(); // e.g. Sans Serif, Script, Display

            // ---------- Files ----------
            // Original filename is preserved automatically (slug of font name) — set by controller.
            $table->string('font_file');           // the downloadable font file (ttf/otf/woff/zip)
            $table->string('preview_image')->nullable(); // rendered specimen image shown on cards

            // ---------- Stats / Flags ----------
            $table->unsignedInteger('downloads_count')->default(0);
            $table->boolean('is_featured')->default(false)->index();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fonts');
    }
};
