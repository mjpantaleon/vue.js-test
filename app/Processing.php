<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Processing extends Model
{
    protected $table = 'bloodproc';
    public $timestamps = false;
    public $primaryKey = 'bloodproc_no';
    public $incrementing = false;
}
