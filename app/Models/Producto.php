<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
        'stock',
        'unidad',
        'fecha_vencimiento',
        'proveedor'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'stock' => 'integer'
    ];

    // Relación con items de orden de entrada
    public function ordenEntradaItems()
    {
        return $this->hasMany(OrdenEntradaItem::class);
    }

    // Relación con items de orden de entrega
    public function ordenEntregaItems()
    {
        return $this->hasMany(OrdenEntregaItem::class);
    }

    // Método para obtener beneficiarios que han recibido este producto
    public function getBeneficiariosQueRecibieron()
    {
        return $this->ordenEntregaItems()
                    ->join('orden_entregas', 'orden_entregas.id', '=', 'orden_entrega_items.orden_entrega_id')
                    ->join('beneficiarios', 'beneficiarios.id', '=', 'orden_entregas.beneficiario_id')
                    ->select('beneficiarios.id', 'beneficiarios.nombre', 'beneficiarios.cedula')
                    ->distinct()
                    ->get();
    }

    // Método para obtener el total entregado
    public function getTotalEntregado()
    {
        return $this->ordenEntregaItems()->sum('cantidad');
    }
}
