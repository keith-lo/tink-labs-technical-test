<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    /**
     * Purpose model does not has timestamp columns (created_at, updated_at)
     *
     * @var bool
     */
    public $timestamps = false;
}
