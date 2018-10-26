<?php
/**
 * @author F. Javier G. Solar
 * Date: 23/10/2018
 * Time: 01:50 PM
 */


class MinutaReunion extends SugarApi
{


    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(

            'GET_Participantes' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('GetParticipantes', '?'),
                'pathVars' => array('module', 'id_Reunion'),
                'method' => 'getParticipantesReunion',
                'shortHelp' => 'Método GET para obtener los participantes invitados en la Reunion',
                'longHelp' => '',
            ),

            'POST_Participantes' => array(
                'reqType' => 'POST',
                'noLoginRequired' => true,
                'path' => array('CreateParticipantes'),
                'pathVars' => array(''),
                'method' => 'createParticipantes',
                'shortHelp' => 'Agrega  participantes que no se encontraban en la reunion',
            ),


        );

    }

    public function getParticipantesReunion($api, $args)
    {
        $idReunion = $args['id_Reunion'];
        $beanReunion = BeanFactory::getBean("Meetings", $idReunion);
        $idCuenta = $beanReunion->parent_id; // id de la cuenta asociada

        // CREAMOS LA ESTRUCTURA DE LA RESPUESTA
        $respuestaJson = array('idReunion' => $idReunion, 'idCuenta' => $idCuenta, 'participantes' => array(), 'compromisos' => array());
        /* Obtenemos los usuarios invitados a la reunion*/
        if ($beanReunion->load_relationship('users')) {
            //Fetch related beans
            $relatedBeans = $beanReunion->users->getBeans();

            $participantes = array();
            foreach ($relatedBeans as $value) {
                $participantes = [
                    "id" => $value->id,
                    "nombres" => $value->first_name,
                    "apaterno" => $value->last_name,
                    "amaterno" => "",
                    "telefono" => $value->phone_work,
                    "correo" => $value->email1,
                    "origen" => "U",
                    "unifin" => 1,
                    "tipo_contacto" => "",
                    "asistencia" => 0,

                ];

                //$respuestaJson['participantes']['id']=$value->id ;
                array_push($respuestaJson['participantes'], $participantes);
            }


        }

        /* Buscamos los Contactos de la cuenta relacionada con la Reunion */
        $query = "SELECT t1.rel_relaciones_accounts_1rel_relaciones_idb as id_relacion, t2.relaciones_activas, t3.account_id1_c
FROM rel_relaciones_accounts_1_c t1
       INNER JOIN rel_relaciones t2 ON t2.id = t1.rel_relaciones_accounts_1rel_relaciones_idb
       INNER JOIN rel_relaciones_cstm t3 ON t3.id_c = t2.id
where t1.rel_relaciones_accounts_1accounts_ida = '{$idCuenta}'
  AND t2.relaciones_activas like '%Contacto%'
  AND t1.deleted = 0
  and t2.deleted = 0";

        $resultado = $bd = $GLOBALS['db']->query($query);

        //Arma respuesta
        while ($row = $GLOBALS['db']->fetchByAssoc($resultado)) {

            $beanCuentas = BeanFactory::getBean("Accounts", $row['account_id1_c']);

            $participantesCuentas = [
                "id" => $beanCuentas->id,
                "nombres" => $beanCuentas->primernombre_c,
                "apaterno" => $value->apellidopaterno_c,
                "amaterno" => $value->apellidomaterno_c,
                "telefono" => $beanCuentas->phone_office,
                "correo" => $beanCuentas->email1,
                "origen" => "C",
                "unifin" => 0,
                "tipo_contacto" => "",
                "asistencia" => 0,
            ];

            array_push($respuestaJson['participantes'], $participantesCuentas);

        }


        return $respuestaJson;
    }


    /*  public function createParticipantes($api, $args)
      {
          $id_Reunion = $args['idReunion'];
          $id_Cuenta = $args['idCuenta'];
          $arrayParti = $args['participantes'];

          $beanParticipantes = BeanFactory::newBean("minut_Participantes");
          $beanParticipantes->


          return $arrayParti;
      }
      */
}