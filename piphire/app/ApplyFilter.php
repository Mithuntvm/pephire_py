<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyFilter extends Model
{
	protected $table = 'apply_filter';

	/**
	 * Get the candidates associated with the Skill.
	 */
	public function candidate()
	{
	    return $this->belongsTo('App\Candidate', 'allotted_candidate_id');
	}
}
