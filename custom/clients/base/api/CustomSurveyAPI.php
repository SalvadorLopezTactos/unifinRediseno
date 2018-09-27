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

        $id_reunion = $args[parametros][0];
        $preguntas = $args[parametros][1];
        $respuestas=$args[parametros][2];
        $resultado=$args[parametros][3];

        $GLOBALS['log']->fatal("Api ->Id de reunion:".$id_reunion."--------------");//----------------------

        $bean = BeanFactory::getBean("Meetings", $id_reunion);
        if($bean->description!=''){
            $bean->description .= $resultado;
        }else {
            $bean->description = $resultado;
        }

        $GLOBALS['log']->fatal("Api->Descripcion:".$bean->description."---------------");//----------------------

        $bean->save();

        $GLOBALS['log']->fatal("Ya se guardo---------------");//----------------------

        return true;

        $GLOBALS['log']->fatal("Legaste al final---------------");//----------------------
    }

}

?>
