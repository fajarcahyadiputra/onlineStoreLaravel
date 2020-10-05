<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'tb_product_images';
    protected $fillable = [];

    public function product()
    {
        return BelongsTo('App\Models\Product','product_id');
    }
}
