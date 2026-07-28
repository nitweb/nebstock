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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_header_logo');
            $table->string('site_footer_logo');
            $table->string('site_address');
            $table->string('site_email');
            $table->string('site_email_alt')->nullable();
            $table->string('site_phone');
            $table->string('site_phone_alt')->nullable();
            $table->text('site_description')->nullable();
            $table->string('site_copyright');
            $table->text('site_google_map')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
