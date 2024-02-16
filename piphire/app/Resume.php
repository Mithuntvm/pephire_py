<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    //
    use SoftDeletes;
    /**
     * Get the organization that owns the resume.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * Get the candidates for the resumes.
     */
    public function candidates()
    {
        return $this->hasMany('App\Candidate');
    }


    /**
     * Get the Skill Main Categories associated with the Resume.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\ResumeCategory');
    }

}
