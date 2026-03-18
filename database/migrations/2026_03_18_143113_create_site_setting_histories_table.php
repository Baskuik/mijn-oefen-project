<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_setting_histories', function (Blueprint $table) {
            $table->id();
            $table->json('snapshot');                  // alle key/value pairs op het moment van opslaan
            $table->string('page_label')->nullable();  // welke pagina er bewerkt werd
            $table->foreignId('saved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_setting_histories');
    }
};