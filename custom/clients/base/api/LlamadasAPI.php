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

        $id_cliente=$args[data][0];
        $nombre_cliente=$args[data][1];

        $GLOBALS['log']->fatal('id cliente: '.$id_cliente);//------------------------------------
        $GLOBALS['log']->fatal('nombre del cliente: '.$nombre_cliente);//------------------------------------

        $bean_call = BeanFactory::newBean('Calls');
        $GLOBALS['log']->fatal('Bean creado');//----------------------
        
        $bean_call->name ='Llamada a:' .$nombre_cliente ;
        $GLOBALS['log']->fatal('Nombre asignado');//----------------------

        $bean_call->parent_id = $id_cliente;
        $bean_call->parent_type = 'Accounts';
        $GLOBALS['log']->fatal('Id de cliente asignado');//----------------------

        $bean_call->save();

        $GLOBALS['log']->fatal('Bean de llamadas guardado');//----------------------

        return true;

    }

}

?>
