<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterviewerDetails extends Model
{
	protected $table = 'interviewer_details';

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function candidate()
	{
	    return $this->belongsTo('App\Candidate', 'allotted_candidate_id');
	}
}
