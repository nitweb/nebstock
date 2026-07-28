<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Extend categories table:
     *  - description (for SEO / category page intro)
     *  - icon        (optional icon class or SVG string)
     *  - applicable_types (which product types can belong here)
     *
     * The self-referential parent_id for unlimited nesting already exists.
     * This migration only ADDS the new optional columns.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->nullable()->after('image');
            $table->string('icon')->nullable()->after('description');
            // Restrict which product types belong in this category (null = all)
            $table->json('applicable_types')->nullable()->after('icon');
            // e.g. ["clothing","hat"] means only those types show up here
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['description', 'icon', 'applicable_types']);
        });
    }
};
