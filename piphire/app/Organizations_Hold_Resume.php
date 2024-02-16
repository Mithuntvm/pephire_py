<?php

namespace App;

use App\Resume;
use App\Candidate;
use App\Organization;
use Illuminate\Database\Eloquent\Model;

class Organizations_Hold_Resume extends Model
{
    //

    protected $table = 'organizations__hold__resumes';

    /**
     * Get the Candidate associated with the Hold.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the Resume associated with the Hold.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resume(){
        return $this->belongsTo(Resume::class);
    }

    /**
     * Get the Organization associated with the Hold.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(){
        return $this->belongsTo(Organization::class);
    }


}
