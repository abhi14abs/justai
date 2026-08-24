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
            if (!Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token', 80)->nullable()->unique()->after('affiliate_code');
            }
            if (!Schema::hasColumn('users', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')->nullable()->after('api_token');
            }
            if (!Schema::hasColumn('users', 'brand_workspaces')) {
                $table->json('brand_workspaces')->nullable()->after('owner_id');
            }
            if (!Schema::hasColumn('users', 'team_members')) {
                $table->json('team_members')->nullable()->after('brand_workspaces');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['api_token', 'owner_id', 'brand_workspaces', 'team_members']);
        });
    }
};
