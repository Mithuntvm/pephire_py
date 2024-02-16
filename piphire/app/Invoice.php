<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razorpay_payment_id', 'status', 'payment_method', 'description',
        'payment_description', 'razorpay_order_id', 'user_id',
        'email', 'contact', 'fee', 'tax', 'amount', 'order_id', 'plan_id', 'plantype_id',
        'created_at', 'updated_at'
    ];

    /**
     * Get the Order associated with the Invoice.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * Get the User who initiated the transaction to generate the Invoice.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the plan associated with the Invoice.
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }

    /**
     * Get the plantype associated with the Invoice.
     */
    public function plantype()
    {
        return $this->belongsTo('App\Plantype');
    }    

}
