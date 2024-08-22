<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'students';
    protected $guarded = [];
    protected $fillable = ['student','group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function groupLessons()
    {
        return $this->belongsToMany(GroupLesson::class, 'group_lesson_student')
                    ->withPivot('attendance', 'score');
    }
}
