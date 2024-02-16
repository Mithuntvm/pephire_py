<?php

namespace App;

use App\Resume;
use App\Candidate;
use App\Organization;
use Illuminate\Database\Eloquent\Model;

class SkillMaster extends Model
{
    //

    protected $table = 'skill_master';

    /**
     * Get the candidate associated with the Skill.
     */
    public function candidate()
    {
        return $this->belongsToMany('App\Candidate','candidateskills','skill_id');
    }

}