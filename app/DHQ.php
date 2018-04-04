<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DHQ extends Model
{
    protected $table = 'r_question';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = false;
}
