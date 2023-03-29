<?php
/**
 * User: JC
 * Date: 10/10/2018
 * Time: 10:30
 */

class LlamadasAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'createcall' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('createcall'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'createcall',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'createcall Endpoint',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for make a call endpoint
     */
    public function createcall($api, $args)
    {
        //Recupera parámetros para llamada
        $GLOBALS['log']->fatal('Petición para API:createcall');
        global $current_user, $app_list_strings, $sugar_config;
        $id_cliente = isset($args['data']['id_cliente']) ? $args['data']['id_cliente'] : '';
        $nombre_cliente = isset($args['data']['nombre_cliente']) ? $args['data']['nombre_cliente'] : '';
        $numero_cliente = isset($args['data']['numero_cliente']) ? $args['data']['numero_cliente'] : '';
        $modulo = isset($args['data']['modulo']) ? $args['data']['modulo'] : '';
        $posicion = isset($args['data']['posicion']) ? $args['data']['posicion'] : '';
        $puesto_usuario = isset($args['data']['puesto_usuario']) ? $args['data']['puesto_usuario'] : '';
        $ext_usuario = isset($args['data']['ext_usuario']) ? $args['data']['ext_usuario'] : '';
        $es_CP = isset($app_list_strings['puestos_vicidial_list'][$puesto_usuario]) ? true : false;
        $id_llamada = isset($args['data']['id_llamada']) ? $args['data']['id_llamada'] : '';

        //Genera bean de llamada
        $bean_call = null;
        if($id_llamada !=''){
          $bean_call = BeanFactory::retrieveBean('Calls', $id_llamada, array('disable_row_level_security' => true));
        }else{
          $bean_call = BeanFactory::newBean('Calls');
          $bean_call->name ='Llamada a:' .$nombre_cliente ;
          $bean_call->parent_id = $id_cliente;
          $bean_call->parent_type = $modulo;
        }

        $bean_call->tct_call_issabel_c=1;
        $bean_call->tct_resultado_llamada_ddw_c = 'Llamada_servicio';
        if($posicion == 'Ventas') $bean_call->detalle_resultado_c = 17;
        if($posicion == 'Staff') $bean_call->detalle_resultado_c = 16;
        $bean_call->assigned_user_id = $current_user->id;
        $bean_call->save();

        if($modulo == 'Leads' && $id_llamada =='') {
          $bean_call->load_relationship('leads');
          $bean_call->leads->add($id_cliente);
        }
        $GLOBALS['log']->fatal('Llamada generada: '. $bean_call->id);

        //Valida vía de comunicación
        if($es_CP){
          //ViciDial
          $callURL = $sugar_config['viciDial_trigger_path'].'?exten=SIP/'.$ext_usuario.'&number='.$numero_cliente.'&leadid='.$bean_call->id;
        }else{
          //Issabel $sugar_config['site_url'].
          $callURL = 'https://192.168.11.254/call_unifin.php?numero='.$numero_cliente.'&userexten='.$ext_usuario.'&id_call='.$bean_call->id;
        }

        //Invoca ejecución de llamada
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $GLOBALS['log']->fatal('URL marcación: '. $callURL);
        $response = file_get_contents($callURL,false, stream_context_create($arrContextOptions));
        $GLOBALS['log']->fatal('Respuesta marcación: '. $response);

        //Regresa Id llamada
        return $bean_call->id;


        /*Variables a config
          $sugar_config['viciDial_trigger_path'] = 'https://192.168.10.22/wsagixps/act_rtepoc.php';
        */

    }
}
?>
