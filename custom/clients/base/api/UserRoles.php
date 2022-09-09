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

            'GET_UserRolesReports' => array(
                'reqType' => 'GET',
                'path' => array('UserRolesReportsToId', '?'),
                'pathVars' => array('nameUrl','id_usuario'),
                'method' => 'getUserRolesAndReports',
                'shortHelp' => 'Obtiene los roles de un usuario y el usuario al que reporta',
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

    public function getUserRolesAndReports($api, $args){

        global $db;
        $id_usuario=$args['id_usuario'];
        $response=array("roles"=>array(),"reports_to_id"=>"");
        
        $query = <<<SQL
SELECT r.name,u.reports_to_id FROM acl_roles r
INNER JOIN acl_roles_users ru
ON r.id=ru.role_id
INNER JOIN users u
ON ru.user_id=u.id
WHERE ru.user_id='{$id_usuario}'
AND ru.deleted=0
SQL;

         $queryResult = $db->query($query);
         $roles_array=array();
         $reporta="";
         while($row = $db->fetchByAssoc($queryResult))
         {
            array_push($response["roles"],$row['name']);
            $reporta=$row['reports_to_id'];
         }
         $response["reports_to_id"]=$reporta;

         return $response;
    }
}