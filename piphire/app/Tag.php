<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    //
    use SoftDeletes;
    
    /**
     * Get the candidates that owns the skills.
     */
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate');
    }
}
