<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMacaadressColumnInTimeschedulers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_schedulers', function (Blueprint $table) {
            $table->string('mac_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_schedulers', function (Blueprint $table) {
            Schema::dropIfExists('time_schedulers');
        });
    }
}
