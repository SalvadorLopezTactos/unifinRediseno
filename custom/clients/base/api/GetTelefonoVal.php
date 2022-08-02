<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class GetTelefonoVal extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GetTelefonoVal_API' => array(
                'reqType' => 'GET',
                'noLoginRequired' => false,
                'path' => array('GetTelefonoVal','?'),
                'pathVars' => array('module','id'),
                'method' => 'getTelefonos',
                'shortHelp' => 'Obtiene la suma de cantidades para backlog',
            ),
        );
    }
    public function getTelefonos($api, $args){

        try {
            global $current_user;
            $id_user = $current_user->id;
            $posicion_operativa = $current_user->posicion_operativa_c;
            $equipo_c = $current_user->equipo_c;
            $callid = $args['id'];
            $response_Services = null;
            $tel = "";
            $GLOBALS['log']->fatal('callid', $callid);
            
            //$GLOBALS['log']->fatal('equipo_c', $id_user.' - '.$current_user->equipo_c);
            $bean = BeanFactory::retrieveBean('Calls', $callid, array('disable_row_level_security' => true));
            $parent_type = $bean->parent_type;
            $parent_id = $bean->parent_id;

            if($parent_id != ''){
                if($parent_type=='Accounts'){
                    $tel = $this->existsIn_Accounts($parent_id);
                }else if($parent_type=='Leads'){
                    $tel = $this->existsIn_Leads($parent_id);
                }
                $GLOBALS['log']->fatal('tel', $tel);
                if($tel['tel'] == "0"){
                    $response_Services["status"] = "210";
                    $response_Services["tel"] = "0";
                    $response_Services["nombre"] = $tel['nombre'];
                    $response_Services["detalle"] = "reus";
                }else{
                    $response_Services["status"] = "200";
                    $response_Services["tel"] = $tel['tel'];
                    $response_Services["nombre"] = $tel['nombre'];
                }
            }else {
                $response_Services["status"] = "300";
                $response_Services["detalle"] = "Sin relacion";
            }

            $GLOBALS['log']->fatal('response_Services', $response_Services);

            return $response_Services;
        } catch (Exception $e) {
            $GLOBALS['log']->fatal("Error: " . $e->getMessage());
            $response_Services["status"] = "400";
            $response_Services["detalle"] = "Error";
            return $response_Services;
        }
    }

    public function existsIn_Leads($id)
    {
        $tel = "";
        $reus = "0";
        
        $sql = "SELECT leads.id, leads.last_name AS name, lc.clean_name_c as full_name, 
        CASE WHEN leads.phone_work is not null THEN leads.phone_work
             WHEN leads.phone_mobile is not null THEN leads.phone_mobile
             WHEN leads.phone_home is not null THEN leads.phone_home
            END AS telefono,
        CASE WHEN leads.phone_work is not null THEN lc.o_registro_reus_c
             WHEN leads.phone_mobile is not null THEN lc.m_registro_reus_c
             WHEN leads.phone_home is not null THEN lc.c_registro_reus_c
            END AS reus,
        leads.phone_work ,leads.phone_mobile,leads.phone_home, 
        lc.o_registro_reus_c , lc.m_registro_reus_c, lc.c_registro_reus_c
         FROM leads LEFT JOIN leads_cstm lc ON lc.id_c = leads.id 
         WHERE leads.deleted = 0  AND leads.id = '{$id}' ";
        
        $result = $GLOBALS['db']->query($sql);
        //$GLOBALS['log']->fatal("result",$result);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $tel = $row['telefono'];
            $reus = $row['reus'];
            $name = $row['full_name'];
        }

        if($reus == "1"){
            $tel = "0";
        }

        $res["nombre"] = $name;
        $res["tel"] = $tel;

        return $res;
    }

    public function existsIn_Accounts($id)
    {
        $tel = "";
        $reus = "0";

        $sql = "SELECT A.id, A.name, A.clean_name as full_name, C.telefono ,C.estatus, C.tipotelefono, CC.registro_reus_c FROM accounts A 
        INNER JOIN accounts_cstm A_cstm ON A_cstm.id_c = A.id
        LEFT JOIN accounts_tel_telefonos_1_c B ON B.accounts_tel_telefonos_1accounts_ida = A.id 
        LEFT JOIN tel_telefonos C ON C.id = B.accounts_tel_telefonos_1tel_telefonos_idb 
        INNER JOIN tel_telefonos_cstm CC on C.id = CC.id_c
        WHERE A.deleted=0 and C.estatus = 'Activo' and C.deleted=0 and
        C.principal = 1 and A.id = '{$id}' limit 1";
        $result = $GLOBALS['db']->query($sql);
        //$GLOBALS['log']->fatal("result",$result);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            $tel = $row['telefono'];
            $reus = $row['registro_reus_c'];
            $name = $row['full_name'];
        }

        if($reus == "1"){
            $tel = "0";
        }
        
        $res["nombre"] = $name;
        $res["tel"] = $tel;

        return $res;
    }

        
}
