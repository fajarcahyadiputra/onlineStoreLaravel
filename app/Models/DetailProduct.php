<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    protected $table = 'tb_detail_product';
    protected $fillable = ['weight','width','length','size','price','width','product_id','inventory_id','sub_sku','weight','size'];
}
