<?php

/**
 * Created by AF.
 * User: tactos
 * Date: 14/08/23
 * Time: 02:17 PM
 */
class getAsesorCuenta extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'GETActivoAPI' => array(
                'reqType' => 'POST',
                'noLoginRequired' => false,
                'path' => array('asesorCuenta'),
                'pathVars' => array('method'),
                'method' => 'asesorCuentaMethod',
                'shortHelp' => 'Obtiene datos del asesor y directores asociados a una cuenta por producto',
            ),
        );
    }

    public function asesorCuentaMethod($api, $args)
    {
        //Recupera datos de entrada
        $idProducto = isset($args['idProducto']) ? $args['idProducto'] : '' ;
        $idCuenta = isset($args['idCuenta']) ? $args['idCuenta'] : '' ;
        $resultado = [];
        
        //Valida variables
        if(!empty($idCuenta) && !empty($idProducto)){
            //Realiza consulta asesor
            $resultado['id']= $idCuenta;
            $resultado['producto']= $idProducto;
            $resultado['asesor']=[];
            $resultado['dirEquipo']=[];
            $resultado['dirRegional']=[];
            $equipo = '';
            $asesor = "select p.tipo_producto, u.id,u.first_name, u.last_name, uc.equipo_c ,e.email_address, u.phone_mobile, uc.ext_c
              from uni_productos p
              inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = p.id
              inner join users u on u.id = p.assigned_user_id
              inner join users_cstm uc on uc.id_c = u.id
              left join email_addr_bean_rel eb on eb.bean_id = u.id
              left join email_addresses e on e.id = eb.email_address_id
              where ap.accounts_uni_productos_1accounts_ida = '{$idCuenta}'
              and ifnull(eb.deleted,0) = 0
              and ifnull(e.deleted,0) = 0
              and p.tipo_producto ='{$idProducto}'
              limit 1";

            $resultadoAsesor = $GLOBALS['db']->query($asesor);
            
            while ($row = $GLOBALS['db']->fetchByAssoc($resultadoAsesor)) {
                $resultado['asesor']['id'] = $row['id'];
                $resultado['asesor']['nombre'] = $row['first_name'];
                $resultado['asesor']['apellidos'] = $row['last_name'];
                $resultado['asesor']['correo'] = $row['email_address'];
                $resultado['asesor']['phone_mobile'] = $row['phone_mobile'];
                $resultado['asesor']['ext_c'] = $row['ext_c'];
                $equipo = $row['equipo_c'];
            }
            
            //Realiza consulta director equipo
            if(!empty($equipo)){
                $resultado['dirEquipo']=[];
                $dirEquipo = "select u.id, u.first_name, u.last_name, uc.equipo_c, uc.posicion_operativa_c, e.email_address, u.phone_mobile, uc.ext_c
                  from users u
                  inner join users_cstm uc on uc.id_c = u.id
                  left join email_addr_bean_rel eb on eb.bean_id = u.id
                  left join email_addresses e on e.id = eb.email_address_id
                  where uc.equipo_c = '{$equipo}'
                  and ifnull(eb.deleted,0) = 0
                  and ifnull(e.deleted,0) = 0
                  and uc.posicion_operativa_c like '%^1^%'
                  and u.status = 'Active'
                  limit 1";

                $resultadodirEquipo = $GLOBALS['db']->query($dirEquipo);
                
                while ($row = $GLOBALS['db']->fetchByAssoc($resultadodirEquipo)) {
                    $resultado['dirEquipo']['id'] = $row['id'];
                    $resultado['dirEquipo']['nombre'] = $row['first_name'];
                    $resultado['dirEquipo']['apellidos'] = $row['last_name'];
                    $resultado['dirEquipo']['correo'] = $row['email_address'];
                    $resultado['dirEquipo']['phone_mobile'] = $row['phone_mobile'];
                    $resultado['dirEquipo']['ext_c'] = $row['ext_c'];
                }
            }
            
            //Realiza consulta director regional
            if(!empty($equipo)){
                $resultado['dirRegional']=[];
                $dirEquipo = "select u.id, u.first_name, u.last_name, uc.equipo_c, uc.equipos_c, uc.posicion_operativa_c, e.email_address, u.phone_mobile, uc.ext_c
                  from users u
                  inner join users_cstm uc on uc.id_c = u.id
                  left join email_addr_bean_rel eb on eb.bean_id = u.id
                  left join email_addresses e on e.id = eb.email_address_id
                  where uc.equipos_c like '%^{$equipo}^%'
                  and ifnull(eb.deleted,0) = 0
                  and ifnull(e.deleted,0) = 0
                  and uc.posicion_operativa_c like '%^2^%'
                  and u.status = 'Active'
                  limit 1";

                $resultadodirEquipo = $GLOBALS['db']->query($dirEquipo);
                
                while ($row = $GLOBALS['db']->fetchByAssoc($resultadodirEquipo)) {
                    $resultado['dirRegional']['id'] = $row['id'];
                    $resultado['dirRegional']['nombre'] = $row['first_name'];
                    $resultado['dirRegional']['apellidos'] = $row['last_name'];
                    $resultado['dirRegional']['correo'] = $row['email_address'];
                    $resultado['dirRegional']['phone_mobile'] = $row['phone_mobile'];
                    $resultado['dirRegional']['ext_c'] = $row['ext_c'];
                }
            }
        }
        
        //Regresa resultado de consultas
        return $resultado;
    }
}
