<?php
/*/**
 * Created by EJC.
 * User: tactos
 * Date: 05/04/2022
 * Time: 12:25 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class existeClienteEmail extends SugarApi
{
    public $obj_clientes;

    public function registerApiRest()
    {
        return array(
            'GET_existeClienteEmail' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('existeClienteEmail','?'),
                'pathVars' => array('module','contactId'),
                'method' => 'validaCliente',
                'shortHelp' => 'Busqueda de clientes en LEad, Cuentas, Publico Objetivo por email',
            ),
        );
    }

    public function validaCliente($api, $args)
    {
        $response_Services = [];
        
        $email = $args['contactId'];
        
        $registros = $this->exists($email);

        $response_Services['records'] = $registros;
        $GLOBALS['log']->fatal('response_Services',$response_Services);
        return $response_Services;
        //return true;
    }

    public function exists($email)
    {
        $existe = "";
        $array_registros = [];
        
        $sql = "SELECT bean_module, bean_id ,email_addresses.email_address as email  FROM email_addr_bean_rel eabr JOIN email_addresses ON eabr.email_address_id = email_addresses.id WHERE email_addresses.email_address = '{$email}' AND bean_module in ('Leads','Accounts','Prospects') AND eabr.deleted = 0";
        //$GLOBALS['log']->fatal($sql);
        $result = $GLOBALS['db']->query($sql);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $aux=null;
            $bean = BeanFactory::getBean($row['bean_module'], $row['bean_id'] , array('disable_row_level_security' => true));
            $aux->id = $bean->id;
            $aux->_module = $row['bean_module'];
            $aux->name = ($row['bean_module'] == "Accounts" ) ? $bean->name : ($bean->first_name." ".$bean->last_name) ;
            
            if ($row['bean_module']=='Accounts'){ $aux->full_name = $bean->clean_name; }
            if ($row['bean_module']=='Leads'){ $aux->full_name = $bean->clean_name_c; }
            if ($row['bean_module']=='Prospects'){ $aux->full_name = ($bean->first_name." ".$bean->last_name); }
            $aux->email = $row['email'];
            if ($row['bean_module']=='Leads' && empty($bean->account_id)){
                array_push($array_registros,$aux);
            }else if($row['bean_module']=='Accounts' || $row['bean_module']=='Prospects'){
                array_push($array_registros,$aux);
            }
        }
        $GLOBALS['log']->fatal('array_registros',$array_registros);
        return $array_registros;
    }

    public function crea_clean_name($data)
    {
        $nombre = $data;
        $clean_name = "";

        //Consumir servicio de cleanName, declarado en custom api
        require_once("custom/clients/base/api/cleanName.php");
        $apiCleanName = new cleanName();
        $body = array('name' => $nombre);
        $response = $apiCleanName->getCleanName(null, $body);
        if ($response['status'] == '200') {
            $clean_name = $response['cleanName'];
        }

        return $clean_name;
    }

    public function estatus($codigo, $descripcion, $id, $modulo, $errores)
    {
        $array_status = array();
        $array_status['status'] = $codigo;
        $array_status['descripcion'] = $descripcion;
        $array_status['id'] = $id;
        $array_status['modulo'] = $modulo;
        $array_status['errores'] = $errores;


        return $array_status;
    }
    
}
