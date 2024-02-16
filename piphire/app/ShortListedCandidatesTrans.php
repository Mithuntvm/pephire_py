<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class ShortListedCandidatesTrans extends Model
{
	protected $table = 'shortlisted_candidates_trans';

	/**
	 * Listen for save event
	 *
	 * @return void
	 */
	public static function boot() {

	    parent::boot();

	    static::creating(function($model) {
	    	$model->sluid = Str::uuid()->toString();
	    });
	}

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function candidate()
	{
	    return $this->belongsTo('App\Candidate', 'candidate_id');
	}

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function job()
	{
	    return $this->belongsTo('App\Job', 'job_id');
	}
}


