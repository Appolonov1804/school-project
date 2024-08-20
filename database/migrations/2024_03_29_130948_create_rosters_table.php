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
        $table->unsignedBigInteger('teachers_id')->nullable();
        $table->string('student');
        $table->string('course');
        $table->string('time');
        $table->timestamps();

        $table->softDeletes();
        $table->index('teachers_id', 'roster_teachers_idx');
    });


        Schema::table('rosters', function (Blueprint $table) {
            $table->foreign('teachers_id')->references('id')->on('teachers');
        });
    }

    public function down(): void
    {
        Schema::table('rosters', function (Blueprint $table) {
            $table->dropForeign(['teachers_id']);
        });

        Schema::dropIfExists('rosters');
    }
};
