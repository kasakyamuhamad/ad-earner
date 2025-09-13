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
    Schema::table('ad_views', function (Blueprint $table) {
        $table->integer('earned_coins')->default(0)->after('ad_id');
    });
}

public function down()
{
    Schema::table('ad_views', function (Blueprint $table) {
        $table->dropColumn('earned_coins');
    });
}

};
