<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantype extends Model
{
    //
    use SoftDeletes;
    /**
     * Get the plans for the Plantype.
     */
    public function plans()
    {
        return $this->hasMany('App\Plan');
    }
}
