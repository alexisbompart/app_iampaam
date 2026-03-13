<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEntradaItem extends Model
{
    protected $fillable = ['orden_entrada_id', 'producto_id', 'cantidad', 'lote', 'fecha_vencimiento'];

    public function orden()
    {
        return $this->belongsTo(OrdenEntrada::class, 'orden_entrada_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
