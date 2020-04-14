<?php

/**
 * Created by tactos.
 * User: JG
 * Date: 13/04/20
 * Time: 08:39 AM
 */
class mambuAccounts extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('deltaAccounts'),
                //endpoint variables
                'pathVars' => array('module'),
                //method to call
                'method' => 'getDeltaAccounts',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Servicio para exponer las cuentas que han sufrido cambio en el nombre  al dia actual',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    public function getDeltaAccounts($api, $args)
    {
        global $db, $current_user;
        $deltas = array("records" => array());
        try {
            $queryDelta = "
SELECT
distinct
b.id_c,
date_format(CONVERT_TZ(date_created, '+00:00', @@global.time_zone), '%Y-%m-%d') ,
field_name,
data_type,
parent_id,
b.primernombre_c,
b.apellidopaterno_c,
b.apellidomaterno_c,
b.tipodepersona_c,
b.razonsocial_c
FROM
accounts_audit a
JOIN accounts_cstm b
ON b.id_c = a.parent_id
WHERE
field_name = 'name'
AND date_format(CONVERT_TZ(date_created, '+00:00', @@global.time_zone), '%Y-%m-%d') = date_format(NOW(), '%Y-%m-%d')
AND before_value_string != after_value_string";

            $GLOBALS['log']->fatal($queryDelta);

            $result = $db->query($queryDelta);
            while ($row = $db->fetchByAssoc($result)) {
                $nombre = $row['tipodepersona_c'] == "Persona Moral" ? $row['razonsocial_c'] : $row['primernombre_c'];
                $apellido = $row['apellidopaterno_c'] != null ? $row['apellidopaterno_c']. " ".$row['apellidomaterno_c'] : "";
                $record =
                    [
                        "id" => $row['id_c'],
                        "firstName" => $nombre,
                        "lastName" => $apellido

                    ];

                array_push($deltas['records'], $record);

            }


            return $deltas;

        } catch
        (Exception $e) {
            error_log(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error: " . $e->getMessage());
            $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " <" . $current_user->user_name . "> : Error " . $e->getMessage());
        }
    }
}