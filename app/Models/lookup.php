<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{
    use HasFactory;

    protected $table = 'lookup';
    protected $primaryKey = 'TS_id';
    public $timestamps = false;
}
