<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/19/2015
 * Time: 8:03 PM
 */
//ECB
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("custom/Levementum/UnifinAPI.php");
class AccountsCustomAPI extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            //GET
            'getcustomAPIJG' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('Accounts', 'AccountsCustomAPI', '?'),
                //endpoint variables
                'pathVars' => array('', '', 'ID'),
                //method to call
                'method' => 'ContratosActivos',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Pregunta a servicios de Unifin, si el cliente ya tiene contratos existentes',
            ),

            'getPromotoresCliente' => array(
                'reqType' => 'GET',
                'path' => array('Accounts','getPromotores','?'),
                'pathVars' => array('', '', 'id'),
                'method' => 'GetPromotoresCliente',
                'shortHelp' => 'Obtiene promotores del cliente.',
            ),
        );
    }

    public function ContratosActivos($api, $args)
    {
        $id = $args['ID'];
        $callApi = new UnifinAPI();
        $contratosActivos = $callApi->ClienteconContratosActivos($id);
        return $contratosActivos;
    }

    public function GetPromotoresCliente ($api, $args){
        global $db, $current_user;
        $idCliente = $args['id'];
        try
        {
            $query = <<<SQL
select acc.id_c id_cliente, ac.name, IFNULL(l.user_name,'') id_leasing, IFNULL(l_cs.nombre_completo_c,'') leasing, IFNULL(l_cs.equipo_c,'') eq_Leasing, IFNULL(l_mail.email_address,'') mail_leasing,
IFNULL(f.user_name,'') id_factoraje, IFNULL(f_cs.nombre_completo_c,'') factoraje, IFNULL(f_cs.equipo_c,'') eq_factoraje, IFNULL(f_mail.email_address,'') mail_factoraje,
IFNULL(c.user_name,'') id_credit, IFNULL(c_cs.nombre_completo_c,'') credit, IFNULL(c_cs.equipo_c,'') eq_credit, IFNULL(c_mail.email_address,'') mail_credit,
IFNULL(uck.user_name,'') id_uniclick, IFNULL(uck_cs.nombre_completo_c,'') uniclick, IFNULL(uck_cs.equipo_c,'') eq_uniclick, IFNULL(uck_mail.email_address,'') mail_uniclick,
IFNULL(l_cs.tct_team_address_txf_c,'') Dir_Equipo_Principal
FROM accounts ac
INNER JOIN accounts_cstm acc ON ac.id = acc.id_c

LEFT OUTER JOIN users l ON acc.user_id_c = l.id
LEFT OUTER JOIN users_cstm l_cs ON acc.user_id_c = l_cs.id_c AND l.id = l_cs.id_c
LEFT OUTER JOIN email_addr_bean_rel l_rel_mail ON l_rel_mail.bean_id = l.id
LEFT OUTER JOIN email_addresses l_mail ON l_rel_mail.email_address_id = l_mail.id AND l_rel_mail.bean_module = 'Users'
LEFT OUTER JOIN users f ON acc.user_id1_c = f.id
LEFT OUTER JOIN users_cstm f_cs ON acc.user_id1_c = f_cs.id_c AND f.id = f_cs.id_c
LEFT OUTER JOIN email_addr_bean_rel f_rel_mail ON f_rel_mail.bean_id = f.id
LEFT OUTER JOIN email_addresses f_mail ON f_rel_mail.email_address_id = f_mail.id AND f_rel_mail.bean_module = 'Users'
LEFT OUTER JOIN users c ON acc.user_id2_c = c.id
LEFT OUTER JOIN users_cstm c_cs ON acc.user_id2_c = c_cs.id_c AND c.id = c_cs.id_c
LEFT OUTER JOIN email_addr_bean_rel c_rel_mail ON c_rel_mail.bean_id = c.id
LEFT OUTER JOIN email_addresses c_mail ON c_rel_mail.email_address_id = c_mail.id AND c_rel_mail.bean_module = 'Users'
LEFT OUTER JOIN users uck ON acc.user_id7_c = uck.id
LEFT OUTER JOIN users_cstm uck_cs ON acc.user_id7_c = uck_cs.id_c AND uck.id = uck_cs.id_c
LEFT OUTER JOIN email_addr_bean_rel uck_rel_mail ON uck_rel_mail.bean_id = uck.id
LEFT OUTER JOIN email_addresses uck_mail ON uck_rel_mail.email_address_id = uck_mail.id AND uck_rel_mail.bean_module = 'Users'
                WHERE acc.id_c = '{$idCliente}'
SQL;

            $rows = $db->query($query);

            if (mysqli_num_rows($rows) == 0){
                $Promotores = null;
            }else {
                while ($Ejecutivos = $db->fetchByAssoc($rows)) {
                    $Promotores = array(
                        "GUID_cliente" => $Ejecutivos['id_cliente'],
                        "cliente" => $Ejecutivos['name'],
                        "user_leasing" => $Ejecutivos['id_leasing'],
                        "promotor_leasing" => $Ejecutivos['leasing'],
                        "equipo_leasing" => $Ejecutivos['eq_Leasing'],
                        "mail_leasing" => $Ejecutivos['mail_leasing'],
                        "user_factoring" => $Ejecutivos['id_factoraje'],
                        "promotor_factoring" => $Ejecutivos['factoraje'],
                        "equipo_factoring" => $Ejecutivos['eq_factoraje'],
                        "mail_factoring" => $Ejecutivos['mail_factoraje'],
                        "user_credit" => $Ejecutivos['id_credit'],
                        "promotor_credit" => $Ejecutivos['credit'],
                        "equipo_credit" => $Ejecutivos['eq_credit'],
                        "mail_credit" => $Ejecutivos['mail_credit'],
                        "user_uniclick" => $Ejecutivos['id_uniclick'],
                        "promotor_uniclick" => $Ejecutivos['uniclick'],
                        "equipo_uniclick" => $Ejecutivos['eq_uniclick'],
                        "mail_uniclick" => $Ejecutivos['mail_uniclick'],

						"Dir_Equipo_Principal" => $Ejecutivos['Dir_Equipo_Principal']
                    );
                }
            }
            return $Promotores;

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }
}