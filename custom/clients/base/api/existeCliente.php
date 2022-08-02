<?php
/*/**
 * Created by EJC.
 * User: tactos
 * Date: 05/04/2022
 * Time: 12:25 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class existeCliente extends SugarApi
{
    public $obj_clientes;

    public function registerApiRest()
    {
        return array(
            'GET_existeCliente' => array(
                'reqType' => 'GET',
                'noLoginRequired' => true,
                'path' => array('existeCliente','?'),
                'pathVars' => array('module','contactId'),
                'method' => 'validaCliente',
                'shortHelp' => 'Busqueda de clientes en LEad, Cuentas, Publico Objetivo',
            ),
        );
    }

    public function validaCliente($api, $args)
    {
        $response_Services = [];
        $response = [];
        
        $tel = $args['contactId'];
        $codtel = "";
        if(strlen($tel) > 10 && strlen($tel) == 13){
            $codtel = substr($tel,0,3);
            $codtel = substr($codtel,1);
        }

        if($codtel == "52"){
            $tel = substr($tel,-10);
        }
        $tel = trim($tel);
        $GLOBALS['log']->fatal('tel',$tel);
        $lead = $this->existsIn_Leads($tel);
        //$GLOBALS['log']->fatal('LEAD',$lead);
        $response = count($lead) > 0 ? array_merge($response, $lead) : $response;
        
        $cuenta = $this->existsIn_Accounts($tel);
        //$GLOBALS['log']->fatal('cuenta',$cuenta);
        $response = count($cuenta) > 0 ? array_merge($response, $cuenta) : $response;
        
        $po = $this->existsIn_PO($tel);
        //$GLOBALS['log']->fatal('po',$po);
        $response =  count($po) > 0 ? array_merge($response, $po) : $response;
        
        $response_Services['records'] = $response;
        $GLOBALS['log']->fatal('response_Services',$response_Services);
        return $response_Services;
        //return true;
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

    public function existsIn_Leads($tel)
    {
        $existe = "";
        $array_telefonos = [];
        
        /*$sqlLead = new SugarQuery();
        $sqlLead->select(array('id', 'first_name','last_name','clean_name_c','phone_mobile', 'phone_home', 'phone_work'));
        $sqlLead->from(BeanFactory::getBean('Leads'), array('team_security' => false));
        $sqlLead->where()->queryOr()->equals('phone_mobile', $tel)
            ->equals('phone_home', $tel)->equals('phone_work', $tel);
        $resultLead = $sqlLead->execute();
        $GLOBALS['log']->fatal('qresultLead',$resultLead);
        */

        $sql = "SELECT leads.id, leads.last_name AS name, leads_cstm.clean_name_c as full_name, leads.phone_mobile, leads.phone_home, leads.phone_work , 'Leads' as _module FROM leads LEFT JOIN leads_cstm leads_cstm ON leads_cstm.id_c = leads.id WHERE ((leads.phone_mobile = '{$tel}') OR (leads.phone_home = '{$tel}') OR (leads.phone_work = '{$tel}')) AND account_id IS NULL AND (leads.deleted = 0)";
        $GLOBALS['log']->fatal($sql);
        $result = $GLOBALS['db']->query($sql);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            //$aux[]=$row;
            array_push($array_telefonos,$row);
        }
        //$GLOBALS['log']->fatal('array_telefonos',$array_telefonos);
        return $array_telefonos;
    }

    public function existsIn_Accounts($data)
    {
        $array_telefonos = [];

        /*$sqlLead = new SugarQuery();
        $sqlLead->select(array('A.id' , 'C.telefono' , 'A.name', 'A.clean_name'));
        $sqlLead->from(BeanFactory::getBean('Accounts'), array('team_security' => false, 'alias' => 'A'));
        $sqlLead->joinTable('accounts_tel_telefonos_1_c', array('alias' => 'B', 'joinType' => "INNER",))->on()->equalsField('B.accounts_tel_telefonos_1accounts_ida', 'A.id');
        $sqlLead->joinTable('tel_telefonos', array('alias' => 'C', 'joinType' => "INNER",))->on()->equalsField('C.id', 'B.accounts_tel_telefonos_1tel_telefonos_idb');
        $sqlLead->where()->equals('C.telefono', $data);
        //$sqlLead->where()->equals('A.clean_name', $cleanName);
        $resultLead = $sqlLead->execute();
        */

        $sql = "SELECT A.id, A.name, A.clean_name as full_name, C.telefono , 'Accounts' as _module FROM accounts A INNER JOIN accounts_tel_telefonos_1_c B ON B.accounts_tel_telefonos_1accounts_ida = A.id INNER JOIN tel_telefonos C ON C.id = B.accounts_tel_telefonos_1tel_telefonos_idb LEFT JOIN accounts_cstm A_cstm ON A_cstm.id_c = A.id WHERE C.telefono = '{$data}' ";

        //$GLOBALS['log']->fatal($sql);
        $result = $GLOBALS['db']->query($sql);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            //$aux[]=$row;
            array_push($array_telefonos,$row);
        }
        //$GLOBALS['log']->fatal($array_telefonos);
        return $array_telefonos;
    }

    public function existsIn_PO($data)
    {
        $existe = "";
        $array_telefonos = [];

        /*$sqlLead = new SugarQuery();
        $sqlLead->select(array('id', 'first_name','last_name','phone_mobile', 'phone_home', 'phone_work'));
        $sqlLead->from(BeanFactory::getBean('Prospects'), array('team_security' => false));
        $sqlLead->where()->queryOr()->equals('phone_mobile', $data)
            ->equals('phone_home', $data)->equals('phone_work', $data);
        $resultPO = $sqlLead->execute();
        $GLOBALS['log']->fatal('qresultLead',$resultPO);
        */

        $sql = "SELECT prospects.id, CONCAT(prospects.first_name,' ', prospects.last_name) as name, CONCAT(prospects.first_name,' ', prospects.last_name) as full_name, prospects.phone_mobile, prospects.phone_home, prospects.phone_work , 'Prospects' as _module FROM prospects LEFT JOIN prospects_cstm prospects_cstm ON prospects_cstm.id_c = prospects.id WHERE ((prospects.phone_mobile = '{$data}') OR (prospects.phone_home = '{$data}') OR (prospects.phone_work = '{$data}')) AND (prospects.deleted = 0)";
        $result = $GLOBALS['db']->query($sql);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            //$aux[]=$row;
            array_push($array_telefonos,$row);
        }
        //$GLOBALS['log']->fatal($array_telefonos);
        return $array_telefonos;
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
