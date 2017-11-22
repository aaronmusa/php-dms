<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterViewControlPanelView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement( 'DROP VIEW IF EXISTS control_panel_view' );
        DB::statement("create view control_panel_view as select distinct a.id,a.time,a.returnMessage,a.status,a.type,a.mac_address,case when a.mac_address = 'all' then 'to all' else b.name end as name  from(select id, start_time as time, 'Switch to FBLIVE' as returnMessage,'1' as status,'DMS' as type,mac_address from time_schedulers union select id, end_time as time,'Switch to DMS' as returnMessage,'2' as status, 'DMS' as type,mac_address from time_schedulers
                union all
                select id,start_time as time,'Show Ticker' as returnMessage,'1' as status,'Ticker' as type,mac_address from tickers union select id,end_time as time,'End Ticker' as returnMessage, '2' as status,'Ticker' as type,mac_address from tickers) as a,connections b where a.mac_address = b.mac_address or a.mac_address = 'all'");
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
