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
            'ParticipantesRecord' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('RecordParticipantes', '?'),
                'pathVars' => array('module', 'id_Minuta'),
                'method' => 'getParticipantesReunionRecord',
                'shortHelp' => 'Método para obtener los participantes invitados en la Reunion y mostrar en la Vista Detalle',
                'longHelp' => '',
            ),


        );

    }

    public function getParticipantesReunion($api, $args)
    {
        $idReunion = $args['id_Reunion'];
        $beanReunion = BeanFactory::getBean("Meetings", $idReunion, array('disable_row_level_security' => true));
        $idCuenta = $beanReunion->parent_id; // id de la cuenta asociada
        global $current_user;

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
                    "asistencia" => $value->id==$current_user->id?1:0,
                    "activo" => $value->id==$current_user->id?"":"1",

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
                "apaterno" => $beanCuentas->apellidopaterno_c,
                "amaterno" => $beanCuentas->apellidomaterno_c,
                "telefono" => $beanCuentas->phone_office,
                "correo" => $beanCuentas->email1,
                "origen" => "C",
                "unifin" => 0,
                "tipo_contacto" => "",
                "asistencia" => 0,
                "activo" => "1",
            ];
            array_push($respuestaJson['participantes'], $participantesCuentas);
        }
        return $respuestaJson;
    }


    public function getParticipantesReunionRecord($api, $args)
    {
        $idMinuta = $args['id_Minuta'];

        // CREAMOS LA ESTRUCTURA DE LA RESPUESTA
        $respuestaJson = array('participantes' => array(), 'compromisos' => array());

        $queryRecord = "SELECT T3.id,T3.name,T3.description,T3.tct_apellido_paterno_c,T3.tct_apellido_materno_c,T3.tct_nombre_completo_c,
       T3.tct_correo_c,T3.tct_telefono_c,T3.tct_asistencia_c,T3.tct_tipo_registro_c
        FROM minut_minutas T1
        INNER JOIN minut_minutas_minut_participantes_c T2
        ON T2.minut_minutas_minut_participantesminut_minutas_ida=T1.id
        INNER JOIN minut_participantes T3
        ON T3.id=T2.minut_minutas_minut_participantesminut_participantes_idb
        WHERE T1.id='{$idMinuta}'
        AND T1.deleted=0
        AND T2.deleted=0
        AND T3.deleted=0";

        $resultado = $bd = $GLOBALS['db']->query($queryRecord);

        while ($row = $GLOBALS['db']->fetchByAssoc($resultado)) {

            $participantesMinuta = [

                "id" => $row['id'],
                "nombres" => $row['name'],
                "apaterno" => $row['tct_apellido_paterno_c'],
                "amaterno" => $row['tct_apellido_materno_c'],
                "telefono" => $row['tct_telefono_c'],
                "correo" => $row['tct_correo_c'],
                "origen" => "",
                "unifin" => (int)$row['description'],
                "tipo_contacto" => $row['tct_tipo_registro_c'],
                "asistencia" => (int)$row['tct_asistencia_c'],

            ];

            array_push($respuestaJson['participantes'], $participantesMinuta);
        }
        return $respuestaJson;
    }


}