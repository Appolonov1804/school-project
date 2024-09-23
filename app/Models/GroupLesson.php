<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GroupLesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'group_lessons';
    protected $guarded = [];
    protected $fillable = ['date', 'topic', 'time', 'group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_lesson_student')
                    ->withPivot('attendance', 'score')->withTrashed();
    }

    public function attendance()
    {
        return $this->hasMany(GroupLessonStudent::class, 'group_lesson_id');
    }
}

