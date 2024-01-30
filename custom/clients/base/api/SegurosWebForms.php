<?php
/**
 * User: salvador.lopez
 * Date: 30/01/2024
 */


if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SegurosWebForms extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'setValuesWebForms' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('updateWebForms'),
                //endpoint variables
                'pathVars' => array('endpoint'),
                //method to call
                'method' => 'updateSegurosWebForms',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Actualiza folio y status de Web Forms en registro de Seguros',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    /**
     * Actualiza folio y status de Web Forms en registro de Seguros
     */
    public function updateSegurosWebForms($api, $args)
    {

        $response = array();
        $idSeguro=$args['idSeguro'];
        $folio=$args['folio'];
        $status=$args['status'];

        if( empty($idSeguro) || empty($folio) || empty($status) ){
            $response = array(
                "status" => "error",
                "msg" => "Favor de establecer valor para idSeguro, folio y status",
            );

        }else{

            $idLista = $this->searchIdListFromValue($status);

            if( $idLista == "" ){
                $response = array(
                    "status" => "error",
                    "msg" => "Favor de establecer un status válido",
                );
            }else{

                $beanSeguro = BeanFactory::retrieveBean('S_seguros', $idSeguro, array('disable_row_level_security' => true));

                if (empty($beanSeguro) || $beanSeguro == null) {

                    $response = array(
                        "status" => "error",
                        "msg" => "ID de Seguro no encontrado",
                    );

                }else{

                    $beanSeguro->folio_web_c = $folio;
                    $beanSeguro->status_web_c = $idLista;
                    $beanSeguro->save();

                    $response = array(
                        "status" => "ok",
                        "msg" => "El registro con el idSeguro " .$idSeguro." se actualizó conrrectamente",
                    );

                }

            }
            

        }

        

        return $response;

    }

    public function searchIdListFromValue( $value ){
        global $app_list_strings;
        $id_list = "";

        $list_match = $app_list_strings['status_seguro_web_match_list'];

        foreach ($list_match as $key => $list_val) {

            if( $list_val == $value ){
                $id_list = $key;
            }
            
        }
        $GLOBALS['log']->fatal("ID ENCONTRADO: ".$id_list);

        return $id_list;

    }


}

?>