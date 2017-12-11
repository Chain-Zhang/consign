<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendeeToTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transport', function (Blueprint $table) {
            $table->string('sendee_name');
            $table->string('sendee_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transport', function (Blueprint $table) {
            $table->dropColumn('sendee_name');
            $table->dropColumn('sendee_phone');
        });
    }
}
