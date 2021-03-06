<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function(Blueprint $table)
        {
            $table->increments('sched_id');
            $table->string('title');
            $table->string('start_date');
            $table->string('staff');
            $table->boolean('notify_email')->default(false);
            $table->string('email_to_notif')->nullable();
            $table->boolean('notify_sms')->default(false);
            $table->string('sms_to_notif')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }

}
