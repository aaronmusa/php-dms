<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectionPerPcView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'DROP VIEW IF EXISTS connection_per_pc_view' );
        DB::statement("create view connection_per_pc_view as select id,start_time,end_time,'No Message' as message,mac_address from time_schedulers union select id,start_time,end_time,message,mac_address from tickers");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_per_pc_view');
    }
}
