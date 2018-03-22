<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'r_component';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'component_cd';
    
}
