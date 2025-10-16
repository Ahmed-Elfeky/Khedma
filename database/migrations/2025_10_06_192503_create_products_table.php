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
          $table->id();
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('cascade');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0); //الكميه المتوفره
            $table->string('image')->nullable();
            $table->decimal('discount', 8, 2)->default(0);
            $table->string('guarantee')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
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
