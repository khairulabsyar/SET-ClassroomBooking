<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teachers_id')->constrained()->onDelete('cascade');
            // $table->foreignId('teachers_id')->constrained()->nullable()->onDelete('set null');
            $table->foreignId('type_id')->constrained('classroom_types');
            $table->string('name');
            $table->date('date');
            $table->time('time_start')->default('08:00');
            $table->time("time_end")->default('10:00');
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
        Schema::dropIfExists('classrooms');
    }
}
