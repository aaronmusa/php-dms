<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlPanelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'DROP VIEW IF EXISTS control_panels' );
        DB::statement("create view control_panels as select id, start_time as time, 'Switch to FBLIVE' as returnMessage from time_schedulers union select id, end_time as time,'Switch to DMS' as returnMessage from time_schedulers
                union all
                select id,start_time as time,'Show Ticker' as returnMessage from tickers union select id,end_time as time,'End Ticker' as returnMessage from tickers");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::statement( 'DROP VIEW control_panels' );
    }
}
