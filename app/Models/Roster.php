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
    protected $fillable = ['teachers_id', 'student','course','topic','date','attendance'];

    public function teachers() 
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }

    public function lessonDetails()
{
    return $this->hasMany(LessonDetail::class);
}
}
