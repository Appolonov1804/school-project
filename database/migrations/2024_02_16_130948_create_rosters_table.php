<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->string('student');
            $table->string('course');
            $table->string('topic');
            $table->date('date');
            $table->string('attendance');
            $table->timestamps();

            $table->softDeletes();

            $table->unsignedBigInteger('teacher_id')->nullable(); // Измените имя столбца на teacher_id

            $table->index('teacher_id', 'roster_teachers_idx');
    
            $table->foreign('teacher_id', 'rosters_teachers_fk')->on('teachers')->references('id');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
