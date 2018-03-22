<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    protected $table = 'rcountry';
    protected $primaryKey = 'countrycode';
    public $timestamps = false;
    public $incrementing = false;
}
