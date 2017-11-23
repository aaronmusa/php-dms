<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertColumnStatusInConnection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->text('socket_id');
            $table->boolean('status')->default(false);
            $table->string('mac_address');
            $table->string('local_time');
            $table->string('server_time');
            $table->dropColumn('id');
            $table->string('name');
            $table->text('livestream_url');
            $table->text('ticker_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connections', function (Blueprint $table) {
            Schema::dropIfExists('connections');
        });
    }
}
