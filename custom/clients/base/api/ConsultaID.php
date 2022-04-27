<?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 29/04/2019
 * Time: 1:53 PM
 */

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ConsultaID extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'recuperaID' => array(
                'reqType' => 'GET',
                'path' => array('recuperaID','?'),
                'pathVars' => array('','categoriaID'),
                'method' => 'RecuperaID',
                'shortHelp' => 'Realiza consulta a nivel db para actualizar la columna "valor"',
                'longHelp' => 'custom/clients/base/api/help/recuperaID.html',
            ),
        );
    }
    //Funcion para recuperar valor de la tabla unifin_folio para los modulos backlog, cuentas y solicitudes.
    public function RecuperaID($api, $args)
    {   //Declaración de variables para el usuario logueado, fecha actual y estructura de respuesta.
        global $current_user;
        $idUsuario =  $current_user->id;
        $timedate = new SugarDateTime();
        $today = $timedate->asDb();
        $Respuesta = array(
            Estado => "",
            Descripcion => "",
        );
        /*Recupera argumentos de la petición.
        Dependiendo el número de petición es su asociación en la tabla unifin_folios:
          1 = Folio de Backlog
          2 = ID Cliente
          3 = ID Prospecto
          4 = ID Solicitud
           */
        $idTipo = $args['categoriaID'];
        /*Valida que la categoría esté dentro del catálogo de folios (1-4).*/
        if($idTipo>=1 && $idTipo<=4) {
            try {
                /*Realiza consulta a db para traer el valor correspondiente a "valor" en la tabla unifin_folios.*/
                $query = "select valor
                          from unifin_folios
                          where id=" . $idTipo . "
                              ;";
                $folio = $GLOBALS['db']->query($query);
                while ($row = $GLOBALS['db']->fetchByAssoc($folio)) {
                    $folio = $row['valor'];
                }
                //Se realiza la suma al objeto nuevoFolio de +1
                $nuevoFolio = $folio + 1;
                //Actualiza el valor de nuevo folio en db así como el de la fecha de modificación y usuario logueado.
                $actualiza = "update unifin_folios set 
                    valor =" . $nuevoFolio .",
                    date_modified ='" . $today . "',
                    modified_user_id = '". $idUsuario. "' 
                    where id=" . $idTipo . ";";
                //Ejecuta el update correspondiente.
                $actualizaRespuesta = $GLOBALS['db']->query($actualiza);
                //Genera respuesta exitosa
                $Respuesta['Estado'] = "¡Exito!";
                $Respuesta['Descripcion'] = "El ID se ha generado.";
                $Respuesta['Id'] = $folio;
                return $Respuesta;
            } catch (Exception $e){
                //Muestra error obtenido en el catch.
                $Respuesta['Estado'] = "¡Error!";
                $Respuesta['Descripcion'] = $e->getMessage();
                return $Respuesta;
            }
        }else {
            //Genera respuesta de Error.
            $Respuesta['Estado'] = "¡Error!";
            $Respuesta['Descripcion'] = "El tipo de folio no existe, favor de intentar de nuevo.";
            return $Respuesta;
        }
    }
}