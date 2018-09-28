<?php
/**
 * User: AF
 * Date: 03/09/2018
 * Time: 18:30
 */

class CustomSurveyAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'GetResumen' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('customSurvey'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'customSurveyMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'customSurvey Endpoint',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my customSurvey endpoint
     */
    public function customSurveyMethod($api, $args)
    {

        $id_encuesta = $args[parametros][0];
        $preguntas = $args[parametros][1];
        $respuestas=$args[parametros][2];
        $resultado=$args[parametros][3];

        $GLOBALS['log']->fatal('>>>>>>>Entro CustomSurveyAPI');//-------------------------------------
        $GLOBALS['log']->fatal("Api ->Id de encuesta:".$id_encuesta."--------------");//----------------------
        $GLOBALS['log']->fatal("Api ->respuestas:".print_r($respuestas,true)."--------------");//----------------------

        $bean = BeanFactory::retrieveBean("TCT01_Encuestas", $id_encuesta, array('disable_row_level_security' => true));

        if($bean->description!=''){
            $bean->description .= $resultado;
        }else {
            $bean->description = $resultado;
        }

        $bean->tct_pregunta_1_txf=$preguntas[0];
        $bean->tct_pregunta_2_txf=$preguntas[1];
        $bean->tct_pregunta_3_txf=$preguntas[2];
        $bean->tct_pregunta_4_txf=$preguntas[3];
        $bean->tct_pregunta_5_txf=$preguntas[4];
        $bean->tct_pregunta_6_txf=$preguntas[5];
        $bean->tct_pregunta_7_txf=$preguntas[6];

        $bean->tct_respuesta_1_txf=$respuestas[0];
        $bean->tct_respuesta_2_txf=$respuestas[1];
        $bean->tct_respuesta_3_txf=$respuestas[2];
        $bean->tct_respuesta_4_txf=$respuestas[3];
        $bean->tct_respuesta_5_txf=$respuestas[4];
        $bean->tct_respuesta_6_txf=$respuestas[5];
        $bean->tct_respuesta_7_txf=$respuestas[6];


        $GLOBALS['log']->fatal("Api->Descripcion:".$bean->description."---------------");//----------------------

        $bean->save();

        $GLOBALS['log']->fatal("Ya se guardo---------------");//----------------------

        return true;

    }

}

?>
