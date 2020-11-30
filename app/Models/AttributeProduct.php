<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    protected $table = 'tb_attribute_product';
    protected $fillable = ['attribute','attribute_value'];
}
