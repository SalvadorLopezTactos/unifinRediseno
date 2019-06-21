<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement (""License"") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the ""Powered by SugarCRM"" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2012 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
require_once('modules/Teams/Team.php');

class DefaultTeam
{
    /**
     * This method creates the private team for a new user and makes it default.
     * Uncomment line 46, 47 to add this user to the global team.
     */
    public function new_user_created($user, $event, $arguments)
    {

        $GLOBALS['log']->fatal("Ejecuta LH iniciales: ");
        //Obtiene las iniciales de su nombre
        $nombres = split(" ", $user->first_name . ' ' . $user->last_name);
        $iniciales = '';
        foreach($nombres as $name){
            $iniciales = $iniciales . substr($name,0,1);
        }
        $user->iniciales_c = $iniciales;
        $user->nombre_completo_c = $user->first_name . ' ' . $user->last_name;

        // new user only
        if ($user->module_dir == 'Users' && empty($user->teams)) {
            global $current_language, $dictionary;
            $mod_strings = return_module_language($current_language, 'Users');
            $team = new Team();
            $team->field_defs = $dictionary[$team->object_name]['fields'];
            // uncomment the following two lines to add the user to the global team.
            //$team->retrieve($team->global_team);
            //$team->add_user_to_team($user->id);
            // create private team
            $team_id = $user->getPrivateTeamID();
            if (empty($team_id)) {
                Team::set_team_name_from_user($team, $user);
                $description = "{$mod_strings['LBL_PRIVATE_TEAM_FOR']} {$user->user_name}";
                $team_id = $team->create_team($user->first_name, $description, create_guid(), 1, $user->last_name, $user->id);
            }
            $team->retrieve($team_id);
            $team->add_user_to_team($user->id);
            $user->default_team = $team->id;
            $user->team_id = $team->id;
            // set $user->teams
            $user->load_relationship('teams');
            $user->teams->replace(array($team->id), array(), false);
            // tell TeamSetLink::save() not to add assigned_user's private team
            $GLOBALS['sugar_config']['disable_team_access_check'] = true;
            // tell User::save() not to do this again
            $user->team_exists = true;
        }
    }

    public function setBackOfficeTeam($bean = null, $event = null, $args = null){

        global $db;
        /*
        require_once('modules/Teams/Team.php');
        $team = new Team();
        $user_list_BO = array();
        $user_list_Team = array();
        */

        //Elimina a los integrantes actuales del team privado
        $query = <<<SQL
DELETE FROM team_memberships WHERE team_id = '{$bean->default_team}';
SQL;
         $db->query($query);

        // Obtiene la lista de los nuevos miembros del team
        //El usuario, los miembros de BO y el jefe del usuario
        $query = <<<SQL
INSERT INTO team_memberships (id, team_id, user_id, explicit_assign, implicit_assign, date_modified, deleted)
SELECT UUID(), '{$bean->default_team}', '{$bean->id}', 1, 0, NOW(), 0
UNION
SELECT distinct UUID(), '{$bean->default_team}', mem.user_id, mem.explicit_assign, mem.implicit_assign, NOW(), 0
FROM users_cstm usr
INNER JOIN PBO_Equipos_Promocion bo ON usr.equipo_c = bo.name
INNER JOIN team_memberships mem on mem.team_id = bo.teams_bo and mem.deleted = 0
WHERE id_c = '{$bean->id}'
UNION
select UUID(), '{$bean->default_team}', '{$bean->reports_to_id}', 0, 1, NOW(), 0
FROM users
where id = '{$bean->id}'
SQL;
    $db->query($query);

        /*
        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Integrantes del Team de BO " . print_r($queryResult,1));
        while ($row = $db->fetchByAssoc($queryResult)) {
            //Obtiene el team de BO
            $team = BeanFactory::getBean('Teams', $row['teams_bo']);
            $user_list_BO = $team->get_team_members(true);
            foreach ($user_list_BO as $user) {
                $user_list_Team[] = $user->id;
            }
        }
        //Agrega al usuario a la lista
        $user_list_Team[] = $bean->id;
        $GLOBALS['log']->fatal(__FILE__ . " - " . __CLASS__ . "->" . __FUNCTION__ . " Lista completa de Integrantes para el team del usuario: " . print_r($user_list_Team,1));
        */
    }

