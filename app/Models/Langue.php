<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    //use HasFactory;
    //for piece_has_pages

    public $timestamps = false;
    protected $fillable = ['id','name','iso','short_name','page_id'];
    public function pageByLangue(){
    return $this->belongsToMany(Page::class)->withPivot(['page_id',"langue_id"]);
    }

    public function page()
    {
    return $this->belongsToMany(Page::class)->withPivot(['page_id',"langue_id"]);

      }




}
