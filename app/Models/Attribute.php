<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'tb_attributes';
    protected $fillable = ['code','name','type','validation','is_required','is_unique','is_filterable','is_configurable'];

    public static function type()
    {
        return [
            'text' => 'text',
            'textarea' => 'Textarea',
            'price' => 'Price',
            'boolean' => 'Boolean',
            'select'  => 'Select',
            'datetime' => 'Datetime',
            'date'     => 'Date'
        ];
    }
    public static function booleanOptions()
    {
        return [
            1 => 'Yes',
            0 => 'No'
        ];
    }
    public static function validation()
    {
        return [
            'number' => 'Number',
            'decimal'=> 'Decimal',
            'email'  => 'Email',
            'url'    => 'Url'
        ];
    }
    public function atributeOption()
    {
        return $this->HasMany('App\Models\AttributeOption','attribute_id');
    }
}
