<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OnpeController extends Controller
{
    private function responder($resultado, $mensajeExito, $mensajeError, $campo = 'data')
    {
        $encontrado = !empty($resultado);

        return response()->json([
            'success' => $encontrado,
            $campo => $encontrado ? $resultado : null,
            'message' => $encontrado ? $mensajeExito : $mensajeError
        ], $encontrado ? 200 : 404);
    }


    public function comprobarDepartamento($nombre)
    {
        $consulta = DB::select(
            'CALL sp_isDepartamento(?)',
            [$nombre]
        );

        return $this->responder(
            $consulta,
            'Departamento encontrado correctamente',
            'El departamento no existe'
        );
    }


    public function comprobarProvincia($nombre)
    {
        $consulta = DB::select(
            'CALL sp_isProvincia(?)',
            [$nombre]
        );

        return $this->responder(
            $consulta,
            'Provincia encontrada correctamente',
            'La provincia no existe'
        );
    }


    public function listarDepartamentos($desde, $hasta)
    {
        $registros = DB::select(
            'CALL sp_getDepartamentos(?, ?)',
            [$desde, $hasta]
        );

        return $this->responder(
            $registros,
            'Departamentos encontrados',
            'No existen departamentos en el rango indicado'
        );
    }

    public function listarProvincias($departamentoId)
    {
        $registros = DB::select(
            'CALL sp_getProvincias(?)',
            [$departamentoId]
        );

        return $this->responder(
            $registros,
            'Provincias encontradas',
            'No se encontraron provincias'
        );
    }


    public function provinciasPorNombreDepartamento($nombreDepartamento)
    {
        $registros = DB::select(
            'CALL sp_getProvinciasbyDepartamento(?)',
            [$nombreDepartamento]
        );

        return $this->responder(
            $registros,
            'Provincias encontradas',
            'No se encontraron provincias para el departamento indicado'
        );
    }


    public function listarDistritos($provinciaId)
    {
        $registros = DB::select(
            'CALL sp_getDistritos(?)',
            [$provinciaId]
        );

        return $this->responder(
            $registros,
            'Distritos encontrados',
            'No se encontraron distritos'
        );
    }


    public function distritosPorProvincia($nombreProvincia)
    {
        $registros = DB::select(
            'CALL sp_getDistritosByProvincia(?)',
            [$nombreProvincia]
        );

        return $this->responder(
            $registros,
            'Distritos encontrados',
            'No se encontraron distritos para la provincia indicada'
        );
    }


    public function listarLocales($distritoId)
    {
        $registros = DB::select(
            'CALL sp_getLocalesVotacion(?)',
            [$distritoId]
        );

        return $this->responder(
            $registros,
            'Locales de votación encontrados',
            'No se encontraron locales de votación'
        );
    }


    public function buscarLocalPorUbicacion($provincia, $distrito)
    {
        $registros = DB::select(
            'CALL sp_getLocalesVotacionByDistrito(?, ?)',
            [$provincia, $distrito]
        );

        return $this->responder(
            $registros,
            'Locales encontrados',
            'No se encontraron locales para la ubicación indicada'
        );
    }


    public function listarGrupos($localId)
    {
        $registros = DB::select(
            'CALL sp_getGruposVotacion(?)',
            [$localId]
        );

        return $this->responder(
            $registros,
            'Grupos de votación encontrados',
            'No se encontraron grupos de votación'
        );
    }


    public function gruposPorUbicacion($provincia, $distrito, $local)
    {
        $registros = DB::select(
            'CALL sp_getGruposVotacionByProvinciaDistritoLocal(?, ?, ?)',
            [
                $provincia,
                $distrito,
                $local
            ]
        );

        return $this->responder(
            $registros,
            'Grupos de votación encontrados',
            'No existen grupos para la ubicación indicada'
        );
    }


    public function consultarActa($codigoGrupo)
    {
        $resultado = DB::select(
            'CALL sp_getGrupoVotacion(?)',
            [$codigoGrupo]
        );

        $existe = count($resultado) > 0;

        return response()->json([
            'success' => $existe,
            'acta' => $existe ? $resultado : null,
            'message' => $existe
                ? 'Acta encontrada correctamente'
                : 'No se encontró el acta solicitada',
            'status' => $existe ? 200 : 404
        ], $existe ? 200 : 404);
    }

    public function consultarActaPorUbicacion($departamento, $provincia, $distrito, $local, $grupo)
    {
        $datos = DB::select(
            'CALL sp_getGrupoVotacionByProvinciaDistritoLocalGrupo(?, ?, ?, ?, ?)',
            [$departamento, $provincia, $distrito, $local, $grupo]
        );

        return $this->responder(
            $datos,
            'Acta encontrada correctamente',
            'No se encontró el acta'
        );
    }


    public function resumenVotos($inicio, $fin)
    {
        $datos = DB::select(
            'CALL sp_getVotos(?, ?)',
            [$inicio, $fin]
        );

        return $this->responder(
            $datos,
            'Votos encontrados correctamente',
            'No se encontraron votos'
        );
    }


    public function votosPorDepartamento($departamento)
    {
        $datos = DB::select(
            'CALL sp_getVotosDepartamento(?)',
            [$departamento]
        );

        return $this->responder(
            $datos,
            'Votos del departamento encontrados',
            'No se encontraron votos para el departamento'
        );
    }


    public function votosPorProvincia($provincia)
    {
        $datos = DB::select(
            'CALL sp_getVotosProvincia(?)',
            [$provincia]
        );

        return $this->responder(
            $datos,
            'Votos de la provincia encontrados',
            'No se encontraron votos para la provincia'
        );
    }


    public function distritosDelDepartamento($departamento)
    {
        $datos = DB::select(
            'CALL sp_getDistritosDepartamento(?)',
            [$departamento]
        );

        return $this->responder(
            $datos,
            'Distritos encontrados correctamente',
            'No se encontraron distritos'
        );
    }


    public function localesDelDepartamento($departamento)
    {
        $datos = DB::select(
            'CALL sp_getLocalesVotacionDepartamento(?)',
            [$departamento]
        );

        return $this->responder(
            $datos,
            'Locales de votación encontrados',
            'No se encontraron locales de votación'
        );
    }

}