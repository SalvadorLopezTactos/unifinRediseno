<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class PaisesEstadosMap extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetEstado' => array(
                'reqType' => 'GET',
                'path' => array('GetStateIdByName'),
                'pathVars' => array(''),
                'method' => 'getIdEstadoByName',
                'shortHelp' => 'Obtiene el id del estado enviado como parámetro',
            ),
            'GetNameEstado' => array(
                'reqType' => 'GET',
                'path' => array('GetStateNameById'),
                'pathVars' => array(''),
                'method' => 'getNameEstadoById',
                'shortHelp' => 'Obtiene el nombre del estado del id pasado como parámetro',
            ),

            'GetNamePais' => array(
                'reqType' => 'GET',
                'path' => array('GetCountryNameById'),
                'pathVars' => array(''),
                'method' => 'getNameCountryById',
                'shortHelp' => 'Obtiene el nombre del país del id pasado como parámetro',
            ),

            'GetAllPaisesEstados' => array(
                'reqType' => 'GET',
                'path' => array('GetAllCountriesStates'),
                'pathVars' => array(''),
                'method' => 'getAllPaisesEstados',
                'shortHelp' => 'Obtiene todos los países y estados',
            ),
        );
    }

    public function getIdEstadoByName($api, $args)
    {
        $response = array(
            "status"=>"",
            "msg" =>"",
            "stateId" =>""
        );

        $estado = $args['state'];

        if( isset($estado) ){

            $id_estado = $this->searchEstadoByName($estado);

            if( $id_estado !== "" ){

                $response = array(
                    "status"=>"OK",
                    "msg" =>"El id del Estado se obtuvo correctamente",
                    "stateId" =>$id_estado
                );
            }else{

                //generamos insert a la tabla
                $nuevo_id_estado = $this->insertEstado($estado);

                $response = array(
                    "status" => "OK",
                    "msg" => "El id del Estado se obtuvo correctamente",
                    "stateId" => $nuevo_id_estado
                );

            }
            

        }else{
            $response = array(
                "status" => "ERROR",
                "msg" => "Favor de ingresar el estado",
                "stateId" => ""
            );
        }

        return $response;
        
        
    }

    function getNameEstadoById($api, $args){
        $response = array(
            "status" => "",
            "msg" => "",
            "stateName" => ""
        );

        $estado = $args['state_id'];

        if (isset($estado)) {

            $name_estado = $this->searchEstadoById($estado);

            if ($name_estado !== "") {

                $response = array(
                    "status" => "OK",
                    "msg" => "El nombre del Estado se obtuvo correctamente",
                    "stateName" => $name_estado
                );
            } else {

                $response = array(
                    "status" => "OK",
                    "msg" => "El id del Estado ".$estado. " no existe",
                    "stateName" => ""
                );
            }
        } else {
            $response = array(
                "status" => "ERROR",
                "msg" => "Favor de ingresar state_id",
                "stateName" => ""
            );
        }

        return $response;

    }

    function getNameCountryById($api, $args){
        $response = array(
            "status" => "",
            "msg" => "",
            "countryName" => ""
        );

        $idPais = $args['country_id'];

        if (isset($idPais)) {

            $name_pais = $this->searchPaisById($idPais);

            if ($name_pais !== "") {

                $response = array(
                    "status" => "OK",
                    "msg" => "El nombre del País se obtuvo correctamente",
                    "countryName" => $name_pais
                );
            } else {

                $response = array(
                    "status" => "OK",
                    "msg" => "El id del País " . $idPais . " no existe",
                    "countryName" => ""
                );
            }
        } else {
            $response = array(
                "status" => "ERROR",
                "msg" => "Favor de ingresar country_id",
                "countryName" => ""
            );
        }

        return $response;

    }

    function searchEstadoByName( $nombreEstado ){

        $id_estado = "";
        $query = "SELECT * FROM estados WHERE estado = '$nombreEstado';";

        $resultEstado = $GLOBALS['db']->query($query);

        if ($resultEstado->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultEstado)) {
                $id_estado = $row['id'];
            }
        }

        return $id_estado;

    }

    function searchEstadoById($idEstado)
    {

        $name_estado = "";
        $query = "SELECT * FROM estados WHERE id = '$idEstado';";

        $resultEstado = $GLOBALS['db']->query($query);

        if ($resultEstado->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultEstado)) {
                $name_estado = $row['estado'];
            }
        }

        return $name_estado;
    }

    function searchPaisById($idPais){
        $name_pais = "";
        $query = "SELECT pais FROM paises_estados WHERE id_pais = '$idPais' LIMIT 1;";

        $resultPais = $GLOBALS['db']->query($query);

        if ($resultPais->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultPais)) {
                $name_pais = $row['pais'];
            }
        }

        return $name_pais;

    }

    function insertEstado($estado){
        $last_index = $this->getLastIndexEstado();
        $nuevo_indice = "";

        if( $last_index !="" ){
            $indice = $last_index + 1;
            $nuevo_indice = $indice;
            $qInsertEstado = "INSERT INTO estados (id, estado, id_list_estado) VALUES ('$indice','$estado','$indice');";
            $qInsertPaisEstado = "INSERT INTO paises_estados (id, id_pais, pais, id_estado, estado) VALUES (uuid(), '2', 'MEXICO', '$indice', '$estado');";

            $GLOBALS['db']->query($qInsertEstado);
            $GLOBALS['db']->query($qInsertPaisEstado);

            
        }

        return strval($nuevo_indice);

    }

    function getLastIndexEstado(){

        $last_index = "";
        $qIndex = "SELECT id FROM estados ORDER BY CAST(id as unsigned) DESC LIMIT 1;";

        $resultIndex = $GLOBALS['db']->query($qIndex);

        if ($resultIndex->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultIndex)) {
                $last_index = $row['id'];
            }
        }

        return $last_index;

    }

    function getAllPaisesEstados($api, $args){

        $response = array();
        $query = "SELECT * FROM paises_estados ORDER BY date_entered DESC;";

        $resultPaisesEstados = $GLOBALS['db']->query($query);

        if ($resultPaisesEstados->num_rows > 0) {

            while ($row = $GLOBALS['db']->fetchByAssoc($resultPaisesEstados)) {
                array_push($response,$row);
            }
        }

        return $response;

    }


}
