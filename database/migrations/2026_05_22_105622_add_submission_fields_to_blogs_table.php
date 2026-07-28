<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // blog_status এ 'pending' যোগ করতে হবে
            $table->enum('blog_status', ['active', 'inactive', 'pending', 'rejected'])
                ->default('active')
                ->change();

            // কে submit করেছে (users table)
            $table->unsignedBigInteger('submitted_by')->nullable()->after('blog_published_by');
            $table->timestamp('submitted_at')->nullable()->after('submitted_by');
            // admin reject করলে কারণ
            $table->text('rejection_reason')->nullable()->after('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->enum('blog_status', ['active', 'inactive'])->default('active')->change();
            $table->dropColumn(['submitted_by', 'submitted_at', 'rejection_reason']);
        });
    }
};
