<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrialLesson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'trial_lesson';
    protected $guarded = [];
    protected $fillable = ['teachers_id', 'date', 'student', 'course', 'type', 'time', 'form' ];

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }
}
