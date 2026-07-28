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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('blog_image');
            $table->string('blog_title');
            $table->string('blog_slug')->unique();
            $table->text('blog_short_description');
            $table->longText('blog_long_description');
            $table->unsignedBigInteger('blog_category_id');
            $table->string('blog_tags')->nullable();
            $table->foreignId('blog_published_by')->constrained('admins')->onDelete('cascade')->nullable();
            $table->date('blog_published_date');
            $table->enum('blog_status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
