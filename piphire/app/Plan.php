<?php

namespace App;

use App\Plantype;
use App\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'amount', 'no_of_searches', 'puid', 'deleted_at'
    ];

    /**
     * Get the Organizations associated with the Plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    /**
     * Get the Plan Type associated with the Plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plantype(){
        return $this->belongsTo(Plantype::class);
    }    

}
