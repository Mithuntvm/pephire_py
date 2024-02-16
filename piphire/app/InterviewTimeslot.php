<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewTimeslot extends Model
{
	protected $table = 'interview_timeslots';

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function candidate()
	{
	    return $this->belongsTo('App\Candidate', 'allotted_candidate_id');
	}
}
