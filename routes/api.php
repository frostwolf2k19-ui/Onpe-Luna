<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\OnpeController;

$onpe = OnpeController::class;


// ---------------------------------------------------------
// UBICACIONES Y VALIDACIONES
// ---------------------------------------------------------

Route::controller($onpe)->group(function () {

    Route::get(
        'is_departamento/{detalle}',
        'comprobarDepartamento'
    );

    Route::get(
        'is_provincia/{detalle}',
        'comprobarProvincia'
    );


    // -----------------------------------------------------
    // DEPARTAMENTOS
    // -----------------------------------------------------

    Route::get(
        'departamentos/{inicio}/{fin}',
        'listarDepartamentos'
    );


    // -----------------------------------------------------
    // PROVINCIAS
    // -----------------------------------------------------

    Route::get(
        'provincias/{idDepartamento}',
        'listarProvincias'
    );

    Route::get(
        'provincias_departamento/{departamento}',
        'provinciasPorNombreDepartamento'
    );


    // -----------------------------------------------------
    // DISTRITOS
    // -----------------------------------------------------

    Route::get(
        'distritos/{idProvincia}',
        'listarDistritos'
    );

    Route::get(
        'distritos_provincia/{provincia}',
        'distritosPorProvincia'
    );


    // -----------------------------------------------------
    // LOCALES DE VOTACIÓN
    // -----------------------------------------------------

    Route::get(
        'locales_votacion/{idDistrito}',
        'listarLocales'
    );

    Route::get(
        'locales_votacion_distrito/{provincia}/{distrito}',
        'buscarLocalPorUbicacion'
    );


    // -----------------------------------------------------
    // GRUPOS DE VOTACIÓN
    // -----------------------------------------------------

    Route::get(
        'grupos_votacion/{idLocalVotacion}',
        'listarGrupos'
    );

    Route::get(
        'grupos_votacion_ubicacion/{provincia}/{distrito}/{local}',
        'gruposPorUbicacion'
    );


    // -----------------------------------------------------
    // ACTAS / GRUPOS
    // -----------------------------------------------------

    Route::get(
        'grupo_votacion/{grupo_votacion}',
        'consultarActa'
    );

    Route::get(
        'grupo_votacion_detalle/{departamento}/{provincia}/{distrito}/{local}/{grupo}',
        'consultarActaPorUbicacion'
    );


    // -----------------------------------------------------
    // RESULTADOS DE VOTACIÓN
    // -----------------------------------------------------

    Route::get(
        'votos/{inicio}/{fin}',
        'resumenVotos'
    );

    Route::get(
        'votos_departamento/{departamento}',
        'votosPorDepartamento'
    );

    Route::get(
        'votos_provincia/{provincia}',
        'votosPorProvincia'
    );


    // -----------------------------------------------------
    // CONSULTAS COMPLEMENTARIAS
    // -----------------------------------------------------

    Route::get(
        'distritos_departamento/{departamento}',
        'distritosDelDepartamento'
    );

    Route::get(
        'locales_votacion_departamento/{departamento}',
        'localesDelDepartamento'
    );
});