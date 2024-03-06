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
    protected $fillable = ['email', 'name', 'is_confirmed', 'salary', 'taxes'];

    public function rosters() 
    {
        return $this->hasMany(Roster::class, 'id');
    }

    public function reports() 
    {
        return $this->hasMany(Report::class, 'id');
    }
}
