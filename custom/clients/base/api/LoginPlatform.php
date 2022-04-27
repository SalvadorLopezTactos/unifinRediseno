<?php
/**
 * Created by PhpStorm.
 * User: AF
 * Date: 2018/11/08
 */

class LoginPlatform extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'LoginPlatformAPI' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('LoginPlatform', '?'),
                //endpoint variables
                'pathVars' => array('module', 'platform'),
                //method to call
                'method' => 'LoginPlatformMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Set logged platform',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function LoginPlatformMethod($api, $args)
    {
        try {
            //Retrieve parameters
            global $current_user;
            $userId = $current_user->id;
            $platform = $args['platform'];
            $idRecord = '';
            //Convierte valor de plataforma
            if ($platform != "iPad") {
              $platform = "Pc";
            }
            //Validate parameters
            if ($platform != '' && $userId != ''){
              //Execute query
              $query = "select id
                        from tct_usersplatform
                        where
                          tct_user_id_txf ='". $userId ."'
                          and tct_platform_txf = 'base'
                        order by date_entered desc
                        limit 1
              ;";
              $resultQ = $GLOBALS['db']->query($query);
              while ($row = $GLOBALS['db']->fetchByAssoc($resultQ)) {
                $idRecord = $row['id'];
              }
              //Validate record to update
              if ($idRecord != '') {
                //Execute upate to tct_usersplatform
                $update = "update tct_usersplatform t1
                          set
                          	t1.name = '". $platform ."'
                          where
                          	id = '". $idRecord ."'
                ;";
                $resultUpdate = $GLOBALS['db']->query($update);
              }
            }
        }
        //catch exception
        catch(Exception $e) {

        }
        //Return response
        return true;
    }
}

?>
