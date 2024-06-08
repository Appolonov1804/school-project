<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $table = 'groups';
    protected $guarded = [];
    protected $fillable = ['teachers_id', 'course'];

    public function teachers() 
    {
        return $this->belongsTo(Teacher::class, 'teachers_id', 'id');
    }

    public function groupLessons()
    {
    return $this->hasMany(GroupLesson::class);
    }
    
    public function students() 
    {
        return $this->hasMany(Student::class);
    }
}
