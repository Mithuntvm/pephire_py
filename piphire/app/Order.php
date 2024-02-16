<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'status'
    ];

    /**
     * Get the User associated with the Order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the Plan associated with the Order.
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }
}
