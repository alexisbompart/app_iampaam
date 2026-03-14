@extends('layouts.app')

@section('content')
<style>
    .form-section {
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
    .form-check-inline {
        margin-right: 1rem;
    }
    .checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.5rem;
    }
</style>

<div class="container-fluid">
    <div class="form-section">
        <h1 class="text-center mb-4" style="color: #2e7d32;">
            <i class="fas fa-user-edit me-2"></i>Editar Beneficiario
        </h1>
        <p class="text-center text-muted mb-4">Instituto de Atención al Adulto Mayor y Protección a la Ancianidad</p>

        <form action="{{ route('beneficiarios.update', $beneficiario) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- 1. DATOS PERSONALES -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-id-card me-2"></i>1. Datos Personales
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre Completo *</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $beneficiario->nombre) }}" required>
                        @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="cedula" class="form-label">Cédula de Identidad *</label>
                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" id="cedula" name="cedula" value="{{ old('cedula', $beneficiario->cedula) }}" required>
                        @error('cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $beneficiario->fecha_nacimiento ? $beneficiario->fecha_nacimiento->format('Y-m-d') : '') }}" required>
                        @error('fecha_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control @error('lugar_nacimiento') is-invalid @enderror" id="lugar_nacimiento" name="lugar_nacimiento" value="{{ old('lugar_nacimiento', $beneficiario->lugar_nacimiento) }}">
                        @error('lugar_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <input type="text" class="form-control @error('nacionalidad') is-invalid @enderror" id="nacionalidad" name="nacionalidad" value="{{ old('nacionalidad', $beneficiario->nacionalidad) }}">
                        @error('nacionalidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Estado Civil *</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('estado_civil') is-invalid @enderror" type="radio" id="soltero" name="estado_civil" value="soltero" {{ old('estado_civil', $beneficiario->estado_civil) == 'soltero' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="soltero">Soltero/a</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="casado" name="estado_civil" value="casado" {{ old('estado_civil', $beneficiario->estado_civil) == 'casado' ? 'checked' : '' }}>
                            <label class="form-check-label" for="casado">Casado/a</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="divorciado" name="estado_civil" value="divorciado" {{ old('estado_civil', $beneficiario->estado_civil) == 'divorciado' ? 'checked' : '' }}>
                            <label class="form-check-label" for="divorciado">Divorciado/a</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="viudo" name="estado_civil" value="viudo" {{ old('estado_civil', $beneficiario->estado_civil) == 'viudo' ? 'checked' : '' }}>
                            <label class="form-check-label" for="viudo">Viudo/a</label>
                        </div>
                        @error('estado_civil') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Género *</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('genero') is-invalid @enderror" type="radio" id="masculino" name="genero" value="masculino" {{ old('genero', $beneficiario->genero) == 'masculino' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="masculino">Masculino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="femenino" name="genero" value="femenino" {{ old('genero', $beneficiario->genero) == 'femenino' ? 'checked' : '' }}>
                            <label class="form-check-label" for="femenino">Femenino</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="otro" name="genero" value="otro" {{ old('genero', $beneficiario->genero) == 'otro' ? 'checked' : '' }}>
                            <label class="form-check-label" for="otro">Otro</label>
                        </div>
                        @error('genero') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- 2. INFORMACIÓN FAMILIAR -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-users me-2"></i>2. Información Familiar
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre_conyuge" class="form-label">Nombre del Cónyuge (si aplica)</label>
                        <input type="text" class="form-control @error('nombre_conyuge') is-invalid @enderror" id="nombre_conyuge" name="nombre_conyuge" value="{{ old('nombre_conyuge', $beneficiario->nombre_conyuge) }}">
                        @error('nombre_conyuge') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="telefono_conyuge" class="form-label">Teléfono del Cónyuge</label>
                        <input type="text" class="form-control @error('telefono_conyuge') is-invalid @enderror" id="telefono_conyuge" name="telefono_conyuge" value="{{ old('telefono_conyuge', $beneficiario->telefono_conyuge) }}">
                        @error('telefono_conyuge') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="hijos" class="form-label">Número de Hijos</label>
                    <input type="number" class="form-control @error('hijos') is-invalid @enderror" id="hijos" name="hijos" value="{{ old('hijos', $beneficiario->hijos) }}" min="0">
                    @error('hijos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="familiares_cercanos" class="form-label">Familiares Cercanos (Nombres y Parentesco)</label>
                    <textarea class="form-control @error('familiares_cercanos') is-invalid @enderror" id="familiares_cercanos" name="familiares_cercanos" rows="3">{{ old('familiares_cercanos', $beneficiario->familiares_cercanos) }}</textarea>
                    @error('familiares_cercanos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- 3. DATOS DE CONTACTO Y UBICACIÓN -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt me-2"></i>3. Datos de Contacto y Ubicación
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono Principal *</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $beneficiario->telefono) }}" required>
                        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="telefono_alternativo" class="form-label">Teléfono Alternativo</label>
                        <input type="text" class="form-control @error('telefono_alternativo') is-invalid @enderror" id="telefono_alternativo" name="telefono_alternativo" value="{{ old('telefono_alternativo', $beneficiario->telefono_alternativo) }}">
                        @error('telefono_alternativo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $beneficiario->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email_alternativo" class="form-label">Correo Electrónico Alternativo</label>
                        <input type="email" class="form-control @error('email_alternativo') is-invalid @enderror" id="email_alternativo" name="email_alternativo" value="{{ old('email_alternativo', $beneficiario->email_alternativo) }}">
                        @error('email_alternativo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección Completa *</label>
                    <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3" required>{{ old('direccion', $beneficiario->direccion) }}</textarea>
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ old('estado', $beneficiario->estado) }}">
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="municipio" class="form-label">Municipio</label>
                        <input type="text" class="form-control @error('municipio') is-invalid @enderror" id="municipio" name="municipio" value="{{ old('municipio', $beneficiario->municipio) }}">
                        @error('municipio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="parroquia" class="form-label">Parroquia</label>
                        <input type="text" class="form-control @error('parroquia') is-invalid @enderror" id="parroquia" name="parroquia" value="{{ old('parroquia', $beneficiario->parroquia) }}">
                        @error('parroquia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sector" class="form-label">Sector/Barrio</label>
                        <input type="text" class="form-control @error('sector') is-invalid @enderror" id="sector" name="sector" value="{{ old('sector', $beneficiario->sector) }}">
                        @error('sector') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="punto_referencia" class="form-label">Punto de Referencia</label>
                        <input type="text" class="form-control @error('punto_referencia') is-invalid @enderror" id="punto_referencia" name="punto_referencia" value="{{ old('punto_referencia', $beneficiario->punto_referencia) }}">
                        @error('punto_referencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- 4. INFORMACIÓN MÉDICA BÁSICA -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-heartbeat me-2"></i>4. Información Médica Básica
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tipo_sangre" class="form-label">Tipo de Sangre</label>
                        <select class="form-control @error('tipo_sangre') is-invalid @enderror" id="tipo_sangre" name="tipo_sangre">
                            <option value="">Seleccionar...</option>
                            <option value="A+" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('tipo_sangre', $beneficiario->tipo_sangre) == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('tipo_sangre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="alergias" class="form-label">Alergias Conocidas</label>
                        <input type="text" class="form-control @error('alergias') is-invalid @enderror" id="alergias" name="alergias" value="{{ old('alergias', $beneficiario->alergias) }}" placeholder="Medicamentos, alimentos, etc.">
                        @error('alergias') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="medicamentos_actuales" class="form-label">Medicamentos que Toma Actualmente</label>
                    <textarea class="form-control @error('medicamentos_actuales') is-invalid @enderror" id="medicamentos_actuales" name="medicamentos_actuales" rows="2" placeholder="Nombre del medicamento, dosis, frecuencia">{{ old('medicamentos_actuales', $beneficiario->medicamentos_actuales) }}</textarea>
                    @error('medicamentos_actuales') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="enfermedades_cronicas" class="form-label">Enfermedades Crónicas</label>
                    <textarea class="form-control @error('enfermedades_cronicas') is-invalid @enderror" id="enfermedades_cronicas" name="enfermedades_cronicas" rows="2" placeholder="Diabetes, hipertensión, etc.">{{ old('enfermedades_cronicas', $beneficiario->enfermedades_cronicas) }}</textarea>
                    @error('enfermedades_cronicas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="medico_cabecera" class="form-label">Médico de Cabecera</label>
                        <input type="text" class="form-control @error('medico_cabecera') is-invalid @enderror" id="medico_cabecera" name="medico_cabecera" value="{{ old('medico_cabecera', $beneficiario->medico_cabecera) }}">
                        @error('medico_cabecera') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="telefono_medico" class="form-label">Teléfono del Médico</label>
                        <input type="text" class="form-control @error('telefono_medico') is-invalid @enderror" id="telefono_medico" name="telefono_medico" value="{{ old('telefono_medico', $beneficiario->telefono_medico) }}">
                        @error('telefono_medico') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- 5. INFORMACIÓN SOCIOECONÓMICA DETALLADA -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-chart-line me-2"></i>5. Información Socioeconómica Detallada
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nivel_educativo" class="form-label">Nivel Educativo</label>
                        <select class="form-control @error('nivel_educativo') is-invalid @enderror" id="nivel_educativo" name="nivel_educativo">
                            <option value="">Seleccionar...</option>
                            <option value="ninguno" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'ninguno' ? 'selected' : '' }}>Ninguno</option>
                            <option value="primaria" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'primaria' ? 'selected' : '' }}>Primaria</option>
                            <option value="secundaria" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'secundaria' ? 'selected' : '' }}>Secundaria</option>
                            <option value="tecnico" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="universitario" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'universitario' ? 'selected' : '' }}>Universitario</option>
                            <option value="postgrado" {{ old('nivel_educativo', $beneficiario->nivel_educativo) == 'postgrado' ? 'selected' : '' }}>Postgrado</option>
                        </select>
                        @error('nivel_educativo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="ocupacion_anterior" class="form-label">Ocupación Anterior</label>
                        <input type="text" class="form-control @error('ocupacion_anterior') is-invalid @enderror" id="ocupacion_anterior" name="ocupacion_anterior" value="{{ old('ocupacion_anterior', $beneficiario->ocupacion_anterior) }}">
                        @error('ocupacion_anterior') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">¿Recibe algún tipo de ayuda económica?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="ayuda_si" name="ayuda_economica" value="si" {{ old('ayuda_economica', $beneficiario->ayuda_economica) == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ayuda_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="ayuda_no" name="ayuda_economica" value="no" {{ old('ayuda_economica', $beneficiario->ayuda_economica) == 'no' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ayuda_no">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fuentes de Ingresos</label>
                    <div class="checkbox-grid">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_familia" name="ingresos[]" value="Ayuda de la familia" {{ in_array('Ayuda de la familia', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_familia">Ayuda de la familia</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_becas" name="ingresos[]" value="Becas" {{ in_array('Becas', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_becas">Becas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_bonos" name="ingresos[]" value="Bonos de la patria" {{ in_array('Bonos de la patria', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_bonos">Bonos de la patria</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_emprendimiento" name="ingresos[]" value="Emprendimiento" {{ in_array('Emprendimiento', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_emprendimiento">Emprendimiento</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_jubilacion" name="ingresos[]" value="Jubilacion" {{ in_array('Jubilacion', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_jubilacion">Jubilación</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_misiones" name="ingresos[]" value="Misiones" {{ in_array('Misiones', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_misiones">Misiones</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_pension_amormayor" name="ingresos[]" value="Pension amor mayor" {{ in_array('Pension amor mayor', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_pension_amormayor">Pensión amor mayor</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_pension_ivss" name="ingresos[]" value="Pension ivss" {{ in_array('Pension ivss', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_pension_ivss">Pensión IVSS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_remesa" name="ingresos[]" value="Remesa" {{ in_array('Remesa', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_remesa">Remesa</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_renta" name="ingresos[]" value="Renta" {{ in_array('Renta', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_renta">Renta</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_trabajo" name="ingresos[]" value="Trabajo asalariado" {{ in_array('Trabajo asalariado', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_trabajo">Trabajo asalariado</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ingreso_ninguno" name="ingresos[]" value="Ninguno" {{ in_array('Ninguno', old('ingresos', $beneficiario->ingresos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ingreso_ninguno">Ninguno</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gastos Principales</label>
                    <div class="checkbox-grid">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_alimentacion" name="gastos[]" value="Alimentacion" {{ in_array('Alimentacion', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_alimentacion">Alimentación</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_entretenimiento" name="gastos[]" value="Entretenimiento" {{ in_array('Entretenimiento', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_entretenimiento">Entretenimiento</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_medicina" name="gastos[]" value="Medicina" {{ in_array('Medicina', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_medicina">Medicina</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_servicios" name="gastos[]" value="Servicios basicos" {{ in_array('Servicios basicos', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_servicios">Servicios básicos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_transporte" name="gastos[]" value="Transporte" {{ in_array('Transporte', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_transporte">Transporte</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_vivienda" name="gastos[]" value="Vivienda" {{ in_array('Vivienda', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_vivienda">Vivienda</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_otro" name="gastos[]" value="Otro" {{ in_array('Otro', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_otro">Otro</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. INFORMACIÓN DE VIVIENDA -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-home me-2"></i>6. Información de Vivienda
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Vivienda *</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('tipo_vivienda') is-invalid @enderror" type="radio" id="casa" name="tipo_vivienda" value="casa" {{ old('tipo_vivienda', $beneficiario->tipo_vivienda) == 'casa' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="casa">Casa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="apartamento" name="tipo_vivienda" value="apartamento" {{ old('tipo_vivienda', $beneficiario->tipo_vivienda) == 'apartamento' ? 'checked' : '' }}>
                            <label class="form-check-label" for="apartamento">Apartamento</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="otro_vivienda" name="tipo_vivienda" value="otro" {{ old('tipo_vivienda', $beneficiario->tipo_vivienda) == 'otro' ? 'checked' : '' }}>
                            <label class="form-check-label" for="otro_vivienda">Otro</label>
                        </div>
                        @error('tipo_vivienda') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Condición de la Vivienda</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="propia" name="condicion_vivienda" value="propia" {{ old('condicion_vivienda', $beneficiario->condicion_vivienda) == 'propia' ? 'checked' : '' }}>
                            <label class="form-check-label" for="propia">Propia</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="alquilada" name="condicion_vivienda" value="alquilada" {{ old('condicion_vivienda', $beneficiario->condicion_vivienda) == 'alquilada' ? 'checked' : '' }}>
                            <label class="form-check-label" for="alquilada">Alquilada</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="prestada" name="condicion_vivienda" value="prestada" {{ old('condicion_vivienda', $beneficiario->condicion_vivienda) == 'prestada' ? 'checked' : '' }}>
                            <label class="form-check-label" for="prestada">Prestada</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="numero_habitantes" class="form-label">Número de Habitantes en la Vivienda</label>
                        <input type="number" class="form-control @error('numero_habitantes') is-invalid @enderror" id="numero_habitantes" name="numero_habitantes" value="{{ old('numero_habitantes', $beneficiario->numero_habitantes) }}" min="1">
                        @error('numero_habitantes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="materiales_construccion" class="form-label">Materiales de Construcción</label>
                        <input type="text" class="form-control @error('materiales_construccion') is-invalid @enderror" id="materiales_construccion" name="materiales_construccion" value="{{ old('materiales_construccion', $beneficiario->materiales_construccion) }}" placeholder="Bloque, madera, etc.">
                        @error('materiales_construccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Servicios Disponibles</label>
                    <div class="checkbox-grid">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_agua" name="servicios[]" value="Agua potable" {{ in_array('Agua potable', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_agua">Agua potable</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_electricidad" name="servicios[]" value="Electricidad" {{ in_array('Electricidad', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_electricidad">Electricidad</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_gas" name="servicios[]" value="Gas" {{ in_array('Gas', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_gas">Gas</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_telefono" name="servicios[]" value="Teléfono" {{ in_array('Teléfono', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_telefono">Teléfono</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_internet" name="servicios[]" value="Internet" {{ in_array('Internet', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_internet">Internet</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="servicio_cable" name="servicios[]" value="Cable TV" {{ in_array('Cable TV', old('servicios', $beneficiario->servicios ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="servicio_cable">Cable TV</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. NECESIDADES ESPECIALES Y DISCAPACIDAD -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-wheelchair me-2"></i>7. Necesidades Especiales y Discapacidad
                </h3>

                <div class="mb-3">
                    <label class="form-label">¿Presenta alguna discapacidad?</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="discapacidad_si" name="tiene_discapacidad" value="si" {{ old('tiene_discapacidad', $beneficiario->tiene_discapacidad) == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="discapacidad_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="discapacidad_no" name="tiene_discapacidad" value="no" {{ old('tiene_discapacidad', $beneficiario->tiene_discapacidad) == 'no' ? 'checked' : '' }}>
                        <label class="form-check-label" for="discapacidad_no">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Discapacidad</label>
                    <div class="checkbox-grid">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_fisica" name="discapacidad[]" value="Física o Motora" {{ in_array('Física o Motora', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_fisica">Física o Motora</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_visual" name="discapacidad[]" value="Sensorial-Visual" {{ in_array('Sensorial-Visual', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_visual">Sensorial-Visual</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_auditiva" name="discapacidad[]" value="Sensorial-Auditiva" {{ in_array('Sensorial-Auditiva', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_auditiva">Sensorial-Auditiva</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_intelectual" name="discapacidad[]" value="Intelectual o Cognitiva" {{ in_array('Intelectual o Cognitiva', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_intelectual">Intelectual o Cognitiva</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_psicosocial" name="discapacidad[]" value="Psicosocial o Mental" {{ in_array('Psicosocial o Mental', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_psicosocial">Psicosocial o Mental</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_ninguna" name="discapacidad[]" value="Ninguna de las anteriores" {{ in_array('Ninguna de las anteriores', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_ninguna">Ninguna de las anteriores</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="ayudas_tecnicas" class="form-label">¿Utiliza alguna ayuda técnica o dispositivo de apoyo?</label>
                    <textarea class="form-control @error('ayudas_tecnicas') is-invalid @enderror" id="ayudas_tecnicas" name="ayudas_tecnicas" rows="2" placeholder="Silla de ruedas, bastón, audífonos, etc.">{{ old('ayudas_tecnicas', $beneficiario->ayudas_tecnicas) }}</textarea>
                    @error('ayudas_tecnicas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="necesidades_especiales" class="form-label">Otras Necesidades Especialmente</label>
                    <textarea class="form-control @error('necesidades_especiales') is-invalid @enderror" id="necesidades_especiales" name="necesidades_especiales" rows="2" placeholder="Cuidados especiales, dieta específica, etc.">{{ old('necesidades_especiales', $beneficiario->necesidades_especiales) }}</textarea>
                    @error('necesidades_especiales') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- 8. INFORMACIÓN DE REFERENCIA -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-address-book me-2"></i>8. Información de Referencia
                </h3>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="persona_referencia" class="form-label">Persona de Referencia *</label>
                        <input type="text" class="form-control @error('persona_referencia') is-invalid @enderror" id="persona_referencia" name="persona_referencia" value="{{ old('persona_referencia', $beneficiario->persona_referencia) }}" required>
                        @error('persona_referencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="parentesco_referencia" class="form-label">Parentesco con la Persona de Referencia *</label>
                        <input type="text" class="form-control @error('parentesco_referencia') is-invalid @enderror" id="parentesco_referencia" name="parentesco_referencia" value="{{ old('parentesco_referencia', $beneficiario->parentesco_referencia) }}" required placeholder="Hijo/a, nieto/a, vecino/a, etc.">
                        @error('parentesco_referencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefono_referencia" class="form-label">Teléfono de Referencia *</label>
                        <input type="text" class="form-control @error('telefono_referencia') is-invalid @enderror" id="telefono_referencia" name="telefono_referencia" value="{{ old('telefono_referencia', $beneficiario->telefono_referencia) }}" required>
                        @error('telefono_referencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="direccion_referencia" class="form-label">Dirección de Referencia</label>
                        <input type="text" class="form-control @error('direccion_referencia') is-invalid @enderror" id="direccion_referencia" name="direccion_referencia" value="{{ old('direccion_referencia', $beneficiario->direccion_referencia) }}">
                        @error('direccion_referencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- 9. INFORMACIÓN ADICIONAL -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle me-2"></i>9. Información Adicional
                </h3>

                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones Generales</label>
                    <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3" placeholder="Información adicional relevante para el caso">{{ old('observaciones', $beneficiario->observaciones) }}</textarea>
                    @error('observaciones') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso al Programa</label>
                        <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" id="fecha_ingreso" name="fecha_ingreso" value="{{ old('fecha_ingreso', $beneficiario->fecha_ingreso ? $beneficiario->fecha_ingreso->format('Y-m-d') : '') }}">
                        @error('fecha_ingreso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="estado_beneficiario" class="form-label">Estado del Beneficiario</label>
                        <select class="form-control @error('estado_beneficiario') is-invalid @enderror" id="estado_beneficiario" name="estado_beneficiario">
                            <option value="activo" {{ old('estado_beneficiario', $beneficiario->estado_beneficiario) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado_beneficiario', $beneficiario->estado_beneficiario) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="suspendido" {{ old('estado_beneficiario', $beneficiario->estado_beneficiario) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                        @error('estado_beneficiario') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-section">
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save me-2"></i>Actualizar Beneficiario
                    </button>
                    <a href="{{ route('beneficiarios.index') }}" class="btn btn-secondary btn-lg px-5 ms-3">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
            <label class="form-label">¿Recibe algún tipo de ayuda económica?</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="ayuda_si" name="ayuda_economica" value="si" {{ old('ayuda_economica') == 'si' ? 'checked' : '' }}>
                <label class="form-check-label" for="ayuda_si">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="ayuda_no" name="ayuda_economica" value="no" {{ old('ayuda_economica') == 'no' ? 'checked' : '' }}>
                <label class="form-check-label" for="ayuda_no">No</label>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Fuentes de Ingresos</label><br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_familia" name="ingresos[]" value="Ayuda de la familia" {{ in_array('Ayuda de la familia', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_familia">Ayuda de la familia</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_becas" name="ingresos[]" value="Becas" {{ in_array('Becas', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_becas">Becas</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_bonos" name="ingresos[]" value="Bonos de la patria" {{ in_array('Bonos de la patria', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_bonos">Bonos de la patria</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_emprendimiento" name="ingresos[]" value="Emprendimiento" {{ in_array('Emprendimiento', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_emprendimiento">Emprendimiento</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_jubilacion" name="ingresos[]" value="Jubilacion" {{ in_array('Jubilacion', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_jubilacion">Jubilación</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_misiones" name="ingresos[]" value="Misiones" {{ in_array('Misiones', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_misiones">Misiones</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_pension_amormayor" name="ingresos[]" value="Pension amor mayor" {{ in_array('Pension amor mayor', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_pension_amormayor">Pensión amor mayor</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_pension_ivss" name="ingresos[]" value="Pension ivss" {{ in_array('Pension ivss', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_pension_ivss">Pensión IVSS</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_remesa" name="ingresos[]" value="Remesa" {{ in_array('Remesa', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_remesa">Remesa</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_renta" name="ingresos[]" value="Renta" {{ in_array('Renta', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_renta">Renta</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_trabajo" name="ingresos[]" value="Trabajo asalariado" {{ in_array('Trabajo asalariado', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_trabajo">Trabajo asalariado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="ingreso_ninguno" name="ingresos[]" value="Ninguno" {{ in_array('Ninguno', old('ingresos', json_decode($beneficiario->ingresos, true) ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingreso_ninguno">Ninguno</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gastos Principales</label><br>
            <div class="row">
                <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_alimentacion" name="gastos[]" value="Alimentacion" {{ in_array('Alimentacion', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_alimentacion">Alimentación</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_entretenimiento" name="gastos[]" value="Entretenimiento" {{ in_array('Entretenimiento', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_entretenimiento">Entretenimiento</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_medicina" name="gastos[]" value="Medicina" {{ in_array('Medicina', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_medicina">Medicina</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_servicios" name="gastos[]" value="Servicios basicos" {{ in_array('Servicios basicos', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_servicios">Servicios básicos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_transporte" name="gastos[]" value="Transporte" {{ in_array('Transporte', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_transporte">Transporte</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_vivienda" name="gastos[]" value="Vivienda" {{ in_array('Vivienda', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_vivienda">Vivienda</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gasto_otro" name="gastos[]" value="Otro" {{ in_array('Otro', old('gastos', $beneficiario->gastos ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="gasto_otro">Otro</label>
                        </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Discapacidad</label><br>
            <div class="row">
                <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_fisica" name="discapacidad[]" value="Física o Motora" {{ in_array('Física o Motora', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_fisica">Física o Motora</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_visual" name="discapacidad[]" value="Sensorial-Visual" {{ in_array('Sensorial-Visual', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_visual">Sensorial-Visual</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_auditiva" name="discapacidad[]" value="Sensorial-Auditiva" {{ in_array('Sensorial-Auditiva', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_auditiva">Sensorial-Auditiva</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_intelectual" name="discapacidad[]" value="Intelectual o Cognitiva" {{ in_array('Intelectual o Cognitiva', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_intelectual">Intelectual o Cognitiva</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_psicosocial" name="discapacidad[]" value="Psicosocial o Mental" {{ in_array('Psicosocial o Mental', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_psicosocial">Psicosocial o Mental</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="discapacidad_ninguna" name="discapacidad[]" value="Ninguna de las anteriores" {{ in_array('Ninguna de las anteriores', old('discapacidad', $beneficiario->discapacidad ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="discapacidad_ninguna">Ninguna de las anteriores</label>
                        </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Beneficiario</button>
    </form>
</div>
@endsection
