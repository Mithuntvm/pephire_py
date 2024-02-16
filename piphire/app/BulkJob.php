<?php

namespace App;

use App\Job;
use Illuminate\Database\Eloquent\Model;

class BulkJob extends Model
{
    protected $fillable = [
        'bjuid', 'deleted_at', 'title'
    ];

    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function getJobs($user_id, $organization_id){
        return $this->jobs()->where('user_id','=', $user_id)->where('organization_id', '=',$organization_id);
    }
}
