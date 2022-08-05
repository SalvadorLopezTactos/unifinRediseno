<?php
/**
 * Created by erick.cruz@tactos.com.mx.
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class email_REUS extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'existsAccounts' => array(
                //request type
                'reqType' => 'POST',
                //set authentication
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('emailReus'),
                //endpoint variables
                'pathVars' => array(''),
                //method to call
                'method' => 'valida_email_Reus',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'valida correos de REUS',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            )

        );
    }


    public function valida_email_Reus($api, $args)
    {
        $salida = false;
        global $current_user,$db;
        $aux = array();
        $datos = $args['datos'];
        $GLOBALS['log']->fatal(print_r($args,true));

        $GLOBALS['log']->fatal($args['info']['idUsuarioLogeado']);

        /*************************************/
        
        $correos = $args['correos'];
        $idCuenta = $args['info']['idCuenta'];
        $puesto_usuario = $args['info']['puesto_usuario'];
        $estatusCuenta = $args['info']['estatusCuenta'];
        $idUsuarioLogeado = $args['info']['idUsuarioLogeado'];

        $reus = false;
        $idUser = $current_user->id;

        $sql = "SELECT email_addresses.id , email_addresses.email_address, eabr.primary_address, 
        email_addresses.opt_out , email_addresses.invalid_email, eabr.bean_module , eabr.bean_id
FROM email_addresses JOIN email_addr_bean_rel eabr ON eabr.email_address_id = email_addresses.id
WHERE eabr.bean_module in ('Accounts')
AND eabr.bean_id = '{$idCuenta}'
AND eabr.primary_address = 1
AND eabr.deleted = 0";

        $GLOBALS['log']->fatal($sql);

        $result = $db->query($sql);
        while($row = $GLOBALS['db']->fetchByAssoc($result) ){
            if($row['opt_out'] == "1"){
                $reus = true;
            }
        }
        if($reus == true){
            $salida = $this->actualiza_email($correos , $puesto_usuario , $estatusCuenta, $idCuenta);
        }
        
        return $salida;
    }

    public function actualiza_email($emails , $puesto_usuario , $estatusCuenta , $idCuenta){
        $estado = 0;
        global $sugar_config, $db , $app_list_strings;
        $array_puestos=array();
        $puestos_comerciales_list=$app_list_strings['puestos_comerciales_list'];
        foreach($puestos_comerciales_list as $clave=>$valor){
            array_push($array_puestos,$clave);

        }
        $GLOBALS['log']->fatal(print_r($array_puestos,true));

        //$current_user = $this->user_api();
        $mailCuenta = false;
        $ids = "";
        $correos = "";
        $reus = true;

        $beanCuenta = BeanFactory::retrieveBean('Accounts', $idCuenta);
        //$beanUser = BeanFactory::retrieveBean('Users', $idUser);

        $GLOBALS['log']->fatal("beanCuenta: " . $beanCuenta->name );
        $GLOBALS['log']->fatal("beanCuenta: " . $beanCuenta->mail1 );
        $GLOBALS['log']->fatal("puestos_comerciales_list: " , $puestos_comerciales_list );

        
        for($i = 0; $i < count($emails); $i++) {
            if($emails[$i]['modulo'] != "Users" && $emails[$i]['modulo'] != "" ){
                $ids = $ids .'"'. $emails[$i]['id'] .'",';
            }

            if($emails[$i]['email'] != ""){
                $correos = $correos .'"'. strtolower($emails[$i]['email']).'",';
            }
        }
        
        $ids = substr($ids, 0, -1);
        $correos = substr($correos, 0, -1);

        $sqlCorreo = "SELECT  DISTINCT(email_addresses.id) , email_addresses.email_address,email_addresses.opt_out ,
            email_addresses.invalid_email
            FROM email_addresses JOIN email_addr_bean_rel eabr
            ON eabr.email_address_id = email_addresses.id
            WHERE email_addresses.email_address in ($correos)
            AND email_addresses.opt_out = 1
            AND eabr.primary_address = 1
            AND eabr.deleted = 0";

            $GLOBALS['log']->fatal("sql OPT OUT POR CORREO: " . $sqlCorreo );
            $resultemails = $db->query($sqlCorreo);


        $sqlIDS = "SELECT  DISTINCT(email_addresses.id) , email_addresses.email_address,email_addresses.opt_out ,
            email_addresses.invalid_email
            FROM email_addresses JOIN email_addr_bean_rel eabr
            ON eabr.email_address_id = email_addresses.id
            WHERE eabr.bean_id in ($ids)
            AND email_addresses.opt_out = 1
            AND eabr.primary_address = 1
            AND eabr.deleted = 0";

            $GLOBALS['log']->fatal("sql OPT OUT POR IDS: " . $sqlIDS );
            $resultIds = $db->query($sqlIDS);


        $sqlProductos = "SELECT a.id cuentaID , up.id prodid , up.name, up.tipo_cuenta  
        from accounts a inner join
        accounts_uni_productos_1_c aupc on a.id = aupc.accounts_uni_productos_1accounts_ida 
        inner join uni_productos up on aupc.accounts_uni_productos_1uni_productos_idb = up.id 
        where a.id = '{$idCuenta}'
        AND up.tipo_cuenta = 3;";
        $GLOBALS['log']->fatal("sql PRODUCTOS CUENTA REUS: " . $sqlProductos );
        $result = $db->query($sqlProductos);

        $puestoComercial = in_array($puesto_usuario, $array_puestos);

        if($resultemails->num_rows>0 || $resultIds->num_rows>0){
            
            if ($puestoComercial && $result->num_rows > 0) {
                $reus = false;
            }
            if (!$puestoComercial && $estatusCuenta == '3') {
                $reus = false;
            }
        }

        return $reus;
    }
}