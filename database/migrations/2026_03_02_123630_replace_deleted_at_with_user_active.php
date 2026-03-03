<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Voeg user_active kolom toe
            $table->boolean('user_active')->default(true)->after('is_admin');
            
            // Verwijder deleted_at kolom als die bestaat
            if (Schema::hasColumn('users', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Herstel deleted_at
            $table->softDeletes();
            
            // Verwijder user_active
            $table->dropColumn('user_active');
        });
    }
};