<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'membership';
    protected $guarded = [];
    protected $fillable = ['roster_id', 'membership'];

    public function roster()
    {
        return $this->belongsTo(Roster::class, 'roster_id');
    }

}
