<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'tb_products';
    protected $fillable = [];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
    public function categories()
    {
    	return $this->belongsToMany('App\Models\Kategory','tb_product_categories');
    }
    public static function statues()
    {
    	return [
    		0 => 'draf',
    		1 => 'active',
    		2 => 'inactive',
    	];
    }
    public function images()
    {
        return HasMany('App\Models\ProductImage','product_id');
    }
}
