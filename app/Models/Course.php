<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course_types';
    protected $guarded = [];
    protected $fillable = ['name'];

    public function rosters()
    {
        return $this->hasMany(Roster::class, 'type_id', 'id');
    }

}
