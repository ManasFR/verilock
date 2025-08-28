<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('valid_licenses', function (Blueprint $table) {
        $table->id();
        $table->string('user_email');
        $table->string('user_license');
        $table->string('product_id');
        $table->string('domain');
        $table->boolean('active')->default(0);  // 0 for inactive, 1 for active
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valid_licenses');
    }
};
