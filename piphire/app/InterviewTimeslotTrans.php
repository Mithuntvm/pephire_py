<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewTimeslotTrans extends Model
{
	protected $table = 'interview_timeslots_trans';

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function candidate()
	{
	    return $this->belongsTo('App\Candidate', 'allotted_candidate_id');
	}
}
