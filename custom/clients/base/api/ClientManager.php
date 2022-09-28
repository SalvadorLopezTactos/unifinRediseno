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

            'retrieveGetChecklist' => array(
                'reqType' => 'GET',
                'path' => array('GetChecklistKanban','?','?'),
                'pathVars' => array('','idRegistro','tipoRegistro'),
                'method' => 'getChecklistKanban',
                'shortHelp' => 'Obtiene información para checklist de vista kanban',
            ),

            'retrieveProspectosEstatus' => array(
                'reqType' => 'GET',
                'path' => array('GetProspectosEstatus','?'),
                'pathVars' => array('','equipo'),
                'method' => 'getProspectosEstatus',
                'shortHelp' => 'Obtiene conteo de registros agrupados por etapas y por asesor para mostrar en dashlet con gráfica',
            )



        );

    }

    public function getInfoKanban($api, $args){
        global $db,$current_user;
        $id_usuario=$current_user->id;
        //$id_usuario='cb6dfd0a-257a-5977-db84-599b31c3e22b';

        $query = <<<SQL
			SELECT l.id id_registro,
        'Leads' modulo,
        trim(l.last_name) name,
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
        trim(a.name) name,
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
        AND ac.subtipo_registro_cuenta_c IN('1','2','7','8','9')
        -- AND a.assigned_user_id ='{$id_usuario}'
        AND (ac.user_id_c='{$id_usuario}' OR 
			ac.user_id1_c='{$id_usuario}' OR 
            ac.user_id2_c='{$id_usuario}' OR 
            ac.user_id6_c='{$id_usuario}' OR 
            ac.user_id7_c='{$id_usuario}' OR 
            ac.user_id8_c='{$id_usuario}'
		)
        AND a.deleted=0
        -- AND f.deleted=0
        ORDER BY idFav DESC,name;
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
                $montos_prospecto_interesado=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_prospecto_interesado,'');
                //$monto_prospecto_interesado+=$montos_prospecto_interesado['monto_total'];
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
                $montos_int_expediente=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_int_expediente,'');
                //$monto_int_expediente+=$montos_int_expediente['monto_total'];
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
                $montos_prospecto_credito=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_prospecto_credito,'');
                //$monto_prospecto_credito=+$montos_prospecto_credito['monto_total'];
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

            //Sección de Clientes (Cliente con linea sin operar, Cliente Activo, Cliente Perdido)
            if($tipo=='3' && $subtipo!='3' && $subtipo!='10' && $subtipo!='15' && $subtipo!='17'){
                //Subtipo -- 3:Cancelado, 10:Rechazado, 15:Inactivo, 17:Perdido
                $beanCliente = BeanFactory::getBean('Accounts', $id, array('disable_row_level_security' => true));
                if($beanCliente->load_relationship('accounts_uni_productos_1')){

                    $producto_usuario=$current_user->tipodeproducto_c;
                    $array_es_cliente_linea_sin_operar=array();
                    $array_es_cliente_activo=array();
                    $array_es_cliente_perdido=array();
                    
                    $relatedProductos = $beanCliente->accounts_uni_productos_1->getBeans();
                    if(count($relatedProductos)>0){
                        foreach($relatedProductos as $prod) {
                            //$GLOBALS['log']->fatal('ID CUENTA: '.$id.' ACTIVOS: '.$prod->registros_activos_c.' HISTORICOS: '.$prod->registros_historicos_c);
                            //Cliente con linea sin operar
                            if($prod->tipo_producto==$producto_usuario){
                                if($prod->registros_activos_c=='' && $prod->registros_historicos_c==''){
                                    array_push($array_es_cliente_linea_sin_operar,'1');
                                    //$GLOBALS['log']->fatal('ID CUENTA: '.$id.' ENTRA LINEA SIN OPERAR '.$prod->id);
                                }
    
                                //Cliente Activo
                                if($prod->registros_activos_c!=''){
                                    array_push($array_es_cliente_activo,'1');
                                    //$GLOBALS['log']->fatal('ID CUENTA: '.$id.' ENTRA ACTIVO '.$prod->id);
                                }
    
                                //Cliente Perdido
                                if($prod->registros_activos_c=='' && $prod->registros_historicos_c!='' ){
                                    array_push($array_es_cliente_perdido,'1');
                                    //$GLOBALS['log']->fatal('ID CUENTA: '.$id.' ENTRA PERDIDO'.$prod->id);
                                }
                            }
                        }

                    }
                }

                //Cliente con linea sin operar
                if(in_array('1',$array_es_cliente_linea_sin_operar)){
                    $total_cliente_linea_sin_operar+=1;
                    //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                    // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                    $montos_cliente_linea_sin_operar=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_cliente_linea_sin_operar,'lineas');
                    //$monto_cliente_linea_sin_operar+=$montos_cliente_linea_sin_operar['monto_total'];

                    $diferencia_dias_vigencia=$montos_cliente_linea_sin_operar['diferencia_dias'];
                    //Si la diferencia es negativa, la linea sigue vigente, si es positiva, la linea ya está vencida
                    if($diferencia_dias_vigencia<0){
                        $texto_vigencia_linea='Línea Vigente';
                        $color="#82b785";
                    }else{
                        $texto_vigencia_linea='Línea Vencida';
                        $color="red";
                    }
                    $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                    $array_cliente_linea_sin_operar=array(
                        "Id"=>$id,
                        "Modulo"=>$modulo,
                        "Subtipo_Registro"=>$subtipo,
                        "Nombre"=>($nombre_empresa=="" || $nombre_empresa==null) ? $nombre:$nombre_empresa,
                        "Monto_Cuenta"=>$montos_cliente_linea_sin_operar['monto_cuenta'],
                        "Dias_Etapa"=>$dias_etapa,
                        "Favorito"=>$idFavorito,
                        "Date_Modified"=>$date_modified,
                        "Preview"=>array("Info Preview"),
                        "Vigencia_Linea"=>$texto_vigencia_linea,
                        "Dias_Vigencia"=>$diferencia_dias_vigencia,
                        "Color"=>$color
                    );
                    
                    $registros_cliente_linea_sin_operar[]=$array_cliente_linea_sin_operar;
                }

                //Cliente Activo
                if(in_array('1',$array_es_cliente_activo)){
                    $total_cliente_activo+=1;
                    //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                    // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                    $montos_cliente_activo=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_cliente_activo,'');
                    //$monto_cliente_activo+=$montos_cliente_activo['monto_total'];
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
                if(in_array('1',$array_es_cliente_perdido)){
                    $total_cliente_perdido+=1;
                    //Obteniendo solicitudes relacionadas al usuario logueado sin tomar en cuenta las canceladas ni rechazadas
                    // tct_etapa_ddw_c - R, estatus_c - R, K, CM
                    $montos_cliente_perdido=$this->getSolicitudes($modulo,$id_usuario,$id,$monto_cliente_perdido,'');
                    //$monto_cliente_perdido+=$montos_cliente_perdido['monto_total'];
                    $dias_etapa=$this->getDiasEtapa($modulo,$id,$subtipo);
                    $array_cliente_perdido=array(
                        "Id"=>$id,
                        "Modulo"=>$modulo,
                        "Subtipo_Registro"=>$subtipo,
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
        }

        //$GLOBALS['log']->fatal("ANTES:");
        //$GLOBALS['log']->fatal(print_r($registros_cliente_linea_sin_operar,true));
        //El arreglo para los registros de Cliente con Línea sin Operar se ordena con base a la vigencia de la linea
        $Dias_Vigencia = array_column($registros_cliente_linea_sin_operar, 'Dias_Vigencia');
        array_multisort($Dias_Vigencia, SORT_ASC, $registros_cliente_linea_sin_operar);
        //$GLOBALS['log']->fatal("DESPUÉS:");
        //$GLOBALS['log']->fatal(print_r($registros_cliente_linea_sin_operar,true));

        //Calculando monto total de cada sección
        if(count($registros_interesado)>0){
            for ($i=0; $i <count($registros_interesado) ; $i++) { 
                $monto_prospecto_interesado+=floatval($registros_interesado[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_interesado[$i]['Monto_Cuenta']=number_format(floatval($registros_interesado[$i]['Monto_Cuenta']),2);
            }
        }

        if(count($registros_int_expediente)>0){
            for ($i=0; $i <count($registros_int_expediente) ; $i++) { 
                $monto_int_expediente+=floatval($registros_int_expediente[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_int_expediente[$i]['Monto_Cuenta']=number_format(floatval($registros_int_expediente[$i]['Monto_Cuenta']),2);
            }
        }

        if(count($registros_credito)>0){
            for ($i=0; $i <count($registros_credito) ; $i++) { 
                $monto_prospecto_credito+=floatval($registros_credito[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_credito[$i]['Monto_Cuenta']=number_format(floatval($registros_credito[$i]['Monto_Cuenta']),2);
            }
        }

        if(count($registros_cliente_linea_sin_operar)>0){
            for ($i=0; $i <count($registros_cliente_linea_sin_operar) ; $i++) { 
                $monto_cliente_linea_sin_operar+=floatval($registros_cliente_linea_sin_operar[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_cliente_linea_sin_operar[$i]['Monto_Cuenta']=number_format(floatval($registros_cliente_linea_sin_operar[$i]['Monto_Cuenta']),2);
            }
        }

        if(count($registros_cliente_activo)>0){
            for ($i=0; $i <count($registros_cliente_activo) ; $i++) { 
                $monto_cliente_activo+=floatval($registros_cliente_activo[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_cliente_activo[$i]['Monto_Cuenta']=number_format(floatval($registros_cliente_activo[$i]['Monto_Cuenta']),2);
            }
        }

        if(count($registros_cliente_perdido)>0){
            for ($i=0; $i <count($registros_cliente_perdido) ; $i++) { 
                $monto_cliente_perdido+=floatval($registros_cliente_perdido[$i]['Monto_Cuenta']);
                //Estableciendo formato a dos decimales
                $registros_cliente_perdido[$i]['Monto_Cuenta']=number_format(floatval($registros_cliente_perdido[$i]['Monto_Cuenta']),2);
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
                "Total_Monto"=>number_format(floatval($monto_prospecto_interesado),2),
                "Subtipo_Registro"=>"7",
                "Registros"=>$registros_interesado
            ),
            "Prospecto_Integracion_Expediente"=>array(
                "Total_Registros"=>$total_int_expediente,
                "Total_Monto"=>number_format(floatval($monto_int_expediente),2),
                "Registros"=>$registros_int_expediente
            ),
            "Prospecto_Credito"=>array(
                "Total_Registros"=>$total_prospecto_credito,
                "Total_Monto"=>number_format(floatval($monto_prospecto_credito),2),
                "Registros"=>$registros_credito
            ),
            "Cliente_Linea_Sin_Operar"=>array(
                "Total_Registros"=>$total_cliente_linea_sin_operar,
                "Total_Monto"=>number_format(floatval($monto_cliente_linea_sin_operar),2),
                "Registros"=>$registros_cliente_linea_sin_operar
            ),
            "Cliente_Activo"=>array(
                "Total_Registros"=>$total_cliente_activo,
                "Total_Monto"=>number_format(floatval($monto_cliente_activo),2),
                "Registros"=>$registros_cliente_activo
            ),
            "Cliente_Perdido"=>array(
                "Total_Registros"=>$total_cliente_perdido,
                "Total_Monto"=>number_format(floatval($monto_cliente_perdido),2),
                "Registros"=>$registros_cliente_perdido
            ),
        );

        return $response;

    }

    public function getSolicitudes($modulo,$id_usuario,$id_cuenta,$monto,$lineas){
        global $db,$current_user;
        $producto_usuario=$current_user->tipodeproducto_c;
        $array_montos=array();
        $monto_cuenta=0;
        $diferencia_dias=0;

        if($modulo=='Accounts'){
            $querySolicitudes= <<<SQL
        SELECT ac.primernombre_c, 
ac.apellidopaterno_c,
ac.razonsocial_c,
opp.name,
oppc.monto_c,
oppc.tct_etapa_ddw_c,
oppc.estatus_c,
oppc.tipo_producto_c,
oppc.vigencialinea_c
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

                    if($fila['tipo_producto_c']==$producto_usuario){
                        $monto_cuenta+=floatval($fila['monto_c']);
                        $monto+=floatval($fila['monto_c']);
                        //Obtener la vigencia de la linea correspondiente al producto del usuario logueado
                        //Obtener diferencia en días entre fecha actual y la fecha de vigencia de la linea
                        if($fila['vigencialinea_c']!=''){
                            $now = time();
                            $your_date = strtotime($fila['vigencialinea_c']);
                            $datediff = $now - $your_date;
                            $diferencia_dias=round($datediff / (60 * 60 * 24));
                        }
                        
                    }
                }
            }
        }

        //$GLOBALS['log']->fatal(print_r(array('monto_total'=>$monto,'monto_cuenta'=>$monto_cuenta),true));
        if($lineas!=''){
            return array('monto_total'=>number_format($monto, 2),'monto_cuenta'=>$monto_cuenta,'diferencia_dias'=>$diferencia_dias);
        }else{
            return array('monto_total'=>number_format($monto, 2),'monto_cuenta'=>$monto_cuenta);
        }
        
    }

    public function getDiasEtapa($modulo,$id_registro,$valor_etapa){
        global $db;
        $nombre_campo='subtipo_registro_c';
        $nombre_tabla='leads_audit';
        if($modulo=='Accounts'){
            $nombre_campo='subtipo_registro_cuenta_c';
            $nombre_tabla='accounts_audit';
        }
        $dias_etapa=0;
        $queryGetDiasEtapa=<<<SQL
SELECT DATEDIFF(curdate(),(SELECT date_created FROM {$nombre_tabla} 
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

    public function getChecklistKanban($api, $args){
        $idRegistro=$args['idRegistro'];
        $tipoRegistro=$args['tipoRegistro'];
        $array_respuesta=array();

        //Lead Sin Contactar: macrosector_c, email1, teléfono, reunión o llamada
        if($tipoRegistro=='LSC'){
            $beanLead = BeanFactory::getBean('Leads', $idRegistro, array('disable_row_level_security' => true));
            $macrosector=$beanLead->macrosector_c;
            $email=$beanLead->email1;
            $telefonoMobile=$beanLead->phone_mobile;
            $telefonoTrabajo=$beanLead->phone_work;
            $telefonoCasa=$beanLead->phone_home;

            if($macrosector!="" && $macrosector!=null){
                $GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene macrosector');
                array_push($array_respuesta,'macrosector');
            }

            if($email!="" && $email!=null){
                $GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene email');
                array_push($array_respuesta,'email');
            }

            if(($telefonoMobile!="" && $telefonoMobile!=null) || ($telefonoTrabajo!="" && $telefonoTrabajo!=null) || ($telefonoCasa!="" && $telefonoCasa!=null)){
                $GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene teléfono');
                array_push($array_respuesta,'telefono');
            }
            
            //Obteniendo reuniones registradas
            if($beanLead->load_relationship('meetings')){
                $relatedReuniones = $beanLead->meetings->getBeans();
                if(count($relatedReuniones)>0){
                    $GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene reuniones, forma parte de checklist');
                    array_push($array_respuesta,'reunion');
                }
            }

            $array_llamadas_realizadas=array();
            if($beanLead->load_relationship('calls')){
                $relatedllamadas = $beanLead->calls->getBeans();
                if(count($relatedllamadas)>0){
                    //$GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene llamadas, forma parte de checklist');
                    foreach($relatedllamadas as $call) {
                        if($call->status=='Held'){
                            $GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene llamada realizada');
                            array_push($array_llamadas_realizadas,'1');
                        }
                    }
                }
            }

            if(in_array('1',$array_llamadas_realizadas)){
                array_push($array_respuesta,'llamada');
            }

        }

        //Prospecto Contactado: 
        /** 
         * actividadeconomica_c,
         * Actividad Económica, Dirección Administrativa,Situación de Grupo Empresarial,Registrar una Presolicitud
        */
        if($tipoRegistro=='PC'){
            $beanPC = BeanFactory::getBean('Accounts', $idRegistro, array('disable_row_level_security' => true));
            $actividad_economica=$beanPC->actividadeconomica_c;
            $situacin_grupo=$beanPC->situacion_gpo_empresarial_c;

            if($actividad_economica!="" && $actividad_economica!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene actividad económica');
                array_push($array_respuesta,'actividadeconomica');
            }

            if($situacin_grupo!="" && $situacin_grupo!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Situación de Grupo Empresarial');
                array_push($array_respuesta,'situaciongrupo');
            }

            //Obteniendo direcciones para saber si tiene administrativa
            $array_direcciones_admin=array();
            if($beanPC->load_relationship('accounts_dire_direccion_1')){
                $relatedDirecciones = $beanPC->accounts_dire_direccion_1->getBeans();
                if(count($relatedDirecciones)>0){
                    $tipos_administracion=array('16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63');
                    //$GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene llamadas, forma parte de checklist');
                    foreach($relatedDirecciones as $dir) {
                        if(in_array($dir->indicador,$tipos_administracion)){
                            $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene direccion de admin');
                            array_push($array_direcciones_admin,'1');
                        }
                    }
                }
            }

            if(in_array('1',$array_direcciones_admin)){
                array_push($array_respuesta,'direccion_admin');
            }

            //Obteniendo solicitudes para saber si tiene alguna "PRE Solicitud" registrada
            $array_solicitudes=array();
            if($beanPC->load_relationship('opportunities')){
                $relatedOpps = $beanPC->opportunities->getBeans();
                if(count($relatedOpps)>0){
                    foreach($relatedOpps as $opp) {
                        $nombre_opp=$opp->name;
                        $nombre_opp_array=explode("-", $nombre_opp);
                        if(trim($nombre_opp_array[0])=='PRE'){
                            $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene PRE Solicitud');
                            array_push($array_solicitudes,'1');
                        }
                    }
                }
            }

            if(in_array('1',$array_solicitudes)){
                array_push($array_respuesta,'presolicitud');
            }

        }

        //Prospecto Interesado:
        /**RFC: rfc_c
            Dirección Fiscal y de Correspondencia: ***
            Fecha Constitutiva:  fechaconstitutiva_c
            País de Constitución: pais_nacimiento_c
            Estado de Constitución: zonageografica_c
            Ventas Anuales: ventas_anuales_c
            Año de Ventas Anuales: tct_ano_ventas_ddw_c
            Activo Fijo: activo_fijo_c
            Marcar una relación de tipo “Propietario Real”: ***
            Cuestionario PLD: ***
            Condición Financiera: ***
            Pago Mensual: ***
            Pago Único: ***
            Scoring Comercial: ***
            VoBo del director: ***
         * 
         */
        if($tipoRegistro=='PI'){

            $beanPI = BeanFactory::getBean('Accounts', $idRegistro, array('disable_row_level_security' => true));
            $rfc=$beanPI->rfc_c;
            $fecha_constitutiva=$beanPI->fechaconstitutiva_c;
            $pais_constitucion=$beanPI->pais_nacimiento_c;
            $estado_constitucion=$beanPI->zonageografica_c;
            $ventas_anuales=$beanPI->ventas_anuales_c;
            $anio_ventas_anuales=$beanPI->tct_ano_ventas_ddw_c;
            $activo_fijo=$beanPI->activo_fijo_c;

            if($rfc!="" && $rfc!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene rfc');
                array_push($array_respuesta,'rfc');
            }

            if($fecha_constitutiva!="" && $fecha_constitutiva!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Fecha Constitutiva');
                array_push($array_respuesta,'fecha_constitutiva');
            }

            if($pais_constitucion!="" && $pais_constitucion!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Pais de Constitución');
                array_push($array_respuesta,'pais_constitucion');
            }

            if($estado_constitucion!="" && $estado_constitucion!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Estado de Constitución');
                array_push($array_respuesta,'estado_constitucion');
            }

            if($ventas_anuales!="" && $ventas_anuales!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Ventas Anuales');
                array_push($array_respuesta,'ventas_anuales');
            }

            if($anio_ventas_anuales!="" && $anio_ventas_anuales!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Anio de Ventas Anuales');
                array_push($array_respuesta,'anio_ventas_anuales');
            }

            if($activo_fijo!="" && $activo_fijo!=null){
                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Activo Fijo');
                array_push($array_respuesta,'activo_fijo');
            }

            //Obteniendo direcciones para validar direccion fiscal y correspondencia
            $array_direcciones_fiscal_correspondencia=array();
            if($beanPI->load_relationship('accounts_dire_direccion_1')){
                $relatedDirecciones = $beanPI->accounts_dire_direccion_1->getBeans();
                if(count($relatedDirecciones)>0){
                    $tipos_direccion=array('1','2','3','5','6','7','9','10','11','13','14','15','17','18','19','21','22','23','25','26','27','29','30','31','33','34','35','37','38','39','41','42','43','45','46','47','49','50','51','53','54','55','57','58','59','61','62','63');
                    //$GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene llamadas, forma parte de checklist');
                    foreach($relatedDirecciones as $dir) {
                        if(in_array($dir->indicador,$tipos_direccion)){
                            $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene direccion fiscal o correspondencia');
                            array_push($array_direcciones_fiscal_correspondencia,'1');
                        }
                    }
                }
            }

            if(in_array('1',$array_direcciones_fiscal_correspondencia)){
                array_push($array_respuesta,'fiscal_correspondencia');
            }

            //Obteniendo Relaciones para obtener "Propietario Real"
            $array_propietario_real=array();
            if($beanPI->load_relationship('rel_relaciones_accounts_1')){
                $relatedRelaciones = $beanPI->rel_relaciones_accounts_1->getBeans();
                if(count($relatedRelaciones)>0){
                    //$GLOBALS['log']->fatal('Lead '.$idRegistro.' Tiene llamadas, forma parte de checklist');
                    foreach($relatedRelaciones as $rel) {
                        if(strpos($rel->relaciones_activas,'^Propietario Real^')!=false){
                            $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Propietario Real');
                            array_push($array_propietario_real,'1');
                        }
                    }
                }
            }

            if(in_array('1',$array_propietario_real)){
                array_push($array_respuesta,'propietario_real');
            }

            //Obtener Cuestionario PLD
            $array_pld=array();
            if($beanPI->load_relationship('accounts_tct_pld_1')){
                $relatedPLD = $beanPI->accounts_tct_pld_1->getBeans();
                if(count($relatedPLD)>0){
                    $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Cuestionario PLD');
                    array_push($array_pld,'1'); 
                }
            }

            if(in_array('1',$array_pld)){
                array_push($array_respuesta,'pld');
            }

            //Obteniendo Solicitudes para validar Condición Financiera,Pago Mensual,Pago Único,Scoring Comercial,VoBo del director,
            $array_condicion_financiera=array();
            $array_pago_mensual=array();
            $array_pago_unico=array();
            $array_scoring=array();
            $array_vobo_director=array();
            if($beanPI->load_relationship('opportunities')){
                $relatedSolicitudes= $beanPI->opportunities->getBeans();
                if(count($relatedSolicitudes)>0){
                    foreach($relatedSolicitudes as $sol) {
                        if($sol->estatus_c !='K' && $sol->estatus_c!='R'){
                            
                            if($sol->cf_quantico_c!="" && $sol->cf_quantico_c!=null){
                                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Condicion Financiera');
                                array_push($array_condicion_financiera,'1');
                            }

                            if($sol->ca_pago_mensual_c!="" && $sol->ca_pago_mensual_c!=null){
                                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Pago Mensual');
                                array_push($array_pago_mensual,'1');
                            }

                            if($sol->ca_importe_enganche_c!="" && $sol->ca_importe_enganche_c!=null){
                                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Pago Único');
                                array_push($array_pago_unico,'1');
                            }

                            if($sol->doc_scoring_chk_c==1){
                                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene Scoring Comercial');
                                array_push($array_scoring,'1');
                            }

                            if($sol->vobo_dir_c==1){
                                $GLOBALS['log']->fatal('Cuenta '.$idRegistro.' Tiene VoBo Director');
                                array_push($array_vobo_director,'1');
                            }
                            
                        }
                    }
                }
            }

            if(in_array('1',$array_condicion_financiera)){
                array_push($array_respuesta,'condicion_financiera');
            }
            if(in_array('1',$array_pago_mensual)){
                array_push($array_respuesta,'pago_mensual');
            }
            if(in_array('1',$array_pago_unico)){
                array_push($array_respuesta,'pago_unico');
            }
            if(in_array('1',$array_scoring)){
                array_push($array_respuesta,'scoring_comercial');
            }
            if(in_array('1',$array_vobo_director)){
                array_push($array_respuesta,'vobo_director');
            }

        }

        return $array_respuesta;

    }

    public function getProspectosEstatus($api, $args){

        $equipo=$args['equipo'];
        $equipo_usuario=str_replace("^","'",$equipo);
        global $db,$current_user;

        $posicion_operativa=isset($current_user->posicion_operativa_c) ? $current_user->posicion_operativa_c:'';

        $esRegional= strpos($posicion_operativa, '^2^') !== false ? true:false;

        $array_principal=array();
        $grandTotal=0;
        $totalSinContactar=0;
        $totalContactado=0;
        $totalInteresado=0;
        $totalIntExp=0;
        $totalCredito=0;
        $totalSinOperar=0;
        $totalActivo=0;
        $totalPerdido=0;

        //Obtener los ids de los usuarios pertencientes a $equipo
        $queryUsuarios="SELECT id,concat(u.first_name,' ',u.last_name) nombre_usuario, uc.equipo_c FROM users u
        INNER JOIN users_cstm uc ON u.id=uc.id_c
        WHERE uc.equipo_c IN ({$equipo_usuario}) AND u.status='Active' AND u.deleted=0 ORDER BY nombre_usuario ASC;";

        $resultUsuarios = $db->query($queryUsuarios);

        $array_equipo=array();
        while ($row = $db->fetchByAssoc($resultUsuarios)) {
            
            $id_usuario=$row['id'];
            $total_leads_sin_contactar=0;
            $total_prospectos_contactados=0;
            $total_prospectos_interesados=0;
            $total_prospectos_int_exp=0;
            $total_prospectos_credito=0;
            $total_clientes_linea_sin_operar=0;
            $total_clientes_activos=0;
            $total_clientes_perdidos=0;

            $array_usuario=array(
                "Usuario"=>$row['nombre_usuario']
            );

            
            if(!isset($array_equipo[$row['equipo_c']])){
                $array_equipo[$row['equipo_c']]=array(0,0,0,0,0,0,0,0);   
            }
            

            $queryRegistros = <<<SQL
			SELECT l.id id_registro,
        'Leads' modulo,
        lc.nombre_c nombre,
        lc.apellido_paterno_c apellido,
        lc.nombre_empresa_c nombre_empresa,
        lc.tipo_registro_c tipo_registro,
        lc.subtipo_registro_c subtipo_registro,
        l.assigned_user_id,
        l.date_modified,
        f.id idFav,
        uc.equipo_c
        FROM leads l INNER JOIN leads_cstm lc
        ON l.id=lc.id_c
        LEFT JOIN sugarfavorites f ON l.id = f.record_id and f.deleted=0
        LEFT JOIN users_cstm uc ON uc.id_c='{$id_usuario}'
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
        f.id idFav,
        uc.equipo_c
        FROM accounts a INNER JOIN accounts_cstm ac
        ON a.id=ac.id_c
        LEFT JOIN sugarfavorites f ON a.id = f.record_id and f.deleted=0
        LEFT JOIN users_cstm uc ON uc.id_c='{$id_usuario}'
        WHERE ac.tipo_registro_cuenta_c IN ('1','2','3')
        AND ac.subtipo_registro_cuenta_c IN('1','2','7','8','9')
        -- AND a.assigned_user_id ='{$id_usuario}'
        AND (ac.user_id_c='{$id_usuario}' OR 
			ac.user_id1_c='{$id_usuario}' OR 
            ac.user_id2_c='{$id_usuario}' OR 
            ac.user_id6_c='{$id_usuario}' OR 
            ac.user_id7_c='{$id_usuario}' OR 
            ac.user_id8_c='{$id_usuario}'
		)
        AND a.deleted=0
        -- AND f.deleted=0
        ORDER BY idFav DESC;
SQL;
            $resultRegistros = $db->query($queryRegistros);

            while ($filaRegistros = $db->fetchByAssoc($resultRegistros)) {
                $id=$filaRegistros['id_registro'];
                $tipo=$filaRegistros['tipo_registro'];
                $subtipo=$filaRegistros['subtipo_registro'];
                
                //$grandTotal++;
                
                //Lead sin Contactar
                if($tipo=='1' && $subtipo=='1'){
                    $array_equipo[$filaRegistros['equipo_c']][0]++;
                    $total_leads_sin_contactar++;
                }

                //Prospecto Contactado
                if($tipo=='2' && $subtipo=='2'){
                    $array_equipo[$filaRegistros['equipo_c']][1]++;
                    $total_prospectos_contactados++;
                }

                //Prospecto Interesado
                if($tipo=='2' && $subtipo=='7'){
                    $array_equipo[$filaRegistros['equipo_c']][2]++;
                    $total_prospectos_interesados++;
                }

                //Prospecto Integración de Expediente
                if($tipo=='2' && $subtipo=='8'){
                    $array_equipo[$filaRegistros['equipo_c']][3]++;
                    $total_prospectos_int_exp++;
                }

                //Prospecto en Crédito
                if($tipo=='2' && $subtipo=='9'){
                    $array_equipo[$filaRegistros['equipo_c']][4]++;
                    $total_prospectos_credito++;
                }

                 //Sección de Clientes (Cliente con linea sin operar, Cliente Activo, Cliente Perdido)
                if($tipo=='3' && $subtipo!='3' && $subtipo!='10' && $subtipo!='15' && $subtipo!='17'){
                    //Subtipo -- 3:Cancelado, 10:Rechazado, 15:Inactivo, 17:Perdido
                    $beanCliente = BeanFactory::getBean('Accounts', $id, array('disable_row_level_security' => true));
                    if($beanCliente->load_relationship('accounts_uni_productos_1')){
                        $producto_usuario=$current_user->tipodeproducto_c;
                        $array_es_cliente_linea_sin_operar=array();
                        $array_es_cliente_activo=array();
                        $array_es_cliente_perdido=array();
                    
                        $relatedProductos = $beanCliente->accounts_uni_productos_1->getBeans();
                        if(count($relatedProductos)>0){
                            foreach($relatedProductos as $prod) {
                                if($prod->tipo_producto==$producto_usuario){
                                    //Cliente con linea sin operar
                                    if($prod->registros_activos_c=='' && $prod->registros_historicos_c==''){
                                        array_push($array_es_cliente_linea_sin_operar,'1');
                                    }
        
                                    //Cliente Activo
                                    if($prod->registros_activos_c!=''){
                                        array_push($array_es_cliente_activo,'1');
                                    }
        
                                    //Cliente Perdido
                                    if($prod->registros_activos_c=='' && $prod->registros_historicos_c!='' ){
                                        array_push($array_es_cliente_perdido,'1');
                                    }
                                }
                            }
                        }

                        //Cliente con linea sin operar
                        if(in_array('1',$array_es_cliente_linea_sin_operar)){
                            $array_equipo[$filaRegistros['equipo_c']][5]++;
                            $total_clientes_linea_sin_operar++;
                        }

                        //Cliente Activo
                        if(in_array('1',$array_es_cliente_activo)){
                            $array_equipo[$filaRegistros['equipo_c']][6]++;
                            $total_clientes_activos++;
                        }

                        //Cliente Perdido
                        if(in_array('1',$array_es_cliente_perdido)){
                            $array_equipo[$filaRegistros['equipo_c']][7]++;
                            $total_clientes_perdidos++;   
                        }
                    }
                }


            }//Termina while obtencion de registros por usuario

            $array_usuario["Registros"]=array(
                $total_leads_sin_contactar,
                $total_prospectos_contactados,
                $total_prospectos_interesados,
                $total_prospectos_int_exp,
                $total_prospectos_credito,
                $total_clientes_linea_sin_operar,
                $total_clientes_activos,
                $total_clientes_perdidos
            );

            $total_asignados=$total_leads_sin_contactar + $total_prospectos_contactados + $total_prospectos_interesados + $total_prospectos_int_exp + $total_prospectos_credito + $total_clientes_linea_sin_operar + $total_clientes_activos + $total_clientes_perdidos;

            $array_usuario["TotalAsignados"]=$total_asignados;

            $grandTotal+=$total_asignados;

            $totalSinContactar += $total_leads_sin_contactar;
            $totalContactado += $total_prospectos_contactados;
            $totalInteresado += $total_prospectos_interesados;
            $totalIntExp += $total_prospectos_int_exp;
            $totalCredito += $total_prospectos_credito;
            $totalSinOperar += $total_clientes_linea_sin_operar;
            $totalActivo += $total_clientes_activos;
            $totalPerdido += $total_clientes_perdidos;

            array_push($array_principal,$array_usuario);

        }//Termina while de obtención de Usuarios

        if($esRegional){
            $array_principal=array();
            foreach ($array_equipo as $key => $value) {
                $array_principal[]=array("Registros"=>$value,"Usuario"=>$key,"TotalAsignados"=>$total_asignados);
            }
        }

        $array_principal["Total"]=$grandTotal;
        $array_principal["TotalSinContactar"]=$totalSinContactar;
        $array_principal["TotalContactado"]=$totalContactado;
        $array_principal["TotalInteresado"]=$totalInteresado;
        $array_principal["TotalIntExp"]=$totalIntExp;
        $array_principal["TotalCredito"]=$totalCredito;
        $array_principal["TotalSinOperar"]=$totalSinOperar;
        $array_principal["TotalActivo"]=$totalActivo;
        $array_principal["TotalPerdido"]=$totalPerdido;
        
        return $array_principal;

    }

}

?>
