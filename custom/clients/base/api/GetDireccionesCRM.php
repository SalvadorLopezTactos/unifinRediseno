<?php
/**
 * Created by Salvador Lopez.
 * email: salvador.lopez@tactos.com.mx
 * Date: 07/06/18
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetDireccionesCRM extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('GetDireccionesCRM','?','?','?'),
                //endpoint variables
                'pathVars' => array('','module','record','type'),
                //method to call
                'method' => 'GetDireccionesCRMFunction',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para obtener direcciones filtrando por indicarod(tipo) y módulo',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Obtiene direcciones relacionadas a un módulo particular
     *
     * Método que obtiene registros de direcciones relacionadas a una persona filtradas por indicador
     *
     * @param array $api
     * @param array $args Array con los par�metros enviados para su procesamiento
     * @return array Direcciones relacionadas
     * @throws SugarApiExceptionInvalidParameter
     */
    public function GetDireccionesCRMFunction($api, $args)
    {
        //Obtiene id de persona
        $module = isset($args['module']) ? $args['module'] : '';
        $recordId = isset($args['record']) ? $args['record'] : '';
        $type = isset($args['type']) ? $args['type'] : '';

        //Incializa variables
        global $app_list_strings;
        $arr_ids = explode(",", $type);
        $list_indicadores_map = $app_list_strings['dir_indicador_map_list'];
        $id_indicador = GetDireccionesCRM::getIndicadorMap($type, $list_indicadores_map);

        //Consulta direcciones asociadas a cuenta
        $query = "SELECT d.*, dc.*
            FROM accounts a
              INNER JOIN accounts_dire_direccion_1_c ad ON a.id = ad.accounts_dire_direccion_1accounts_ida
              INNER JOIN dire_direccion d ON d.id = ad.accounts_dire_direccion_1dire_direccion_idb
              LEFT JOIN dire_direccion_cstm dc ON dc.id_c = d.id
            WHERE
              a.id = '{$recordId}'
              AND indicador IN ('{$id_indicador}')
              AND d.deleted=0
              AND ad.deleted=0;";

        $result = $GLOBALS['db']->query($query);

        $records_in = array('records' => array());
        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
            $records_in['records'][] = $row;
            $pos++;
        }

        //Regresa resultado
        return $records_in;
    }

    /**
     * Obtiene clave de una lista
     *
     * Método que obtiene la clave de un valor pasado como parámetro, el cual será buscado en una lista
     *
     * @param string $valor Cadena a buscar dentro de la lista
     * @param array $list_indicadores_map Array perteneciente a la lista dir_indicador_map_list
     * @return string $key_encontrados Claves encontradas (separadas por comas) que contienen en su etiqueta el $valor pasado como parámetro
     */
    public function getIndicadorMap($valor, $list_indicadores_map)
    {

        $array_return = array();

        foreach ($list_indicadores_map as $key => $value) {
            //Cada etiqueta del arreglo map, convertirla en un arreglo
            $arr_buscar = explode(",", $value);
            $valor_encontrado = array_search($valor, $arr_buscar);
            if ($valor_encontrado !== false) {
                array_push($array_return, $key);
            }

        }
        //Uniendo elementos de array en un string
        $key_encontrados = implode("','", $array_return);

        return $key_encontrados;

    }

}

?>
