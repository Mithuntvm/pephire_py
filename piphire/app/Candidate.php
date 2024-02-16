<?php

namespace App;

use App\Organizations_Hold_Resume;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{


    // protected $fillable = [
    //     'cuid', 'organization_id', 'user_id', 'resume_id', 'name', 'email', 'dob' ,'passport_no', 'visatype', 'location', 'experience', 'sex', 'married', 'photo',
    //     'role', 'role_category', 'linkedin_id', 'deleted_at'
    // ];
    // protected $fillable = [
    //     'payment_completed'
    // ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at'
    ];

    //
    /**
     * Get the user that owns the candidate.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    

    /**
     * Get the organization that owns the candidate.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * Get the resume that owns the candidate.
     */
    public function resume()
    {
        return $this->belongsTo('App\Resume');
    }

    /**
     * Get the skills that owns the candidate.
     */
    public function skills()
    {
        return $this->belongsToMany('App\Skill', 'candidate__skills');
    }

    /**
     * Get the limited skills that owns the candidate.
     */
    public function limitedskills()
    {
        return $this->skills()->limit(3);
    }

    /**
     * Get the status to hold associated with the candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function holdstat(){
        return $this->hasOne(Organizations_Hold_Resume::class);
    }

    /**
     * Get the jobs that owns the candidate.
     */
    public function jobs()
    {
        return $this->belongsToMany('App\Job', 'candidate__jobs')->withPivot('score', 'hired')->orderBy('pivot_score','desc');
    }

    /**
    *Get candidates without same details
    */

    public function scopeActive($query)
    {
        return $query->select('id','cuid','cuno','organization_id','user_id','resume_id','name_icon','name','email','phone','dob','experience','sex','photo')->groupBy('email','phone','dob','name');
    }

    /**
     * Get the companies that owns the candidate.
     */
    public function companies()
    {
        return $this->belongsToMany('App\Company', 'candidate_companies');
    }

    /**
     * Get the skills for the candidates.
     */
    public function newskills()
    {
        return $this->belongsToMany('App\Skill','candidatesubskills')->withPivot('Score')->orderBy('Score', 'desc');
    }

    /**
     * Get the resume that owns the candidate.
     */
    public function delresume()
    {
        return $this->belongsTo('App\Resume','resume_id');
    }


}
