<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    //
    protected $table = 'subskill_master';
    use SoftDeletes;
    
    /**
     * Get the candidates that owns the skills.
     */
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate','candidatesubskills');
    }
}
