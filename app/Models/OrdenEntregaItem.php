<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEntregaItem extends Model
{
    protected $fillable = ['orden_entrega_id', 'producto_id', 'cantidad', 'lote', 'fecha_vencimiento'];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'cantidad' => 'integer'
    ];

    public function ordenEntrega()
    {
        return $this->belongsTo(OrdenEntrega::class, 'orden_entrega_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
