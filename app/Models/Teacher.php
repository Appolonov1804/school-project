<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'teachers';
    protected $guarded = [];
    protected $fillable = ['email', 'name', 'position', 'user_id', 'salary', 'taxes'];

    public function rosters()
    {
        return $this->hasMany(Roster::class, 'teachers_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'teachers_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'teachers_id');
    }

    public function trialLesson()
    {
        return $this->hasMany(TrialLesson::class, 'teachers_id');
    }

}
