<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Transaction status flags
     */
    const PENDING = 0;
    const COMPLETED = 1;
    const FAIL = 2;

    /**
     * Get the account of this transaction
     */
    public function account(){
        return $this->belongsTo('App\Account');
    }

    /**
     * Get the purpose of this transaction
     */
    public function purpose(){
        return $this->belongsTo('App\Purpose');
    }
}
