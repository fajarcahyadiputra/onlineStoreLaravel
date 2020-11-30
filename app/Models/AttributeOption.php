<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $table = "tb_attribute_options";
    protected $fillable = ['attribute_id','name'];

    public function attribute()
    {
        return $this->BelongsTo('App\Models\Attribute');
    }
}
