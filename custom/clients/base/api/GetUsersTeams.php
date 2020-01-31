<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 29/08/2018
 * Time: 12:03 PM
 */

require_once('modules/ACLRoles/ACLRole.php');
require_once("modules/Users/User.php");

class GetUsersTeams extends SugarApi
{

    /**
     * Registro de todas las rutas para consumir los servicios del API
     *
     */
    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('GetUsersTeams', '?', '?'),
                //endpoint variables
                'pathVars' => array('module', 'id_cuenta', 'modulo'),
                //method to call
                'method' => 'ValidateUsersTeam',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para validar que el usuario Firmado pertenezca sea el propietario del registro o pertenezca al equipo de alguno',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    /**
     * Obtiene los Equipos y usuarios relacionados con la Cuenta
     *
     * Método que obtiene los Equipos y Usuarios relacionados con una Cuenta y compara
     * con el usuario firmado para otorgar permisos sobre el registro
     *
     * @param array $api
     * @param array $args Array con los parámetros enviados para su procesamiento
     * @return bander true o false
     * @throws SugarApiExceptionInvalidParameter
     */
    public function ValidateUsersTeam($api, $args)
    {

        $flag = false;
        $idCuenta = $args['id_cuenta'];
        $Modulo = $args['modulo'];
        $beanModule = BeanFactory::getBean($Modulo, $idCuenta);
        global $current_user;

        $usuarioLog = $current_user->id;
        $flag = false;
        $arrayTeamUsrs = array();

        // Si es en el modulo de Cuentas
        if ($Modulo == 'Accounts') {
            $usrLeasing = $beanModule->user_id_c;
            $usrFactoraje = $beanModule->user_id1_c;
            $usrCredito = $beanModule->user_id2_c;
            $usrFleet = $beanModule->user_id6_c;
            $usrUniclick = $beanModule->user_id7_c;

            array_push($arrayTeamUsrs,$usrLeasing,$usrFactoraje,$usrCredito,$usrFleet);

        } else {
            // Si no es cuentas se obtiene el asignado a
            $usrAsignadoA = $beanModule->assigned_user_id;
            array_push($arrayTeamUsrs, $usrAsignadoA);
        }

        if ($usuarioLog == $usrLeasing || $usuarioLog == $usrFactoraje || $usuarioLog == $usrCredito || $usuarioLog == $usrFleet || $usuarioLog == $usrAsignadoA || $usuarioLog==$usrUniclick) {
            $flag = true;
        }

        $arrayTeamUsrLogin = array();
        /*
         * Generamos una Lista con los Equipos asociados al Usuario Firmado
         * excluyendo el equipo global
         * **/
        $user_id = $current_user->id;
        $objTeams = new Team();
        $teams = $objTeams->get_teams_for_user($user_id);

        foreach ($teams as $val) {
            if ($val->id != '1') {
                array_push($arrayTeamUsrLogin, $val->id);
            }
        }

        /*
         * Generamos una Lista con los Equipos asociados a los Usuario de la Cuenta
         * excluyendo el equipo global y repetidos
         * **/
        $arrayTeamUsrAll = array();

        foreach ($arrayTeamUsrs as $usuarios) {
            $objTeamsUsr = new Team();
            $teamsUsr = $objTeams->get_teams_for_user($usuarios);

            foreach ($teamsUsr as $equipoUsrs) {
                if ($equipoUsrs->id != '1') {

                    array_push($arrayTeamUsrAll, $equipoUsrs->id);
                }
            }
        }

        /*
         * Comparamos si existe el o los usuarios en los equipos
         * **/
        foreach ($arrayTeamUsrLogin as $team_usr) {

            if (in_array($team_usr, $arrayTeamUsrAll)) {
                //$GLOBALS['log']->fatal("Existe " . $team_usr );
                $flag=true;
            }
        }

        //Valida usuario Admin
        if ($current_user->is_admin == true) {
          $flag = true;
        }
        
        return $flag;

    }
}
