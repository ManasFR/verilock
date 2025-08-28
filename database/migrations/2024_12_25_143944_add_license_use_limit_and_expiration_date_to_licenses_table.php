<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenseUseLimitAndExpirationDateToLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->integer('license_use_limit')->after('product_name')->default(1);
            $table->date('license_expiration_date')->nullable()->after('license_use_limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn(['license_use_limit', 'license_expiration_date']);
        });
    }
}
