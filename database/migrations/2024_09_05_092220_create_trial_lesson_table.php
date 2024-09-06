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
        Schema::create('trial_lesson', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->date('date');
            $table->string('student');
            $table->string('course');
            $table->string('type');
            $table->string('time');
            $table->string('form');

            $table->softDeletes();
            $table->index('teachers_id', 'trial_teachers_idx');
            $table->foreign('teachers_id', 'trial_teachers_fk')->on('teachers')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trial_lesson', function (Blueprint $table) {
            $table->dropForeign(['teachers_id']);
        });
        Schema::dropIfExists('trial_lesson');
    }
};
