<?php
/**
 * Created by Salvador Lopez.
 * User: salvador.lopez@tactos.com.mx
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ClientManager extends SugarApi
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
                //endpoint path
                'path' => array('GetCMInfoKanban'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'getInfoKanban',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Obtiene información para poblar dashlet con vista Kanban de Client Manager',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function getInfoKanban($api, $args){
        global $db,$current_user;
        $id_usuario=$current_user->id;
        //$id_usuario='cb6dfd0a-257a-5977-db84-599b31c3e22b';

        $query = <<<SQL
			SELECT l.id id_registro,
        'Leads' modulo,
        lc.nombre_c nombre,
        lc.apellido_paterno_c apellido,
        lc.nombre_empresa_c nombre_empresa,
        lc.tipo_registro_c tipo_registro,
        lc.subtipo_registro_c subtipo_registro,
        l.assigned_user_id,
        l.date_modified,
        f.id idFav
        FROM leads l INNER JOIN leads_cstm lc
        ON l.id=lc.id_c
        LEFT JOIN sugarfavorites f ON l.id = f.record_id and f.deleted=0
        WHERE lc.tipo_registro_c IN ('1','2','3')
        AND lc.subtipo_registro_c IN('1','2','7')
        AND l.assigned_user_id ='{$id_usuario}'
        AND l.deleted=0
        -- AND f.deleted=0
        UNION
        SELECT a.id,
        'Accounts' modulo,
        ac.primernombre_c,
        ac.apellidopaterno_c,
        ac.razonsocial_c,
        ac.tipo_registro_cuenta_c,
        ac.subtipo_registro_cuenta_c,
        a.assigned_user_id,
        a.date_modified,
        f.id idFav
        FROM accounts a INNER JOIN accounts_cstm ac
        ON a.id=ac.id_c
        LEFT JOIN sugarfavorites f ON a.id = f.record_id and f.deleted=0
        WHERE ac.tipo_registro_cuenta_c IN ('1','2','3')
        AND ac.subtipo_registro_cuenta_c IN('1','2','7','8','9','11','17')
        AND a.assigned_user_id ='{$id_usuario}'
        AND a.deleted=0
        -- AND f.deleted=0
        ORDER BY idFav DESC;;
SQL;

        $result = $db->query($query);

        $registros_sin_contactar=array();
        $total_leads_sin_contactar=0;

        $registros_contactado=array();
        $total_prospecto_contactado=0;

        $registros_interesado=array();
        $total_prospecto_interesado=0;
        $monto_prospecto_interesado=0;

        $registros_int_expediente=array();
        $total_int_expediente=0;
        $monto_int_expediente=0;

        $registros_credito=array();
        $total_prospecto_credito=0;
        $monto_prospecto_credito=0;

        $registros_cliente_linea_sin_operar=array();
        $total_cliente_linea_sin_operar=0;
        $monto_cliente_linea_sin_operar=0;

        $registros_cliente_activo=array();
        $total_cliente_activo=0;
        $monto_cliente_activo=0;

        $registros_cliente_perdido=array();
        $total_cliente_perdido=0;
        $monto_cliente_perdido=0;
        
        while ($row = $db->fetchByAssoc($result)) {
          $id=$row['id_registro'];
          $modulo=$row['modulo'];
          $tipo=$row['tipo_registro'];
          $subtipo=$row['subtipo_registro'];
          $nombre=$row['nombre']." ".$row['apellido'];
          $date_modified=$row['date_modified'];
          $nombre_empresa=$row['nombre_empresa'];
          $idFavorito=$row['idFav'];
            //Lead sin Contactar
            if($tipo=='1' && $subtipo=='1'){
                $total_leads_sin_contactar+=1;
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_lead_sin_contactar=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_sin_contactar[]=$array_lead_sin_contactar;
            }

            //Prospecto Contactado
            if($tipo=='2' && $subtipo=='2'){
                $total_prospecto_contactado+=1;
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_prospecto_contactado=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_contactado[]=$array_prospecto_contactado;
            }

            //Prospecto Interesado
            if($tipo=='2' && $subtipo=='7'){
                $total_prospecto_interesado+=1;
                //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                //array('monto_total'=>$monto,'monto_cuenta'=>$monto_cuenta)
                $montos_prospecto_interesado=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_prospecto_interesado);
                $monto_prospecto_interesado=$montos_prospecto_interesado['monto_total'];
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_prospecto_interesado=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Monto_Cuenta"=>$montos_prospecto_interesado['monto_cuenta'],
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_interesado[]=$array_prospecto_interesado;
            }

            //Prospecto Integración de Expediente
            if($tipo=='2' && $subtipo=='8'){
                $total_int_expediente+=1;
                //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                $montos_int_expediente=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_int_expediente);
                $monto_int_expediente=$montos_int_expediente['monto_total'];
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_prospecto_int_expediente=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Monto_Cuenta"=>$montos_int_expediente['monto_cuenta'],
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                );
                
                $registros_int_expediente[]=$array_prospecto_int_expediente;
            }

            //Prospecto en Crédito
            if($tipo=='2' && $subtipo=='9'){
                $total_prospecto_credito+=1;
                //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                $montos_prospecto_credito=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_prospecto_credito);
                $monto_prospecto_credito=$montos_prospecto_credito['monto_total'];
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_prospecto_credito=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Monto_Cuenta"=>$montos_prospecto_credito['monto_cuenta'],
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                );
                
                
                $registros_credito[]=$array_prospecto_credito;
            }

            //Cliente con Línea sin Operar
            /*ToDo: FALTA SABER ID */
            /*
            if($tipo=='2' && $subtipo=='7'){
                $total_prospecto_interesado+=1;
                $array_prospecto_interesado=array(
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Dias_Etapa"=>"2",
                    "Favorito"=>1,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                ); 
                
                $registros_interesado[]=$array_prospecto_interesado;
            }
            */

            //Cliente Activo
            if($tipo=='2' && $subtipo=='11'){
                $total_cliente_activo+=1;
                //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                $montos_cliente_activo=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_cliente_activo);
                $monto_cliente_activo=$montos_cliente_activo['monto_total'];
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_cliente_activo=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Subtipo_Registro"=>$subtipo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Monto_Cuenta"=>$montos_cliente_activo['monto_cuenta'],
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                );
                
                $registros_cliente_activo[]=$array_cliente_activo;
            }

            //Cliente Perdido
            if($tipo=='2' && $subtipo=='17'){
                $total_cliente_perdido+=1;
                $montos_cliente_perdido=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_cliente_perdido);
                $monto_cliente_perdido=$montos_cliente_perdido['monto_total'];
                $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                $array_cliente_perdido=array(
                    "Id"=>$id,
                    "Modulo"=>$modulo,
                    "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                    "Monto_Cuenta"=>$montos_cliente_perdido['monto_cuenta'],
                    "Dias_Etapa"=>$dias_etapa,
                    "Favorito"=>$idFavorito,
                    "Date_Modified"=>$date_modified,
                    "Preview"=>array("Info Preview")
                );
                
                $registros_cliente_perdido[]=$array_cliente_perdido;
            }
        }

        $response=array(
            "Lead_Sin_Contactar"=>array(
                "Total_Registros"=>$total_leads_sin_contactar,
                "Total_Monto"=>0,
                "Subtipo_Registro"=>"1",
                "Registros"=>$registros_sin_contactar
            ),
            "Prospecto_Contactado"=>array(
                "Total_Registros"=>$total_prospecto_contactado,
                "Total_Monto"=>0,
                "Subtipo_Registro"=>"2",
                "Registros"=>$registros_contactado
            ),
            "Prospecto_Interesado"=>array(
                "Total_Registros"=>$total_prospecto_interesado,
                "Total_Monto"=>$monto_prospecto_interesado,
                "Subtipo_Registro"=>"7",
                "Registros"=>$registros_interesado
            ),
            "Prospecto_Integracion_Expediente"=>array(
                "Total_Registros"=>$total_int_expediente,
                "Total_Monto"=>$monto_int_expediente,
                "Registros"=>$registros_int_expediente
            ),
            "Prospecto_Credito"=>array(
                "Total_Registros"=>$total_prospecto_credito,
                "Total_Monto"=>$monto_prospecto_credito,
                "Registros"=>$registros_credito
            ),
            "Cliente_Linea_Sin_Operar"=>array(
                "Total_Registros"=>$total_cliente_linea_sin_operar,
                "Total_Monto"=>$monto_cliente_linea_sin_operar,
                "Registros"=>$registros_cliente_linea_sin_operar
            ),
            "Cliente_Activo"=>array(
                "Total_Registros"=>$total_cliente_activo,
                "Total_Monto"=>$monto_cliente_activo,
                "Registros"=>$registros_cliente_activo
            ),
            "Cliente_Perdido"=>array(
                "Total_Registros"=>$total_cliente_perdido,
                "Total_Monto"=>$monto_cliente_perdido,
                "Registros"=>$registros_cliente_perdido
            ),
        );

        return $response;

    }

    public function getSolicitudes($modulo,$id_usuario,$id_cuenta,$monto){
        global $db;
        $array_montos=array();
        $monto_cuenta=0;

        if($modulo=='Accounts'){
            $querySolicitudes= <<<SQL
        SELECT ac.primernombre_c, 
ac.apellidopaterno_c,
ac.razonsocial_c,
opp.name,
oppc.monto_c,
oppc.tct_etapa_ddw_c,
oppc.estatus_c
FROM accounts a
INNER JOIN accounts_cstm ac ON a.id=ac.id_c
INNER JOIN accounts_opportunities ao ON a.id=ao.account_id
INNER JOIN opportunities opp ON opp.id=ao.opportunity_id
INNER JOIN opportunities_cstm oppc ON opp.id=oppc.id_c
WHERE opp.assigned_user_id='{$id_usuario}'
AND a.id='{$id_cuenta}'
AND oppc.tct_etapa_ddw_c != 'R' AND oppc.estatus_c NOT IN('R','K','CM')
AND opp.deleted=0 AND ao.deleted=0 AND a.deleted=0
ORDER BY opp.date_modified DESC;
SQL;
            $resultSolicitudes = $db->query($querySolicitudes);
            //$GLOBALS['log']->fatal('La cuenta: '.$id_cuenta.' tiene '.$resultSolicitudes->num_rows);
            if($resultSolicitudes->num_rows>0){

                while ($fila = $db->fetchByAssoc($resultSolicitudes)) {
                    $monto_cuenta+=floatval($fila['monto_c']);
                    $monto+=floatval($fila['monto_c']);
                }
            }
        }

        //$GLOBALS['log']->fatal(print_r(array('monto_total'=>$monto,'monto_cuenta'=>$monto_cuenta),true));

        return array('monto_total'=>$monto,'monto_cuenta'=>$monto_cuenta);
    }

    public function getDiasEtapa($modulo,$id_registro,$valor_etapa){
        global $db;
        $nombre_campo='subtipo_registro_c';
        if($modulo=='Accounts'){
            $nombre_campo='subtipo_registro_cuenta_c';
        }
        $dias_etapa=0;
        $queryGetDiasEtapa=<<<SQL
SELECT DATEDIFF(curdate(),(SELECT date_created FROM accounts_audit 
WHERE parent_id='{$id_registro}'
AND field_name='{$nombre_campo}'
AND after_value_string='{$valor_etapa}')) AS dias_etapa
SQL;
        $resultDiasEtapa = $db->query($queryGetDiasEtapa);
        if($resultDiasEtapa->num_rows>0){

            while ($row = $db->fetchByAssoc($resultDiasEtapa)) {
                if($row['dias_etapa']!=null){
                    $dias_etapa=$row['dias_etapa'];
                }
            }   
        }
        //Convirtiendo los días en etapa en meses
        $str_mes_dia='D';
        if($dias_etapa>=90){
            $dias_etapa=floor($dias_etapa/30);
            $str_mes_dia='M';
        }

        return $dias_etapa.$str_mes_dia;
    }

}

?>
