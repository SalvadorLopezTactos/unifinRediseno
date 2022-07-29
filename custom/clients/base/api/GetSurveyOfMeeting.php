<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetSurveyOfMeeting extends SugarApi
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
                'path' => array('GetSurveyOfMeeting', '?'),

                //endpoint variables
                'pathVars' => array('method', 'id_meeting'),

                //method to call
                'method' => 'getStatusOfSurvey',

                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método que obtiene el estatus de una encuesta relacionada a una reunión',

                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getStatusOfSurvey($api, $args)
    {
        $id_meeting=$args['id_meeting'];

        $usuarios_inactivos=array();

        $query="SELECT status FROM bc_survey_submission where parent_type='Meetings' and parent_id='{$id_meeting}'";

        $result=$GLOBALS['db']->query($query);
        $encuesta=false;
        $num_rows = $result->num_rows;
        if($num_rows >0){

            while($row = $GLOBALS['db']->fetchByAssoc($result))
            {
                if($row['status']=='Submitted'){

                    $encuesta=true;

                }

            }

        }
        return $encuesta;
    }

}

?>