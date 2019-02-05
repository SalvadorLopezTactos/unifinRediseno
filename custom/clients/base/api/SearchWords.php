<?php
/**
 * User: JC
 * Date: 30/01/2019
 * Time: 10:30
 */

class SearchWords extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'searchaccount' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('searchaccount'),
                //endpoint variables
                'pathVars' => array('endpoint'),
                //method to call
                'method' => 'searchaccount',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Api que busca los nombres de cuentas que coincidan con la palabra que recibe ',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my customSurvey endpoint
     */
    public function searchaccount($api, $args)
    {
        //$GLOBALS['log']->fatal('------------------------');
        //$GLOBALS['log']->fatal('>>>>>>>Entro a Api searchaccount');//------------------------------------

        $word = $args['q'];
        $arr['records']=[];

        $query = "select id,name as 'text' from accounts where name like '%".$word."%' and deleted=0;";
        $result = $GLOBALS['db']->query($query);

        while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
         array_push($arr['records'],$row);
        }

        return $arr;

    }

}

?>
