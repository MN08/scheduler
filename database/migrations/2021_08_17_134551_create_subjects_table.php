<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table
                ->bigIncrements('id');
            $table
                ->string('name', 100);
            $table
                ->string('code', 15);
            $table
                ->tinyInteger('grade');
            $table
                ->tinyInteger('available_time');
            $table
                ->timestamps();
            $table
                ->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
