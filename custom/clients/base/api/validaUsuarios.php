<?php
require_once('include/SugarQuery/SugarQuery.php');
class validaUsuarios extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'retrieve' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('validaUsuarios', '?'),
                'pathVars' => array('module', 'invitados'),
                'method' => 'validaUsuarios1',
                'shortHelp' => 'Método GET para validar que los usuarios no puedan crear la reunion',
                'longHelp' => '',
            ),
        );
    }

    public function validaUsuarios1($api, $args)
    {
      //Recuperar variables
      $invitados = $args['invitados'];
      $puestos = $GLOBALS['app_list_strings']['prospeccion_c_list'];
      $flag = true;
      global $db;

      //Tratar variables
      $invitados = str_replace(",","','",$invitados);
      $puestos = array_keys($puestos);
      //$GLOBALS['log']->fatal($invitados);
		  //$GLOBALS['log']->fatal(print_r($puestos,true));

      //Definir y ejecutar consulta
      $query = "SELECT puestousuario_c from users_cstm WHERE id_c in ('{$invitados}');";
      $queryResult = $db->query($query);
      //$GLOBALS['log']->fatal($query);

      //Validar registros recuperados
      while($row = $db->fetchByAssoc($queryResult))
      {
         $puesto = $row['puestousuario_c'];
         if (!in_array($puesto, $puestos)) {
            $flag = false;
          }
      }

      //Regresar resultado
      return $flag;
    }
}
