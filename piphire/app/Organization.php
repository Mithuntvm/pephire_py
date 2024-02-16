<?php

namespace App;

use App\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ouid', 'name', 'email', 'phone', 'address', 'city', 'state', 'zip', 'plan_id' ,'company_logo', 'deleted_at', 'total_search', 'left_search', 'is_verified'
    ];


    /**
     * Get the Plan associated with the Organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(){
        return $this->belongsTo(Plan::class);
    }


    /**
     * Get the jobs for the organization.
     */
    public function jobs()
    {
        return $this->hasMany('App\Job');
    }    

    /**
     * Get the resumes for the organization.
     */
    public function resumes()
    {
        return $this->hasMany('App\Resume');
    }

    /**
     * Get the users associated with the Organization.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    

}
