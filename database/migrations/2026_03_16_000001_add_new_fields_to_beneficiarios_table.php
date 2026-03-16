<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiarios', function (Blueprint $table) {
            // Información comunitaria
            $table->string('comunidad')->nullable()->after('sector');
            $table->string('comuna')->nullable()->after('comunidad');
            $table->string('consejo_comunal')->nullable()->after('comuna');
            $table->string('centro_electoral')->nullable()->after('consejo_comunal');

            // Información profesional
            $table->string('profesion')->nullable()->after('ocupacion_anterior');

            // Actividades de interés
            $table->text('actividades_formativas')->nullable()->after('observaciones');
            $table->text('actividades_recreativas')->nullable()->after('actividades_formativas');
        });
    }

    public function down(): void
    {
        Schema::table('beneficiarios', function (Blueprint $table) {
            $table->dropColumn([
                'comunidad',
                'comuna',
                'consejo_comunal',
                'centro_electoral',
                'profesion',
                'actividades_formativas',
                'actividades_recreativas',
            ]);
        });
    }
};
