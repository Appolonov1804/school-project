<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'lesson_details';
    protected $guarded = [];
    protected $fillable = ['date', 'topic', 'attendance','roster_id', 'score'];

    public function roster()
    {
        return $this->belongsTo(Roster::class);
    }
}
