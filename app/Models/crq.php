<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crq;

class Crq extends Model
{
    use HasFactory;

    protected $table = 'crq';
    protected $primaryKey = 'CRQ_id';
    protected $fillable =[
        'p_img'
    ];
    public $timestamps = false;

    // public function images(){
    //     return $this->hasMany(Crq::class);
    // }
}
