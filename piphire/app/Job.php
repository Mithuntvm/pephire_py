<?php

namespace App;
use App\BulkJob;
use App\User;
use App\Organization;
use App\ShortlistedCandidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'juid', 'organization_id', 'user_id', 'name', 'description','location','job_role_category','offered_ctc','job_role','joining_date','max_experience', 'experience_min', 'experience_max', 'qualification','bulk_job_id', 'vacant_positions', 'ruid', 'deleted_at'
    ];


    /**
     * Get the User associated with the Job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }


    /**
     * Get the Organization associated with the Job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function bulkJob(){
        return $this->belongsTo(BulkJob::class);
    }

    /**
     * Get the candidates that owns the jobs.
     */
    public function candidates()
    {
        return $this->belongsToMany('App\Candidate','candidate__jobs')
                    ->whereNotNull('name')
                    ->whereNotNull('phone')
                    ->withPivot('score', 'hired')
                    ->orderBy('pivot_score','desc');

    }

    /**
     * Get the shortlisted_candidates associated with the Skill.
     */
    public function shortlisted_candidates()
    {
        return $this->hasMany('App\ShortlistedCandidate');
    }
}


