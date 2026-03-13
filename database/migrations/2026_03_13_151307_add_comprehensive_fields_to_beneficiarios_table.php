<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('beneficiarios', function (Blueprint $table) {
            // Datos personales adicionales
            $table->string('cedula')->unique()->nullable()->after('nombre');
            $table->string('lugar_nacimiento')->nullable()->after('fecha_nacimiento');
            $table->string('nacionalidad')->default('Venezolana')->after('lugar_nacimiento');
            $table->string('estado_civil')->nullable()->after('genero');

            // Información familiar
            $table->string('nombre_conyuge')->nullable()->after('estado_civil');
            $table->string('telefono_conyuge')->nullable()->after('nombre_conyuge');
            $table->integer('hijos')->nullable()->after('telefono_conyuge');
            $table->text('familiares_cercanos')->nullable()->after('hijos');

            // Datos de contacto y ubicación adicionales
            $table->string('telefono_alternativo')->nullable()->after('telefono');
            $table->string('email_alternativo')->nullable()->after('email');
            $table->string('estado')->nullable()->after('direccion');
            $table->string('municipio')->nullable()->after('estado');
            $table->string('parroquia')->nullable()->after('municipio');
            $table->string('sector')->nullable()->after('parroquia');
            $table->string('punto_referencia')->nullable()->after('sector');

            // Información médica básica
            $table->string('tipo_sangre')->nullable()->after('punto_referencia');
            $table->string('alergias')->nullable()->after('tipo_sangre');
            $table->text('medicamentos_actuales')->nullable()->after('alergias');
            $table->text('enfermedades_cronicas')->nullable()->after('medicamentos_actuales');
            $table->string('medico_cabecera')->nullable()->after('enfermedades_cronicas');
            $table->string('telefono_medico')->nullable()->after('medico_cabecera');

            // Información socioeconómica detallada adicional
            $table->string('nivel_educativo')->nullable()->after('gastos');
            $table->string('ocupacion_anterior')->nullable()->after('nivel_educativo');
            $table->string('ayuda_economica')->nullable()->after('ocupacion_anterior');

            // Información de vivienda
            $table->string('tipo_vivienda')->nullable()->after('ayuda_economica');
            $table->string('condicion_vivienda')->nullable()->after('tipo_vivienda');
            $table->integer('numero_habitantes')->nullable()->after('condicion_vivienda');
            $table->string('materiales_construccion')->nullable()->after('numero_habitantes');
            $table->json('servicios')->nullable()->after('materiales_construccion');

            // Necesidades especiales y discapacidad
            $table->string('tiene_discapacidad')->nullable()->after('servicios');
            $table->string('ayudas_tecnicas')->nullable()->after('tiene_discapacidad');
            $table->text('necesidades_especiales')->nullable()->after('ayudas_tecnicas');

            // Información de referencia
            $table->string('persona_referencia')->nullable()->after('necesidades_especiales');
            $table->string('parentesco_referencia')->nullable()->after('persona_referencia');
            $table->string('telefono_referencia')->nullable()->after('parentesco_referencia');
            $table->string('direccion_referencia')->nullable()->after('telefono_referencia');

            // Información adicional
            $table->text('observaciones')->nullable()->after('direccion_referencia');
            $table->date('fecha_ingreso')->nullable()->after('observaciones');
            $table->string('estado_beneficiario')->default('activo')->after('fecha_ingreso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiarios', function (Blueprint $table) {
            // Revertir todos los cambios en orden inverso
            $table->dropColumn([
                'cedula',
                'lugar_nacimiento',
                'nacionalidad',
                'estado_civil',
                'nombre_conyuge',
                'telefono_conyuge',
                'hijos',
                'familiares_cercanos',
                'telefono_alternativo',
                'email_alternativo',
                'estado',
                'municipio',
                'parroquia',
                'sector',
                'punto_referencia',
                'tipo_sangre',
                'alergias',
                'medicamentos_actuales',
                'enfermedades_cronicas',
                'medico_cabecera',
                'telefono_medico',
                'nivel_educativo',
                'ocupacion_anterior',
                'ayuda_economica',
                'tipo_vivienda',
                'condicion_vivienda',
                'numero_habitantes',
                'materiales_construccion',
                'servicios',
                'tiene_discapacidad',
                'ayudas_tecnicas',
                'necesidades_especiales',
                'persona_referencia',
                'parentesco_referencia',
                'telefono_referencia',
                'direccion_referencia',
                'observaciones',
                'fecha_ingreso',
                'estado_beneficiario',
            ]);
        });
    }
};
