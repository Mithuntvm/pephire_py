<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Get the candidates that owns the skills.
     */
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate','candidate_companies');
    }


}
