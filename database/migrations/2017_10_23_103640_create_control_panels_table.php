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
        DB::statement( 'DROP VIEW IF EXISTS control_panel_view' );
        DB::statement("create view control_panel_view as select id, start_time as time, 'Switch to FBLIVE' as returnMessage,'1' as status,'DMS' as type from time_schedulers union select id, end_time as time,'Switch to DMS' as returnMessage,'2' as status, 'DMS' as type from time_schedulers
                union all
                select id,start_time as time,'Show Ticker' as returnMessage,'1' as status,'Ticker' as type from tickers union select id,end_time as time,'End Ticker' as returnMessage, '2' as status,'Ticker' as type from tickers");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::statement( 'DROP VIEW IF EXISTS control_panel_view' );
    }
}
