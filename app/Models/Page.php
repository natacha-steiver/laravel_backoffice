<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','name','photo','langue'];
    public function pageByLangue(){
    return $this->belongsToMany(Langue::class);
    }

}
