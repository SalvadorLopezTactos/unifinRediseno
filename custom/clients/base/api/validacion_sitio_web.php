<?php
/**
 * Created by PhpStorm.
 * User: ERick de Jesús Cruz
 * Date: 2020/04/03
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class validacion_sitio_web extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('validacion_sitio_web'),
                //endpoint variables
                'pathVars' => array(),
                //method to call
                'method' => 'ping_web',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'None',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }
//http://localhost/unifinRediseno/rest/v11_4/validacion_sitio_web
    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function ping_web($api, $args)
    {
		$website = $args['website'];
		$validateweb = '1';
		$os = PHP_OS;
		//PING 1.1.1.1
		//
		$website = str_replace ('http://','',$website);
		$website = str_replace ('https://','',$website);
		
		if (strpos($os , "WIN") != false){
			$website = $website.'/';
		}
		
		//$GLOBALS['log']->fatal('website',$website);
		//if(filter_var(gethostbyname($website), FILTER_VALIDATE_IP))
		$output = shell_exec("ping -w 7500 $website");
		//$GLOBALS['log']->fatal('output',$output);
		if (strpos($output, "ping no pudo encontrar el host")){
			$validateweb = '02';
		}else if(strpos($output, "recibidos = 0")){
			$validateweb = '01';
		} else {
			$validateweb = '00';
		}
		
        return $validateweb;
    }

}
