<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_details', function (Blueprint $table) {
            $table->id();
            $table->string('notificationId')->nullable();
            $table->string('assignUsers')->nullable();
            $table->string('event_name')->nullable();
            $table->string('url')->nullable();
            $table->string('complaint_id')->nullable();
            $table->string('userid')->nullable();
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
        Schema::dropIfExists('notification_details');
    }
}
