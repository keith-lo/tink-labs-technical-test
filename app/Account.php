<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    /**
     * Get transactions for this account
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
