<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategory extends Model
{
    protected $fillable = [];
    protected $table    = 'tb_categories';


    public function parent()
    {
    	return $this->belongsTo('App\Models\ParentCategory','parent_id');
    }
    public function products()
    {
    	return $this->belongsToMany('App\Models\Product','tb_product_categories');
    }
}
