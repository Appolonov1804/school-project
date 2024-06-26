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
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->string('student');
            $table->string('course');
            $table->string('topic');
            $table->date('date');
            $table->string('lesson_description');
            $table->string('comments');
            $table->timestamps();

            $table->softDeletes();
            $table->index('teachers_id', 'report_teachers_idx');
            $table->foreign('teachers_id', 'reports_teachers_fk')->on('teachers')->references('id'); 
            
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
