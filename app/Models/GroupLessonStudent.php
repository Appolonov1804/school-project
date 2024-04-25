<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GroupLessonStudent extends Model
{
    use HasFactory;

    protected $table = 'group_lesson_student';

    protected $fillable = ['group_lesson_id', 'student_id', 'attendance'];
}
