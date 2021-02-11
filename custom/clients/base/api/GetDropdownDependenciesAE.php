<?php
/*
 * Created by PhpStorm.
 * User: AF.Tactos
 * Date: 2020-12-15
*/

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetDropdownDependenciesAE extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
    */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'POST',
                //'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetDropdownDependenciesAE'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getDropdownDependenciesMethodAE',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método para recuperar la dependencia de visibilidad entre 2 campos desplegables. Generado para clasificación sectorial',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    /**
     * Obtiene valores de listas pertenecientes a la instancia de Sugar
     *
     * Método para recuperar la dependencia de visibilidad entre 2 campos desplegables
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento: modulo & campo
     * $args['modulo']  =  Nombre del módulo plural
     * $args['moduloSingular']  =  Nombre del módulo singular
     * $args['campo']  =  Nombre del campo
    */
    public function getDropdownDependenciesMethodAE($api, $args)
    {
        //Inicializa variable de resultado
        $result = [];
        $result["estado"]="";
        $result["descripcion"]="";
        $result["padre"]="";
        $result["valores"]=[];
        $campoPadre = '';
        $campoHijo = '';



        //Valida existencia de dependencia
        if ($args['campo']=='tct_macro_sector_ddw_c') {
            $result["estado"]="error";
            $result["descripcion"]="El campo {$args['campo']} no tiene dependencia";
            // Regresa respuesta
            return $result;
        }
        //Case padre
        switch ($args['campo']) {
          case 'actividadeconomica_c':
            $campoPadre = 'id_subsector_economico_cnbv';
            $campoHijo = 'id_actividad_economica_cnbv';
            $result["padre"]= 'subsectoreconomico_c';
            // $result["valores"] = array(
            //   "111"=> array(
            //       "0112160",
            //       "0111013",
            //       "0111021"
            //   ),
            //   "114"=> array(
            //       "0421016",
            //       "0422014"
            //   ),
            //   ""=> array()
            // );
            break;
          case 'subsectoreconomico_c':
            $campoPadre = 'id_sector_economico_cnbv';
            $campoHijo = 'id_subsector_economico_cnbv';
            $result["padre"]='sectoreconomico_c';
            // $result["valores"] = array(
            //   "11"=> array(
            //       "111",
            //       "114"
            //   )
            // );
            break;
          case 'sectoreconomico_c':
            $campoPadre = 'id_macro_sector_cnbv';
            $campoHijo = 'id_sector_economico_cnbv';
            $result["padre"]='tct_macro_sector_ddw_c';
            // $result["valores"] = array(
            //   "1"=> array(
            //       "11"
            //   ),
            //   ""=> array()
            // );
            break;
          default:
            // code...
            break;
        }

        //Recupera valores de dependencia
        $query="select distinct
          	     {$campoPadre},
                 {$campoHijo}
               from catalogo_clasificacion_sectorial";

        $resultQuery=$GLOBALS['db']->query($query);

        if($resultQuery->num_rows > 0){
            //$result["valores"] = [];
            while($row = $GLOBALS['db']->fetchByAssoc($resultQuery))
            {
                $idPadre = $row[$campoPadre];
                $idHijo = $row[$campoHijo];
                if (empty($result["valores"][$idPadre])) {
                  $result["valores"][$idPadre] = [];
                }
                $result["valores"][$idPadre][] = $idHijo;
            }
        }
        $result["estado"]="exito";
        $result["descripcion"]="Se muestra la dependencia entre el campo {$args['campo']} y {$result['padre']}";

        // Regresa respuesta
        return $result;
    }
}

?>
