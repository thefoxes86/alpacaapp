<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class allevamento extends Model
{
	protected $casts = [
        'galleria' => 'array'
    ];
    public  function scopeCercaConNome($query, $field, $value){
	        return $query->where('nome', 'LIKE', "%$value%");
	}
}
