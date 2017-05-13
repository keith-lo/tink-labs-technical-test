<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    const WITHDRAW = 1;
    const DEPOSIT = 2;
    const TRANSFER = 3;
    const SERVICE_CHARGE = 4;

    /**
     * Purpose model does not has timestamp columns (created_at, updated_at)
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get transactions for this account
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
