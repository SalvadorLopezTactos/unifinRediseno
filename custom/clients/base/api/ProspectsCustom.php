<?php
/**
 * User: AF
 * Date: 31/09/2023
 * Time: 18:30
 */

class ProspectsCustom extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'POSTProspectsCustom' => array(
                //request type
                'reqType' => 'POST',
                //endpoint path
                'path' => array('ProspectsCustom'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'customProspectInsert',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'custom endpoint para extender valdiación sobre servicio nativo Prospects',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my customSurvey endpoint
     */
    public function customProspectInsert($api, $args)
    {
        $GLOBALS['log']->fatal('Prospects Custom Endpoint');
        //Genera nuevo bean para Prospects
        $beanProspect = BeanFactory::newBean("Prospects");
        //Generar objeto para respuesta
        $beanResult = [];
        
        //Iterar $args obtenidos y setea bean
        foreach ($args as $clave => $valor) {
            $beanProspect->$clave = $valor;
        }
        //Guarda bean y devuelve estructura
        $beanProspect->save();
        
        //Setar objeto de resultado con valores guardados
        foreach ($beanProspect->column_fields as $elemento) {
            $beanResult[$elemento] = $beanProspect->$elemento;
        }
        
        //$GLOBALS['log']->fatal(print_r($beanProspect,true));
        //$GLOBALS['log']->fatal($beanResult);

        //Regresa estructura de bean
        return $beanResult;

    }

}

?>
