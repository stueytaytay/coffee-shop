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
        Schema::table('coffee_types', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_partner_id')->after('profit_margin');
            $table->foreign('shipping_partner_id')->references('id')->on('shipping_partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('coffee_types', function (Blueprint $table) {
            $table->dropForeign(['shipping_partner_id']);
            $table->dropColumn('shipping_partner_id');
        });
    }
};
