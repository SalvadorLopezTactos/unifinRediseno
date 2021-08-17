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
     * Method to be used for my customSurvey endpoint
     */
    public function createcall($api, $args)
    {
        $GLOBALS['log']->fatal('>>>>>>>Entro llamadasAPI');//------------------------------------
        $id_cliente=$args['data'][0];
        $nombre_cliente=$args['data'][1];
        $modulo=$args['data'][2];
		$posicion=$args['data'][3];
        $GLOBALS['log']->fatal('id cliente: '.$id_cliente);//------------------------------------
        $GLOBALS['log']->fatal('nombre del cliente: '.$nombre_cliente);//------------------------------------  
        $GLOBALS['log']->fatal('modulo: '.$modulo);//------------------------------------
        $bean_call = BeanFactory::newBean('Calls');
        $GLOBALS['log']->fatal('Bean creado');//----------------------
        $bean_call->name ='Llamada a:' .$nombre_cliente ;
        $GLOBALS['log']->fatal('Nombre asignado');//----------------------
        $bean_call->parent_id = $id_cliente;
        $bean_call->parent_type = $modulo;
        $GLOBALS['log']->fatal('Id de cliente asignado');//----------------------
        $bean_call->tct_call_issabel_c=1;
		$bean_call->tct_resultado_llamada_ddw_c = 'Llamada_servicio';
		if($posicion == 'Ventas') $bean_call->detalle_resultado_c = 17;
		if($posicion == 'Staff') $bean_call->detalle_resultado_c = 16;
        global $current_user;
        $bean_call->assigned_user_id = $current_user->id;
        $bean_call->save();
        if($modulo == 'Leads') {
          $bean_call->load_relationship('leads');
          $bean_call->leads->add($id_cliente);
        }
        $GLOBALS['log']->fatal('Bean de llamadas guardado');//----------------------
        return $bean_call->id;
    }
}
?>
