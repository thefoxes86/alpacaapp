<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\colori;

class alpaca extends Model
{
    public  function scopeCercaConNome($query, $field, $value){
	        return $query->where($field, 'LIKE', "%$value%");
	}
	public  function scopeSeparaMaschi($query){
	        return $query->where('sesso', '=', "0");
	}
	public  function scopeSeparaFemmine($query){
	        return $query->where('sesso', '=', "1");
	}
	public function colore()
    {
        return $this->hasOne(colori::class,'colore');
    }
    public function scopeGetAlpacainAllevamento($query, $field, $id)
    {
        return $query->where($field, $id);
    }
}
