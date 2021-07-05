<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetUsuariosEquipo extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETUsuariosEquipoAPI' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('GetUsuariosEquipo', '?'),
                'pathVars' => array('module', 'equipo'),
                'method' => 'getUsersByTeam',
                'shortHelp' => 'Obtiene los Usuarios apartir de un equipo ',
            ),
        );
    }
    public function getUsersByTeam($api, $args)
    {
        try {

            $equipo = $args['equipo'];
            $records_in = [];

            $query = "SELECT usuarios.name, usuarios.id ,usuarios.nombre , correos.email_address, usuarios.tipodeproducto_c from (
                select teams.name , concat (users.first_name, ' ' ,users.last_name) nombre, 
                uc.tipodeproducto_c , users.status , users.id from teams 
                JOIN team_memberships tm ON tm.team_id = teams.id
                INNER JOIN users ON tm.user_id = users.id
                INNER JOIN users_cstm uc ON users.id = uc.id_c
                where teams.name = '{$equipo}' and tm.explicit_assign = 1
                and users.is_admin = 0 and users.status = 'Active'
            ) as usuarios inner join 
            (	SELECT users.id , users.user_name, email_address FROM users
                LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id=users.id
                    AND email_addr_bean_rel.bean_module = 'Users'
                    AND email_addr_bean_rel.primary_address = 1
                    AND email_addr_bean_rel.deleted = 0
                LEFT JOIN email_addresses ON email_addresses.id = email_addr_bean_rel.email_address_id
                    AND email_addresses.deleted = 0
            ) as correos on usuarios.id = correos.id ";

            $result = $GLOBALS['db']->query($query);
            while ($row = $GLOBALS['db']->fetchByAssoc($result)) {
                $records_in['records'][] = array('equipo' => $row['name'], 'id' => $row['id'], 
                'nombre' => $row['nombre'], 'correo' => $row['email_address']);
            }

            return $records_in;

        } catch (Exception $e) {

            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
        }
    }
}
