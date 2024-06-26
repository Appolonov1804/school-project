<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reports';
    protected $guarded = [];
    protected $fillable = ['teachers_id', 'student','course', 'topic', 'date', 'lesson_description', 'comments'];

    public function teachers() 
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }

}
