<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrada extends Model
{
    protected $fillable = ['fecha', 'proveedor', 'observaciones'];

    public function items()
    {
        return $this->hasMany(OrdenEntradaItem::class);
    }
}