    public function gpoGlobal($bean = null, $event = null, $args = null)
    {
        global $db;
        $idUser = $bean->id;
        //$GLOBALS['log']->fatal('Genera Usuario e impide salir del grupo Global');

        if ($idUser!= null || $idUser!= ''){
            $GLOBALS['log']->fatal('Entra a condición para salir de gpo global');
            $query="UPDATE team_memberships SET implicit_assign=1
            WHERE user_id='{$idUser}' and team_id='1'";
            $results = $GLOBALS['db']->query($query);
        }
        //$GLOBALS['log']->fatal('Finaliza salir del gpo global');
    }

    /*
      AF.2019-06-20
      Funcionalidad para validar y establecer agrupador(team_sets) con equipo privado y equipo principal unics del usuario
    */
    public function create_team_sets($bean = null, $event = null, $args = null)
    {
        //$GLOBALS['log']->fatal('TCT - Inicio LH creación de team_set');
        //Define variables
        global $db;
        $idUser = $bean->id;
        $idDefaultTeam = $bean->default_team;
        $result = 0;

        //Valida: Si el valor para default team es diferente de 1 y vacío, ejecuta validaciones
        //$GLOBALS['log']->fatal('TCT - Valor default team: '.$idDefaultTeam );
        if(!empty($idDefaultTeam) && $idDefaultTeam!= 1 ){
            //Establece id para team_set_id
            $idTeamSets = substr($idDefaultTeam,0,33) . 'af0'; //Concatena primeros 33 caracteres del default_id + af0(valor constante para identificar teams_sets creados manualmente)
            // Consulta existencia de team_set
            $query="select id from team_sets where id='".$idTeamSets."';";
            $queryResult = $GLOBALS['db']->query($query);
            while ($row = $db->fetchByAssoc($queryResult)) {
                //Obtiene el team de BO
                $result ++;
            }


            //Validación: Comprueba que no existan registros para crear nuevo agrupador
            // $GLOBALS['log']->fatal('TCT - Valor consulta existene: ');
            // $GLOBALS['log']->fatal($query);
            // $GLOBALS['log']->fatal(print_r($result,true));
            if($result==0){
                //No existe: Genera nuevo registro agrupador
                // Inserta team_sets_teams n1
                $insert_team_1 = "insert IGNORE into team_sets_teams(id, team_set_id, team_id, date_modified,deleted)
                  select
                  	UUID() as id,
                      concat(left(u.team_set_id, 33),'af0')  as team_set_id,
                      replace(case
                  		when uc.equipo_c = '1' then 'UNO'
                          when uc.equipo_c = '0' then 'CERO'
                  		else uc.equipo_c end,' ', '') as team_id,
                      NOW() as date_modified,
                      0 as deleted
                  from
                  	users u, users_cstm uc
                  where
                  	u.id = uc.id_c
                    and u.status = 'Active'
                    and u.id='".$idUser."'
                ;";
                //Inserta team_sets_teams n2
                $insert_team_2 = "insert IGNORE into team_sets_teams(id, team_set_id, team_id, date_modified,deleted)
                  select
                  	UUID() as id,
                      concat(left(u.team_set_id, 33),'af0')  as team_set_id,
                      u.team_set_id as team_id,
                      NOW() as date_modified,
                      0 as deleted
                  from
                  	users u, users_cstm uc
                  where
                  	u.id = uc.id_c
                    and u.status = 'Active'
                    and u.id='".$idUser."'
                ;";

                //Insert team_sets
                $insert_team_sets = "insert IGNORE into team_sets(id, name, team_md5, team_count,date_modified,deleted,created_by)
                  select
                  	concat(left(u.team_set_id, 33),'af0')  as id,
                      md5(concat(left(u.team_set_id, 33),'af0')) as name,
                      md5(concat(left(u.team_set_id, 33),'af0')) as team_md5,
                      2 as team_count,
                      NOW() as date_modified,
                      0 as deleted,
                      1 as created_by
                  from
                  	users u
                  where
                      u.status = 'Active'
                      and u.id='".$idUser."'
                ;";

                //Ejecuta inserts
                // $GLOBALS['log']->fatal('TCT - Valor insert1: '.$insert_team_1 );
                // $GLOBALS['log']->fatal('TCT - Valor insert2: '.$insert_team_2 );
                // $GLOBALS['log']->fatal('TCT - Valor insert3: '.$insert_team_sets );
                $results = $GLOBALS['db']->query($insert_team_1);
                $results = $GLOBALS['db']->query($insert_team_2);
                $results = $GLOBALS['db']->query($insert_team_sets);

             }
        }
        //$GLOBALS['log']->fatal('TCT - Fin LH creación de team_set');
    }

}
