<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roster extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'rosters';
    protected $guarded = [];
    protected $fillable = ['teachers_id', 'type_id', 'student','course', 'time', 'schedule'];

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }

    public function lessonDetails()
    {
        return $this->hasMany(LessonDetail::class);
    }

    public function courseTypes()
    {
        return $this->belongsTo(Course::class, 'type_id', 'id');
    }
}
