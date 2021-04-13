<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    //use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','page','titre','contenu'];
    public function page(){
    return $this->belongsTo(Page::class);

    }
}
