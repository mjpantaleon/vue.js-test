<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    protected $table = 'r_bloodtype';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'blood_type';
}
