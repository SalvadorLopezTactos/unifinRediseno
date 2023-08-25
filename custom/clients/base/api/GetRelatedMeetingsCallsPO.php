<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetRelatedMeetingsCallsPO extends SugarApi
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
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetRelatedMeetingsCallsPO','?'),
                'pathVars' => array('metodo','id_po'),
                //method to call
                'method' => 'getRelatedViable',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que verifica si alguna reunión o llamada contiene el resultado: Viable, Envío a Solicitud',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );
    }

    public function getRelatedViable($api, $args){
        $id_prospect = $args['id_po'];

        $beanPO = BeanFactory::retrieveBean('Prospects', $id_prospect, array('disable_row_level_security' => true));

        $arr_muestra_boton = array();
        $muestra_boton = false;
        if ($beanPO->load_relationship('calls')) {
            $relatedCalls = $beanPO->calls->getBeans();

            if (!empty($relatedCalls)) {
                
                foreach ($relatedCalls as $call) {

                    if( $call->tct_resultado_llamada_ddw_c == 'Viable_Envio_Solicitud' ){
                        array_push($arr_muestra_boton,'1');
                    }else{
                        array_push($arr_muestra_boton,'0');
                    }

                }
            }
        }

        /**ToDo: Recuperar resultado Viable Envío a Solicitud una vez que se define en el campo que se muestra */
        /*
        if ($beanPO->load_relationship('meetings')) {
            $relatedMeetings = $beanPO->calls->getBeans();

            if (!empty($relatedMeetings)) {
                
                foreach ($relatedMeetings as $meeting) {

                    if( $call->tct_resultado_llamada_ddw_c == 'Ilocalizable' ){
                        $numero_ilocalizable += 1;
                        $GLOBALS['log']->fatal("ILOCALIZABLE NUMERO". $numero_ilocalizable);
                    }

                }
            }
        }
        */
        $GLOBALS['log']->fatal(print_r($arr_muestra_boton,true));
        if( in_array('1',$arr_muestra_boton) ){
            $muestra_boton = true;
        }

        return $muestra_boton;
    }
        
}
