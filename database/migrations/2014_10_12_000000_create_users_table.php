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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('otp_code')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('role', ['user', 'company','admin'])->default('user');
            // بيانات الشركة (في حالة كان user_type = company)
            $table->string('address')->nullable();           // العنوان
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->string('website')->nullable();           // الموقع الإلكتروني
            $table->string('commercial_registration')->nullable(); // السجل التجاري
            $table->string('tax_number')->nullable();        // الرقم الضريبي
            $table->string('logo')->nullable();              // شعار الشركة (صورة)
            // خطوط الطول ودوائر العرض
            $table->decimal('latitude', 10, 7)->nullable();   // مثال: 30.044420
            $table->decimal('longitude', 10, 7)->nullable();  // مثال: 31.235712
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
