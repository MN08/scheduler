<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addbreaktimeandsequencecolumnintimetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('times', function (Blueprint $table) {
            $table
                ->tinyInteger('is_break')->after('end_time');
            $table
                ->tinyInteger('sequence')->nullable()->after('is_break');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
