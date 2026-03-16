@extends('layouts.app')

@section('content')
<style>
    .detail-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e8f5e8;
    }
    .section-title {
        color: #2e7d32;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #4caf50;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }
    .info-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #4caf50;
    }
    .info-label {
        font-weight: 600;
        color: #2e7d32;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        color: #333;
        margin: 0;
        font-size: 1rem;
    }
    .badge-activo {
        background-color: #4caf50;
        color: white;
    }
    .badge-inactivo {
        background-color: #f44336;
        color: white;
    }
    .badge-suspendido {
        background-color: #ff9800;
        color: white;
    }
    .header-card {
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container-fluid">
    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-user-circle me-3"></i>{{ $beneficiario->nombre }}
                </h1>
                <p class="mb-2 fs-5">
                    @if($beneficiario->cedula)
                        <i class="fas fa-id-card me-2"></i>Cédula: {{ $beneficiario->cedula }}
                    @endif
                </p>
                <div class="d-flex gap-3">
                    @if($beneficiario->edad)
                        <span class="badge fs-6 px-3 py-2">
                            <i class="fas fa-birthday-cake me-1"></i>{{ $beneficiario->edad }} años
                        </span>
                    @endif
                    <span class="badge fs-6 px-3 py-2 badge-{{ $beneficiario->estado_beneficiario }}">
                        <i class="fas fa-circle me-1"></i>{{ ucfirst($beneficiario->estado_beneficiario) }}
                    </span>
                    @if($beneficiario->genero)
                        <span class="badge fs-6 px-3 py-2 bg-secondary">
                            @if($beneficiario->genero == 'masculino')
                                <i class="fas fa-mars me-1"></i>Masculino
                            @elseif($beneficiario->genero == 'femenino')
                                <i class="fas fa-venus me-1"></i>Femenino
                            @else
                                <i class="fas fa-genderless me-1"></i>Otro
                            @endif
                        </span>
                    @endif
                </div>
            </div>
            <div class="text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('beneficiarios.edit', $beneficiario) }}" class="btn btn-light btn-lg">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="{{ route('beneficiarios.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. DATOS PERSONALES -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-id-card me-2"></i>Datos Personales
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nombre Completo</div>
                <div class="info-value">{{ $beneficiario->nombre }}</div>
            </div>
            @if($beneficiario->cedula)
            <div class="info-item">
                <div class="info-label">Cédula</div>
                <div class="info-value">{{ $beneficiario->cedula }}</div>
            </div>
            @endif
            @if($beneficiario->fecha_nacimiento)
            <div class="info-item">
                <div class="info-label">Fecha de Nacimiento</div>
                <div class="info-value">{{ $beneficiario->fecha_nacimiento->format('d/m/Y') }}</div>
            </div>
            @endif
            @if($beneficiario->lugar_nacimiento)
            <div class="info-item">
                <div class="info-label">Lugar de Nacimiento</div>
                <div class="info-value">{{ $beneficiario->lugar_nacimiento }}</div>
            </div>
            @endif
            @if($beneficiario->nacionalidad)
            <div class="info-item">
                <div class="info-label">Nacionalidad</div>
                <div class="info-value">{{ $beneficiario->nacionalidad }}</div>
            </div>
            @endif
            @if($beneficiario->estado_civil)
            <div class="info-item">
                <div class="info-label">Estado Civil</div>
                <div class="info-value">{{ ucfirst($beneficiario->estado_civil) }}</div>
            </div>
            @endif
            @if($beneficiario->genero)
            <div class="info-item">
                <div class="info-label">Género</div>
                <div class="info-value">{{ ucfirst($beneficiario->genero) }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- 2. INFORMACIÓN FAMILIAR -->
    @if($beneficiario->nombre_conyuge || $beneficiario->telefono_conyuge || $beneficiario->hijos || $beneficiario->familiares_cercanos)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-users me-2"></i>Información Familiar
        </h3>
        <div class="info-grid">
            @if($beneficiario->nombre_conyuge)
            <div class="info-item">
                <div class="info-label">Nombre del Cónyuge</div>
                <div class="info-value">{{ $beneficiario->nombre_conyuge }}</div>
            </div>
            @endif
            @if($beneficiario->telefono_conyuge)
            <div class="info-item">
                <div class="info-label">Teléfono del Cónyuge</div>
                <div class="info-value">{{ $beneficiario->telefono_conyuge }}</div>
            </div>
            @endif
            @if($beneficiario->hijos)
            <div class="info-item">
                <div class="info-label">Número de Hijos</div>
                <div class="info-value">{{ $beneficiario->hijos }}</div>
            </div>
            @endif
            @if($beneficiario->familiares_cercanos)
            <div class="info-item">
                <div class="info-label">Familiares Cercanos</div>
                <div class="info-value">{{ $beneficiario->familiares_cercanos }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 3. DATOS DE CONTACTO Y UBICACIÓN -->
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-map-marker-alt me-2"></i>Datos de Contacto y Ubicación
        </h3>
        <div class="info-grid">
            @if($beneficiario->telefono)
            <div class="info-item">
                <div class="info-label">Teléfono Principal</div>
                <div class="info-value">{{ $beneficiario->telefono }}</div>
            </div>
            @endif
            @if($beneficiario->telefono_alternativo)
            <div class="info-item">
                <div class="info-label">Teléfono Alternativo</div>
                <div class="info-value">{{ $beneficiario->telefono_alternativo }}</div>
            </div>
            @endif
            @if($beneficiario->email)
            <div class="info-item">
                <div class="info-label">Correo Electrónico</div>
                <div class="info-value">{{ $beneficiario->email }}</div>
            </div>
            @endif
            @if($beneficiario->email_alternativo)
            <div class="info-item">
                <div class="info-label">Correo Electrónico Alternativo</div>
                <div class="info-value">{{ $beneficiario->email_alternativo }}</div>
            </div>
            @endif
            @if($beneficiario->direccion)
            <div class="info-item">
                <div class="info-label">Dirección Completa</div>
                <div class="info-value">{{ $beneficiario->direccion }}</div>
            </div>
            @endif
            @if($beneficiario->estado)
            <div class="info-item">
                <div class="info-label">Estado</div>
                <div class="info-value">{{ $beneficiario->estado }}</div>
            </div>
            @endif
            @if($beneficiario->municipio)
            <div class="info-item">
                <div class="info-label">Municipio</div>
                <div class="info-value">{{ $beneficiario->municipio }}</div>
            </div>
            @endif
            @if($beneficiario->parroquia)
            <div class="info-item">
                <div class="info-label">Parroquia</div>
                <div class="info-value">{{ $beneficiario->parroquia }}</div>
            </div>
            @endif
            @if($beneficiario->sector)
            <div class="info-item">
                <div class="info-label">Sector/Barrio</div>
                <div class="info-value">{{ $beneficiario->sector }}</div>
            </div>
            @endif
            @if($beneficiario->comunidad)
            <div class="info-item">
                <div class="info-label">Comunidad</div>
                <div class="info-value">{{ $beneficiario->comunidad }}</div>
            </div>
            @endif
            @if($beneficiario->comuna)
            <div class="info-item">
                <div class="info-label">Comuna</div>
                <div class="info-value">{{ $beneficiario->comuna }}</div>
            </div>
            @endif
            @if($beneficiario->consejo_comunal)
            <div class="info-item">
                <div class="info-label">Consejo Comunal</div>
                <div class="info-value">{{ $beneficiario->consejo_comunal }}</div>
            </div>
            @endif
            @if($beneficiario->centro_electoral)
            <div class="info-item">
                <div class="info-label">Centro Electoral</div>
                <div class="info-value">{{ $beneficiario->centro_electoral }}</div>
            </div>
            @endif
            @if($beneficiario->punto_referencia)
            <div class="info-item">
                <div class="info-label">Punto de Referencia</div>
                <div class="info-value">{{ $beneficiario->punto_referencia }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- 4. INFORMACIÓN MÉDICA BÁSICA -->
    @if($beneficiario->tipo_sangre || $beneficiario->alergias || $beneficiario->medicamentos_actuales || $beneficiario->enfermedades_cronicas || $beneficiario->medico_cabecera)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-heartbeat me-2"></i>Información Médica Básica
        </h3>
        <div class="info-grid">
            @if($beneficiario->tipo_sangre)
            <div class="info-item">
                <div class="info-label">Tipo de Sangre</div>
                <div class="info-value">{{ $beneficiario->tipo_sangre }}</div>
            </div>
            @endif
            @if($beneficiario->alergias)
            <div class="info-item">
                <div class="info-label">Alergias</div>
                <div class="info-value">{{ $beneficiario->alergias }}</div>
            </div>
            @endif
            @if($beneficiario->medicamentos_actuales)
            <div class="info-item">
                <div class="info-label">Medicamentos Actuales</div>
                <div class="info-value">{{ $beneficiario->medicamentos_actuales }}</div>
            </div>
            @endif
            @if($beneficiario->enfermedades_cronicas)
            <div class="info-item">
                <div class="info-label">Enfermedades Crónicas</div>
                <div class="info-value">{{ $beneficiario->enfermedades_cronicas }}</div>
            </div>
            @endif
            @if($beneficiario->medico_cabecera)
            <div class="info-item">
                <div class="info-label">Médico de Cabecera</div>
                <div class="info-value">{{ $beneficiario->medico_cabecera }}</div>
            </div>
            @endif
            @if($beneficiario->telefono_medico)
            <div class="info-item">
                <div class="info-label">Teléfono del Médico</div>
                <div class="info-value">{{ $beneficiario->telefono_medico }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 5. INFORMACIÓN SOCIOECONÓMICA -->
    @if($beneficiario->nivel_educativo || $beneficiario->ocupacion_anterior || $beneficiario->ayuda_economica || $beneficiario->ingresos || $beneficiario->gastos)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-chart-line me-2"></i>Información Socioeconómica
        </h3>
        <div class="info-grid">
            @if($beneficiario->nivel_educativo)
            <div class="info-item">
                <div class="info-label">Nivel Educativo</div>
                <div class="info-value">{{ ucfirst($beneficiario->nivel_educativo) }}</div>
            </div>
            @endif
            @if($beneficiario->ocupacion_anterior)
            <div class="info-item">
                <div class="info-label">Ocupación Anterior</div>
                <div class="info-value">{{ $beneficiario->ocupacion_anterior }}</div>
            </div>
            @endif
            @if($beneficiario->profesion)
            <div class="info-item">
                <div class="info-label">Profesión</div>
                <div class="info-value">{{ $beneficiario->profesion }}</div>
            </div>
            @endif
            @if($beneficiario->ayuda_economica)
            <div class="info-item">
                <div class="info-label">¿Recibe Ayuda Económica?</div>
                <div class="info-value">{{ $beneficiario->ayuda_economica == 'si' ? 'Sí' : 'No' }}</div>
            </div>
            @endif
            @if($beneficiario->ingresos)
            <div class="info-item">
                <div class="info-label">Fuentes de Ingresos</div>
                <div class="info-value">{{ $beneficiario->ingresos_string }}</div>
            </div>
            @endif
            @if($beneficiario->gastos)
            <div class="info-item">
                <div class="info-label">Gastos Principales</div>
                <div class="info-value">{{ $beneficiario->gastos_string }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 6. INFORMACIÓN DE VIVIENDA -->
    @if($beneficiario->tipo_vivienda || $beneficiario->condicion_vivienda || $beneficiario->numero_habitantes || $beneficiario->materiales_construccion || $beneficiario->servicios)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-home me-2"></i>Información de Vivienda
        </h3>
        <div class="info-grid">
            @if($beneficiario->tipo_vivienda)
            <div class="info-item">
                <div class="info-label">Tipo de Vivienda</div>
                <div class="info-value">{{ ucfirst($beneficiario->tipo_vivienda) }}</div>
            </div>
            @endif
            @if($beneficiario->condicion_vivienda)
            <div class="info-item">
                <div class="info-label">Condición de la Vivienda</div>
                <div class="info-value">{{ ucfirst($beneficiario->condicion_vivienda) }}</div>
            </div>
            @endif
            @if($beneficiario->numero_habitantes)
            <div class="info-item">
                <div class="info-label">Número de Habitantes</div>
                <div class="info-value">{{ $beneficiario->numero_habitantes }}</div>
            </div>
            @endif
            @if($beneficiario->materiales_construccion)
            <div class="info-item">
                <div class="info-label">Materiales de Construcción</div>
                <div class="info-value">{{ $beneficiario->materiales_construccion }}</div>
            </div>
            @endif
            @if($beneficiario->servicios)
            <div class="info-item">
                <div class="info-label">Servicios Disponibles</div>
                <div class="info-value">{{ $beneficiario->servicios_string }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 7. NECESIDADES ESPECIALES Y DISCAPACIDAD -->
    @if($beneficiario->tiene_discapacidad || $beneficiario->discapacidad || $beneficiario->ayudas_tecnicas || $beneficiario->necesidades_especiales)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-wheelchair me-2"></i>Necesidades Especiales y Discapacidad
        </h3>
        <div class="info-grid">
            @if($beneficiario->tiene_discapacidad)
            <div class="info-item">
                <div class="info-label">¿Presenta Discapacidad?</div>
                <div class="info-value">{{ $beneficiario->tiene_discapacidad == 'si' ? 'Sí' : 'No' }}</div>
            </div>
            @endif
            @if($beneficiario->discapacidad)
            <div class="info-item">
                <div class="info-label">Tipo de Discapacidad</div>
                <div class="info-value">{{ $beneficiario->discapacidad_string }}</div>
            </div>
            @endif
            @if($beneficiario->ayudas_tecnicas)
            <div class="info-item">
                <div class="info-label">Ayudas Técnicas</div>
                <div class="info-value">{{ $beneficiario->ayudas_tecnicas }}</div>
            </div>
            @endif
            @if($beneficiario->necesidades_especiales)
            <div class="info-item">
                <div class="info-label">Necesidades Especiales</div>
                <div class="info-value">{{ $beneficiario->necesidades_especiales }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 8. INFORMACIÓN DE REFERENCIA -->
    @if($beneficiario->persona_referencia || $beneficiario->parentesco_referencia || $beneficiario->telefono_referencia || $beneficiario->direccion_referencia)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-address-book me-2"></i>Información de Referencia
        </h3>
        <div class="info-grid">
            @if($beneficiario->persona_referencia)
            <div class="info-item">
                <div class="info-label">Persona de Referencia</div>
                <div class="info-value">{{ $beneficiario->persona_referencia }}</div>
            </div>
            @endif
            @if($beneficiario->parentesco_referencia)
            <div class="info-item">
                <div class="info-label">Parentesco</div>
                <div class="info-value">{{ $beneficiario->parentesco_referencia }}</div>
            </div>
            @endif
            @if($beneficiario->telefono_referencia)
            <div class="info-item">
                <div class="info-label">Teléfono de Referencia</div>
                <div class="info-value">{{ $beneficiario->telefono_referencia }}</div>
            </div>
            @endif
            @if($beneficiario->direccion_referencia)
            <div class="info-item">
                <div class="info-label">Dirección de Referencia</div>
                <div class="info-value">{{ $beneficiario->direccion_referencia }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- 9. INFORMACIÓN ADICIONAL -->
    @if($beneficiario->observaciones || $beneficiario->fecha_ingreso || $beneficiario->estado_beneficiario)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-info-circle me-2"></i>Información Adicional
        </h3>
        <div class="info-grid">
            @if($beneficiario->observaciones)
            <div class="info-item">
                <div class="info-label">Observaciones</div>
                <div class="info-value">{{ $beneficiario->observaciones }}</div>
            </div>
            @endif
            @if($beneficiario->fecha_ingreso)
            <div class="info-item">
                <div class="info-label">Fecha de Ingreso</div>
                <div class="info-value">{{ $beneficiario->fecha_ingreso->format('d/m/Y') }}</div>
            </div>
            @endif
            <div class="info-item">
                <div class="info-label">Estado del Beneficiario</div>
                <div class="info-value">
                    <span class="badge badge-{{ $beneficiario->estado_beneficiario }}">{{ ucfirst($beneficiario->estado_beneficiario) }}</span>
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Fecha de Registro</div>
                <div class="info-value">{{ $beneficiario->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($beneficiario->updated_at != $beneficiario->created_at)
            <div class="info-item">
                <div class="info-label">Última Actualización</div>
                <div class="info-value">{{ $beneficiario->updated_at->format('d/m/Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- ACTIVIDADES DE INTERÉS -->
    @if($beneficiario->actividades_formativas || $beneficiario->actividades_recreativas)
    <div class="detail-section">
        <h3 class="section-title">
            <i class="fas fa-star me-2"></i>Actividades de Interés
        </h3>
        <div class="info-grid">
            @if($beneficiario->actividades_formativas)
            <div class="info-item">
                <div class="info-label">Actividades Formativas</div>
                <div class="info-value">{{ $beneficiario->actividades_formativas }}</div>
            </div>
            @endif
            @if($beneficiario->actividades_recreativas)
            <div class="info-item">
                <div class="info-label">Actividades Recreativas</div>
                <div class="info-value">{{ $beneficiario->actividades_recreativas }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="text-center mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('beneficiarios.edit', $beneficiario) }}" class="btn btn-warning btn-lg">
                <i class="fas fa-edit me-2"></i>Editar Beneficiario
            </a>
            <a href="{{ route('beneficiarios.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection
