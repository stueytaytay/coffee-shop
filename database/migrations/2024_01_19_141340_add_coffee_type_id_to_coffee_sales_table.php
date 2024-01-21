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
        Schema::table('coffee_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('coffee_type_id')->after('selling_price');
            $table->foreign('coffee_type_id')->references('id')->on('coffee_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('coffee_sales', function (Blueprint $table) {
            $table->dropForeign(['coffee_type_id']);
            $table->dropColumn('coffee_type_id');
        });
    }
};
