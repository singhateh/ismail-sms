<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->comment('student_id=user_id');
            $table->string('id_no')->nullable();
            $table->integer('year_id')->nullable();
            $table->integer('periode_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('assign_subject_id')->nullable();
            $table->integer('exam_type_id')->nullable();
            $table->double('dt_marks')->default(0);
            $table->double('tt_marks')->default(0);
            $table->double('ef_marks')->default(0);

            $table->double('dt')->default(0);
            $table->double('tt')->default(0);
            $table->double('ef')->default(0);
            $table->double('total')->default(0);
            $table->string('grade')->nullable();
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
        Schema::dropIfExists('student_marks');
    }
}
