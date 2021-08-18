<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_schedules', function (Blueprint $table) {
            $table
                ->bigIncrements('id');
            $table
                ->unsignedBigInteger('teacher_subject_id');
            $table
                ->unsignedBigInteger('time_id');
            $table
                ->unsignedBigInteger('class_id');
            $table
                ->unsignedBigInteger('school_year_id');
            $table
                ->timestamps();
            $table
                ->softDeletes();

            $table
                ->foreign('teacher_subject_id')
                ->references('id')
                ->on('teacher_subjects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('time_id')
                ->references('id')
                ->on('times')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('school_year_id')
                ->references('id')
                ->on('school_years')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_schedules');
    }
}
