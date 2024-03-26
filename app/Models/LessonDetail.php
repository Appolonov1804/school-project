<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonDetail extends Model
{
    protected $fillable = ['date', 'topic', 'attendance','roster_id'];

    public function roster()
    {
        return $this->belongsTo(Roster::class);
    }
}