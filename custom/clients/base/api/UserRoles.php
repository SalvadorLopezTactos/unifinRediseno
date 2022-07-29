<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/22/2016
 * Time: 12:01 PM
 */

class UserRoles extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GET_UserRoles' => array(
                'reqType' => 'GET',
                'path' => array('UserRoles'),
                'pathVars' => array(''),
                'method' => 'getUserRole',
                'shortHelp' => 'Obtiene los roles de un usuario',
            ),
        );
    }

    public function getUserRole($api, $args){

        global $current_user;

         global $db;
         $query = <<<SQL
SELECT r.name FROM acl_roles r
INNER JOIN acl_roles_users ru ON ru.role_id = r.id AND ru.deleted = 0
WHERE ru.user_id = '{$current_user->id}'
SQL;

         $queryResult = $db->query($query);
         while($row = $db->fetchByAssoc($queryResult))
         {
            $response[] = $row['name'];
         }

         return $response;
    }
}