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
        Schema::create('group_lesson_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_lesson_id');
            $table->unsignedBigInteger('student_id');
            $table->string('attendance')->nullable();
            $table->timestamps();

            // Внешние ключи
            $table->foreign('group_lesson_id')->references('id')->on('group_lessons')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_lesson_student');
    }
};
