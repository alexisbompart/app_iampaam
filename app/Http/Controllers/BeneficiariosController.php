<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BeneficiariosController extends Controller
{
    public function index()
    {
        $query = Beneficiario::query();

        // Búsqueda por nombre o cédula
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('cedula', 'like', "%{$search}%");
            });
        }

        // Filtros
        if (request('filter') == 'activos') {
            $query->where('estado_beneficiario', 'activo');
        } elseif (request('filter') == 'inactivos') {
            $query->where('estado_beneficiario', 'inactivo');
        }

        // Ordenar por fecha de creación descendente
        $beneficiarios = $query->with('ordenEntregas.items.producto')->orderBy('created_at', 'desc')->paginate(15);

        return view('beneficiarios.index', compact('beneficiarios'));
    }

    public function create()
    {
        return view('beneficiarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Datos personales
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:beneficiarios,cedula',
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(60)->format('Y-m-d'),
            'lugar_nacimiento' => 'nullable|string|max:255',
            'nacionalidad' => 'nullable|string|max:100',
            'estado_civil' => 'required|in:soltero,casado,divorciado,viudo',
            'genero' => 'required|in:masculino,femenino,otro',

            // Información familiar
            'nombre_conyuge' => 'nullable|string|max:255',
            'telefono_conyuge' => 'nullable|string|max:20',
            'hijos' => 'nullable|integer|min:0',
            'familiares_cercanos' => 'nullable|string|max:1000',

            // Datos de contacto y ubicación
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'email_alternativo' => 'nullable|email|max:255',
            'direccion' => 'required|string|max:500',
            'estado' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'parroquia' => 'nullable|string|max:100',
            'sector' => 'nullable|string|max:100',
            'comunidad' => 'nullable|string|max:255',
            'comuna' => 'nullable|string|max:255',
            'consejo_comunal' => 'nullable|string|max:255',
            'centro_electoral' => 'nullable|string|max:255',
            'punto_referencia' => 'nullable|string|max:255',

            // Información médica básica
            'tipo_sangre' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergias' => 'nullable|string|max:500',
            'medicamentos_actuales' => 'nullable|string|max:1000',
            'enfermedades_cronicas' => 'nullable|string|max:1000',
            'medico_cabecera' => 'nullable|string|max:255',
            'telefono_medico' => 'nullable|string|max:20',

            // Información socioeconómica detallada
            'nivel_educativo' => 'nullable|in:ninguno,primaria,secundaria,tecnico,universitario,postgrado',
            'ocupacion_anterior' => 'nullable|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'ayuda_economica' => 'nullable|in:si,no',
            'ingresos' => 'nullable|array',
            'gastos' => 'nullable|array',

            // Información de vivienda
            'tipo_vivienda' => 'required|in:casa,apartamento,otro',
            'condicion_vivienda' => 'nullable|in:propia,alquilada,prestada',
            'numero_habitantes' => 'nullable|integer|min:1',
            'materiales_construccion' => 'nullable|string|max:255',
            'servicios' => 'nullable|array',

            // Necesidades especiales y discapacidad
            'tiene_discapacidad' => 'nullable|in:si,no',
            'discapacidad' => 'nullable|array',
            'ayudas_tecnicas' => 'nullable|string|max:500',
            'necesidades_especiales' => 'nullable|string|max:500',

            // Información de referencia
            'persona_referencia' => 'required|string|max:255',
            'parentesco_referencia' => 'required|string|max:100',
            'telefono_referencia' => 'required|string|max:20',
            'direccion_referencia' => 'nullable|string|max:500',

            // Información adicional
            'observaciones' => 'nullable|string|max:1000',
            'actividades_formativas' => 'nullable|string|max:1000',
            'actividades_recreativas' => 'nullable|string|max:1000',
            'fecha_ingreso' => 'nullable|date',
            'estado_beneficiario' => 'nullable|in:activo,inactivo,suspendido',
        ]);

        // Crear el beneficiario con todos los datos validados
        Beneficiario::create($validated);

        // Limpiar caché del dashboard para reflejar cambios en las estadísticas
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario creado exitosamente.');
    }

    public function show(Beneficiario $beneficiario)
    {
        return view('beneficiarios.show', compact('beneficiario'));
    }

    public function edit(Beneficiario $beneficiario)
    {
        return view('beneficiarios.edit', compact('beneficiario'));
    }

    public function update(Request $request, Beneficiario $beneficiario)
    {
        $validated = $request->validate([
            // Datos personales
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:20|unique:beneficiarios,cedula,' . $beneficiario->id,
            'fecha_nacimiento' => 'required|date|before_or_equal:' . now()->subYears(60)->format('Y-m-d'),
            'lugar_nacimiento' => 'nullable|string|max:255',
            'nacionalidad' => 'nullable|string|max:100',
            'estado_civil' => 'required|in:soltero,casado,divorciado,viudo',
            'genero' => 'required|in:masculino,femenino,otro',

            // Información familiar
            'nombre_conyuge' => 'nullable|string|max:255',
            'telefono_conyuge' => 'nullable|string|max:20',
            'hijos' => 'nullable|integer|min:0',
            'familiares_cercanos' => 'nullable|string|max:1000',

            // Datos de contacto y ubicación
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'email_alternativo' => 'nullable|email|max:255',
            'direccion' => 'required|string|max:500',
            'estado' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'parroquia' => 'nullable|string|max:100',
            'sector' => 'nullable|string|max:100',
            'comunidad' => 'nullable|string|max:255',
            'comuna' => 'nullable|string|max:255',
            'consejo_comunal' => 'nullable|string|max:255',
            'centro_electoral' => 'nullable|string|max:255',
            'punto_referencia' => 'nullable|string|max:255',

            // Información médica básica
            'tipo_sangre' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergias' => 'nullable|string|max:500',
            'medicamentos_actuales' => 'nullable|string|max:1000',
            'enfermedades_cronicas' => 'nullable|string|max:1000',
            'medico_cabecera' => 'nullable|string|max:255',
            'telefono_medico' => 'nullable|string|max:20',

            // Información socioeconómica detallada
            'nivel_educativo' => 'nullable|in:ninguno,primaria,secundaria,tecnico,universitario,postgrado',
            'ocupacion_anterior' => 'nullable|string|max:255',
            'profesion' => 'nullable|string|max:255',
            'ayuda_economica' => 'nullable|in:si,no',
            'ingresos' => 'nullable|array',
            'gastos' => 'nullable|array',

            // Información de vivienda
            'tipo_vivienda' => 'required|in:casa,apartamento,otro',
            'condicion_vivienda' => 'nullable|in:propia,alquilada,prestada',
            'numero_habitantes' => 'nullable|integer|min:1',
            'materiales_construccion' => 'nullable|string|max:255',
            'servicios' => 'nullable|array',

            // Necesidades especiales y discapacidad
            'tiene_discapacidad' => 'nullable|in:si,no',
            'discapacidad' => 'nullable|array',
            'ayudas_tecnicas' => 'nullable|string|max:500',
            'necesidades_especiales' => 'nullable|string|max:500',

            // Información de referencia
            'persona_referencia' => 'required|string|max:255',
            'parentesco_referencia' => 'required|string|max:100',
            'telefono_referencia' => 'required|string|max:20',
            'direccion_referencia' => 'nullable|string|max:500',

            // Información adicional
            'observaciones' => 'nullable|string|max:1000',
            'actividades_formativas' => 'nullable|string|max:1000',
            'actividades_recreativas' => 'nullable|string|max:1000',
            'fecha_ingreso' => 'nullable|date',
            'estado_beneficiario' => 'nullable|in:activo,inactivo,suspendido',
        ]);

        // Actualizar el beneficiario con todos los datos validados
        $beneficiario->update($validated);

        // Limpiar caché del dashboard para reflejar cambios en las estadísticas
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario actualizado exitosamente.');
    }

    public function destroy(Beneficiario $beneficiario)
    {
        $beneficiario->delete();

        // Limpiar caché del dashboard para reflejar cambios en las estadísticas
        Cache::forget('dashboard_stats');
        Cache::forget('dashboard_ordenes_mensuales');

        return redirect()->route('beneficiarios.index')->with('success', 'Beneficiario eliminado exitosamente.');
    }
}
