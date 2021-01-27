<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\alpaca;

class colori extends Model
{
   public function alpaca()
    {
        return $this->hasMany(alpaca::class);
    }
}
