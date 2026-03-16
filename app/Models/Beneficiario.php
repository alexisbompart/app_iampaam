<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiario extends Model
{
    use HasFactory;

    protected $fillable = [
        // Datos personales
        'nombre',
        'cedula',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'nacionalidad',
        'estado_civil',
        'genero',

        // Información familiar
        'nombre_conyuge',
        'telefono_conyuge',
        'hijos',
        'familiares_cercanos',

        // Datos de contacto y ubicación
        'telefono',
        'telefono_alternativo',
        'email',
        'email_alternativo',
        'direccion',
        'estado',
        'municipio',
        'parroquia',
        'sector',
        'comunidad',
        'comuna',
        'consejo_comunal',
        'centro_electoral',
        'punto_referencia',

        // Información médica básica
        'tipo_sangre',
        'alergias',
        'medicamentos_actuales',
        'enfermedades_cronicas',
        'medico_cabecera',
        'telefono_medico',

        // Información socioeconómica detallada
        'nivel_educativo',
        'ocupacion_anterior',
        'profesion',
        'ayuda_economica',
        'ingresos', // JSON
        'gastos', // JSON

        // Información de vivienda
        'tipo_vivienda',
        'condicion_vivienda',
        'numero_habitantes',
        'materiales_construccion',
        'servicios', // JSON

        // Necesidades especiales y discapacidad
        'tiene_discapacidad',
        'discapacidad', // JSON
        'ayudas_tecnicas',
        'necesidades_especiales',

        // Información de referencia
        'persona_referencia',
        'parentesco_referencia',
        'telefono_referencia',
        'direccion_referencia',

        // Información adicional
        'observaciones',
        'actividades_formativas',
        'actividades_recreativas',
        'fecha_ingreso',
        'estado_beneficiario',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'ingresos' => 'array',
        'gastos' => 'array',
        'servicios' => 'array',
        'discapacidad' => 'array',
        'hijos' => 'integer',
        'numero_habitantes' => 'integer',
    ];

    protected $attributes = [
        'estado_beneficiario' => 'activo',
        'fecha_ingreso' => null,
        'nacionalidad' => 'Venezolana',
    ];

    // Accessor para calcular la edad
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    // Accessor para obtener ingresos como string
    public function getIngresosStringAttribute()
    {
        return $this->ingresos ? implode(', ', $this->ingresos) : 'No especificado';
    }

    // Accessor para obtener gastos como string
    public function getGastosStringAttribute()
    {
        return $this->gastos ? implode(', ', $this->gastos) : 'No especificado';
    }

    // Accessor para obtener discapacidad como string
    public function getDiscapacidadStringAttribute()
    {
        return $this->discapacidad ? implode(', ', $this->discapacidad) : 'Ninguna';
    }

    // Accessor para obtener servicios como string
    public function getServiciosStringAttribute()
    {
        return $this->servicios ? implode(', ', $this->servicios) : 'No especificado';
    }

    // Scope para filtrar por estado
    public function scopeActivos($query)
    {
        return $query->where('estado_beneficiario', 'activo');
    }

    // Scope para filtrar por género
    public function scopePorGenero($query, $genero)
    {
        return $query->where('genero', $genero);
    }

    // Scope para buscar por nombre o cédula
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('cedula', 'like', "%{$termino}%");
    }
}
