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
}
