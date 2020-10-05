<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
	protected $table = 'tb_parent_category';
	protected $fillable = [];

	public function childs()
	{
		return $this->hasMany('App\Models\Kategory','parent_id');
	}
}
