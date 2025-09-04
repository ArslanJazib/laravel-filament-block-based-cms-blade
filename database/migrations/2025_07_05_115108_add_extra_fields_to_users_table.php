<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // User-specific fields
            $table->string('username')->unique()->after('email');

            // Foreign key to roles table
            $table->unsignedBigInteger('role_id')->nullable()->after('username');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

            // Contact info
            $table->string('phone')->nullable()->after('email_verified_at');

            // Security
            $table->json('security_questions')->nullable()->after('password');

            // Business info
            $table->string('company_name')->nullable()->after('security_questions');
            $table->string('job_title')->nullable()->after('company_name');

            // Foreign key to countries table
            $table->unsignedBigInteger('country_id')->nullable()->after('job_title');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['country_id']);

            $table->dropColumn([
                'username',
                'role_id',
                'phone',
                'security_questions',
                'company_name',
                'job_title',
                'country_id',
            ]);
        });
    }
};