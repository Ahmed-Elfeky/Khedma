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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // القسم الذي ينتمي إليه العرض
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');                 // اسم العرض
            $table->text('description')->nullable(); // وصف العرض
            $table->enum('type', ['percentage', 'fixed']) // نوع الخصم
                ->default('percentage');
            $table->decimal('value', 8, 2);          // قيمة الخصم
            $table->date('start_date');              // تاريخ البداية
            $table->date('end_date');                // تاريخ النهاية
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
