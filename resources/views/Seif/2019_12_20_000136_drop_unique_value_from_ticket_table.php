<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueValueFromTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['Event_id']);
            $table->dropUnique(['customer_id', 'Event_id']);
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('Event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['customer_id', 'Event_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['Event_id']);
        });
    }
}
