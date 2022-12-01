<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepAndNatureToComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('dep')->nullable(); 
            $table->string('nature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            Schema::dropIfExists('complaints');            
        });
    }
}
