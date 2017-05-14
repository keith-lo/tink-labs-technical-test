<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Get transactions for this account
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
