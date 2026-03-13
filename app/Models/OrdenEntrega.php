<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEntrega extends Model
{
    protected $fillable = ['fecha', 'beneficiario_id', 'observaciones'];

    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }

    public function items()
    {
        return $this->hasMany(OrdenEntregaItem::class);
    }
}
