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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Cruciaal voor Filament!
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2); 
            $table->string('image')->nullable();
            $table->integer('bonus_percentage')->nullable(); 
            $table->boolean('is_featured')->default(false); // Voor de 'uitgelichte' items
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps(); // Handig om te zien wanneer een product is toegevoegd
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
