<?php
/**.
 * User: salvador.lopez@tactos.com.mx
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class LlamadasMasivas extends SugarApi
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
                'reqType' => 'POST',
                //'noLoginRequired' => true,
                //endpoint path
                'path' => array('AltaLlamadasMasivas'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'generaLlamadasMasivas',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Genera un registro de llamada a cada registro de Público Objetivo enviado en la petición',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );
    }

    public function generaLlamadasMasivas($api, $args){

        global $current_user;

        $llamadas_generadas = array();
        $registrosPO = $args['records'];
        $asunto = $args['asunto'];
        $fecha_inicio = $args['fecha_inicio'];
        $hora_inicio = $args['hora_inicio'];
        $fecha_fin = $args['fecha_fin'];
        $hora_fin = $args['hora_fin'];
        $duracion_horas = $args['duracion_horas'];
        $duracion_minutos = $args['duracion_minutos'];
        $resultado = $args['resultado'];

        for ($i=0; $i < count( $registrosPO ); $i++) { 
            # code...
            $bean_llamada = BeanFactory::newBean('Calls');
            $bean_llamada->name = $asunto;
            //$bean_llamada->minut_minutas_calls_1minut_minutas_ida=$bean->id;
            $start = date("d/m/Y h:i a", strtotime($fecha_inicio . "T" . $hora_inicio));
            $bean_llamada->date_start = $start;
            $end = date("d/m/Y h:i a", strtotime($fecha_fin . "T" . $hora_fin));
            $bean_llamada->duration_hours = $duracion_horas;
            $bean_llamada->duration_minutes = $duracion_minutos;
            $bean_llamada->parent_id = $registrosPO[$i];
            $bean_llamada->parent_type = "Prospects";
            $bean_llamada->assigned_user_id = $current_user->id;
            $bean_llamada->status = 'Planned';
            $bean_llamada->tct_resultado_llamada_ddw_c = $resultado;
            $bean_llamada->save();

            array_push($llamadas_generadas, $bean_llamada->id);

            $GLOBALS['log']->fatal("Se guarda llamada con id: ".$bean_llamada->id);
        }


        return array(
            "status" => 200,
            "message" => "Se generaron las llamadas correctamente",
            "detail" => $llamadas_generadas
        );;
    }
}
