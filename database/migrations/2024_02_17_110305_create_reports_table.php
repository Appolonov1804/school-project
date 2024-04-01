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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('student');
            $table->string('course');
            $table->string('topic');
            $table->date('date');
            $table->string('lesson_description');
            $table->string('comments');
            $table->timestamps();

            $table->softDeletes();

            $table->unsignedBigInteger('teachers_id')->nullable();

            $table->index('teachers_id', 'report_teachers_idx');

            $table->foreign('teachers_id', 'reports_teachers_fk')->on('teachers')->references('id'); 
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
