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
}
