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
