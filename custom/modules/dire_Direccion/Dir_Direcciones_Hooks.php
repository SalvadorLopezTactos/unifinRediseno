<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/15/2015
 * Time: 12:22 PM
 */
require_once("custom/Levementum/UnifinAPI.php");
class Dir_Direcciones_Hooks{

    public function eliminaDireccionenUNICS($bean=null,$event=null,$args=null)
    {
        try
        {
            global $db, $current_user;
            $cliente = false;

        $query = <<<SQL
SELECT idcliente_c, sincronizado_unics_c FROM accounts_cstm
WHERE id_c = '{$bean->accounts_dire_direccion_1accounts_ida}'
SQL;

            $queryResult = $db->query($query);
            while ($row = $db->fetchByAssoc($queryResult)) {
                if (!empty($row['idcliente_c']) && $row['idcliente_c'] > 0 && $row['idcliente_c'] != '' && $row['sincronizado_unics_c'] == '1') {
                    $cliente = true;
                }
            }

            if($cliente == true) {
                $callApi = new UnifinAPI();
                $direccion = $callApi->eliminaDireccion($bean);
            }
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function insertarDireccionenUNICS($bean=null,$event=null,$args=null)
    {
        try
        {
            global $db, $current_user;
            $cliente = false;

        $query = <<<SQL
SELECT idcliente_c, sincronizado_unics_c FROM accounts_cstm
WHERE id_c = '{$bean->accounts_dire_direccion_1accounts_ida}'
SQL;

            $queryResult = $db->query($query);
            while ($row = $db->fetchByAssoc($queryResult)) {
                if (!empty($row['idcliente_c']) && $row['idcliente_c'] > 0 && $row['idcliente_c'] != '' && $row['sincronizado_unics_c'] == '1') {
                    $cliente = true;
                }
            }

            if($cliente == true) {
                $callApi = new UnifinAPI();
                //only for new records
                //if ($_SESSION['estado'] == 'insertando') {
				if ($bean->sincronizado_unics_c == '0') {
                    $direccion = $callApi->insertaDireccion($bean);
                    $_SESSION['estado'] = '';
                } else {
                    $direccion = $callApi->actualizaDireccion($bean);
                    $_SESSION['estado'] = '';
                }
            }
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function detectaEstado ($bean = null, $event = null, $args = null){
        global $current_user;
        if (empty($bean->fetched_row['id'])) {
            $_SESSION['estado'] = 'insertando';
        }else{
            $_SESSION['estado'] = 'actualizando';
        }
        $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : ESTADO: $_SESSION[estado] ");
    }

    public function textToUppperCase($bean = null, $event = null, $args = null){
        foreach($bean as $field=>$value){
            if($bean->field_defs[$field]['type'] == 'varchar'){
                $value = mb_strtoupper($value,"UTF-8");
                $bean->$field = $value;
            }
            if($bean->field_defs[$field]['name'] == 'name'){
                $value = mb_strtoupper($value, "UTF-8");
                $bean->$field = $value;
            }
        }
    }

    public function setSequencia($bean = null, $event = null, $args = null){

        global $db;
        $query = <<<SQL
SELECT IF(MAX(secuencia) is null, 0, MAX(secuencia)) secuencia FROM dire_direccion
LEFT JOIN accounts_dire_direccion_1_c ON accounts_dire_direccion_1_c.accounts_dire_direccion_1dire_direccion_idb = dire_direccion.id
WHERE accounts_dire_direccion_1_c.accounts_dire_direccion_1accounts_ida = '{$bean->accounts_dire_direccion_1accounts_ida}'
SQL;
        $queryResult = $db->getOne($query);
        if($bean->accounts_dire_direccion_1accounts_ida != null && empty($bean->secuencia)){
            $bean->secuencia = 0;
            $total = $queryResult + 1;
            $bean->secuencia = $total;
        }

    }

    public function setConcatName($bean = null, $event = null, $args = null){


        $calle=$bean->calle;
        $numext=$bean->numext;
        $numint=$bean->numint;
        $colonia=$bean->dire_direccion_dire_colonia_name;
        if($colonia==null){
            $id_colonia=$bean->dire_direccion_dire_coloniadire_colonia_ida;

            $nombre_colonia_query = "Select name from dire_colonia where id ='". $id_colonia."'";
            $querycolonia = $GLOBALS['db']->query($nombre_colonia_query);
            $coloniaName = $GLOBALS['db']->fetchByAssoc($querycolonia);
            $colonia=$coloniaName['name'];

        }
        $municipio=$bean->dire_direccion_dire_municipio_name;
        if($municipio==null){
            $id_municipio=$bean->dire_direccion_dire_municipiodire_municipio_ida;

            $nombre_municipio_query = "Select name from dire_municipio where id ='". $id_municipio."'";
            $querymunicipio = $GLOBALS['db']->query($nombre_municipio_query);
            $municipioName = $GLOBALS['db']->fetchByAssoc($querymunicipio);
            $municipio=$municipioName['name'];
        }

        $direccion_completa =$calle." ".$numext." ".($numint != "" ? "Int: ".$numint:""). ", Colonia ".$colonia.", Municipio ".$municipio;

        $bean->name=$direccion_completa;

    }

    public function setValoresPorActualizar($bean = null, $event = null, $args = null){
        $indicador = $bean->indicador;
        $send_notification = false;
        $cambio_dirFiscal =  false;

        $indicador_direcciones_fiscales = array(2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63);
        if( in_array($indicador,$indicador_direcciones_fiscales) ){
            
            if( $bean->valid_cambio_razon_social_c == 1 ){
                //Se envía excepción en caso de que el registro se encuentre en proceso de validación
                require_once 'include/api/SugarApiException.php';
                $GLOBALS['log']->fatal("No es posible generar cambios en la dirección fiscal ya que se encuentra en un proceso de revisión");
                throw new SugarApiExceptionInvalidParameter("No es posible generar cambios en la dirección fiscal ya que se encuentra en un proceso de revisión");
            }else{
                $GLOBALS['log']->fatal("FEETCHED");
                $GLOBALS['log']->fatal(print_r($bean->fetched_row,true));

                $GLOBALS['log']->fatal("FEETCHED RELATED");
                $GLOBALS['log']->fatal(print_r($bean->rel_fields_before_value,true));

                $GLOBALS['log']->fatal("ARGS DATACHANGED");
                $GLOBALS['log']->fatal(print_r($args,true));

                $cp_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_codigopostaldire_codigopostal_ida');
                $cp_por_actualizar = $bean->dire_direccion_dire_codigopostaldire_codigopostal_ida;
                $pais_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_paisdire_pais_ida');
                $pais_por_actualizar = $bean->dire_direccion_dire_paisdire_pais_ida;
                $estado_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_estadodire_estado_ida');
                $estado_por_actualizar = $bean->dire_direccion_dire_estadodire_estado_ida;
                $municipio_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_municipiodire_municipio_ida');
                $municipio_por_actualizar = $bean->dire_direccion_dire_municipiodire_municipio_ida;
                $ciudad_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_ciudaddire_ciudad_ida');
                $ciudad_por_actualizar = $bean->dire_direccion_dire_ciudaddire_ciudad_ida;
                $colonia_actual = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_coloniadire_colonia_ida');
                $colonia_por_actualizar = $bean->dire_direccion_dire_coloniadire_colonia_ida;
                $calle_actual = $bean->fetched_row['calle'];
                $calle_por_actualizar = $bean->calle;
                $numext_actual = $bean->fetched_row['numext'];
                $numext_por_actualizar = $bean->numext;
                $numint_actual = $bean->fetched_row['numint'];
                $numint_por_actualizar = $bean->numint;
                $fecha_cambio = "";

                //Armando direccion completa actual
                $current_cp = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_codigopostal_name');
                $current_pais = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_pais_name');
                $current_estado = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_estado_name');
                $current_municipio = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_municipio_name');
                $current_ciudad = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_ciudad_name');
                $current_colonia = $this->fetched_row_related($bean->rel_fields_before_value,'dire_direccion_dire_colonia_name');
                $full_direccion_actual = "Calle: ". $calle_actual .", CP: ". $current_cp .", País: ". $current_pais .", Estado: ". $current_estado .", Municipio: ". $current_municipio .", Ciudad: ". $current_ciudad .", Colonia: ". $current_colonia .", Número exterior: ". $numext_actual .", Número interior: ".$numint_actual;

                //Armando direccion completa por actualizar
                $cp_act = $bean->dire_direccion_dire_codigopostal_name;
                $pais_act = $bean->dire_direccion_dire_pais_name;
                $estado_act = $bean->dire_direccion_dire_estado_name;
                $municipio_act = $bean->dire_direccion_dire_municipio_name;
                $ciudad_act = $bean->dire_direccion_dire_ciudad_name;
                $colonia_act = $bean->dire_direccion_dire_colonia_name;
                $full_direccion_por_actualizar = "Calle: ". $calle_por_actualizar .", CP: ". $cp_act .", País: ". $pais_act .", Estado: ". $estado_act .", Municipio: ". $municipio_act .", Ciudad: ". $ciudad_act .", Colonia: ". $colonia_act .", Número exterior: ". $numext_por_actualizar .", Número interior: ".$numint_por_actualizar;

                if( $cp_actual !== $cp_por_actualizar ){
                    $GLOBALS['log']->fatal("Código Postal ID cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $cp_por_actualizar = $bean->dire_direccion_dire_codigopostaldire_codigopostal_ida;
                }

                if( $pais_actual !== $pais_por_actualizar ){
                    $GLOBALS['log']->fatal("País cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $pais_por_actualizar = $bean->dire_direccion_dire_paisdire_pais_ida;
                }

                if( $estado_actual !== $estado_por_actualizar ){
                    $GLOBALS['log']->fatal("Estado cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $estado_por_actualizar = $bean->dire_direccion_dire_estadodire_estado_ida;
                }

                if( $municipio_actual !== $municipio_por_actualizar ){
                    $GLOBALS['log']->fatal("Municipio cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $municipio_por_actualizar = $bean->dire_direccion_dire_municipiodire_municipio_ida;
                }

                if( $ciudad_actual !== $ciudad_por_actualizar ){
                    $GLOBALS['log']->fatal("Ciudad cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $ciudad_por_actualizar = $bean->dire_direccion_dire_ciudaddire_ciudad_ida;
                }

                if( $colonia_actual !== $colonia_por_actualizar ){
                    $GLOBALS['log']->fatal("Colonia cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $colonia_por_actualizar = $bean->dire_direccion_dire_coloniadire_colonia_ida;
                }

                if( $bean->fetched_row['calle'] !== $bean->calle ){
                    $GLOBALS['log']->fatal("Calle cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $calle_por_actualizar = $bean->calle;
                }

                if( $bean->fetched_row['numext'] !== $bean->numext ){
                    $GLOBALS['log']->fatal("Num Ext cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $numext_por_actualizar = $bean->numext;
                }

                if( $bean->fetched_row['numint'] !== $bean->numint ){
                    $GLOBALS['log']->fatal("Num Int cambió");
                    $send_notification = true;
                    $cambio_dirFiscal = true;
                    $numint_por_actualizar = $bean->numint;
                }

                $source = $_REQUEST['__sugar_url'];
                $endpoint = 'AprobarCambiosRazonSocialDireFiscal';
                //$pos - controlar el origen desde donde se dispara el guardado del registro (desde api custom ó desde el guardado normal directo en el registro)
                $pos = strpos($source,$endpoint);
                if( $send_notification && $pos == false ){
                    
                    $plataforma = $_SESSION['platform'];
                    $fecha_cambio = TimeDate::getInstance()->nowDb();
                    
                    //Habilita bandera para indicar que el registro se encuentra en proceso de validación
                    $bean->valid_cambio_razon_social_c = 1;
                    $bean->cambio_direccion_c = 1;

                    $json_audit = $this->buildJsonAudit($bean->id,$cp_actual,$cp_por_actualizar,$pais_actual,$pais_por_actualizar,$estado_actual,$estado_por_actualizar,$municipio_actual,$municipio_por_actualizar,$ciudad_actual,$ciudad_por_actualizar,$colonia_actual,$colonia_por_actualizar,$calle_actual,$calle_por_actualizar,$numext_actual,$numext_por_actualizar,$numint_actual,$numint_por_actualizar,$full_direccion_actual,$full_direccion_por_actualizar,$fecha_cambio,$plataforma);

                    $GLOBALS['log']->fatal("json audit direccion");
                    $GLOBALS['log']->fatal(print_r($json_audit,true));
                    $bean->json_audit_c = $json_audit;


                    $this->revierteValores($bean,$cp_actual,$pais_actual,$estado_actual,$municipio_actual,$ciudad_actual,$colonia_actual);

                    //Actualiza bandera de la cuenta relacionada
                    $this->setCheckEnvioMsjCuenta( $bean->accounts_dire_direccion_1accounts_ida );

                }
            }
        }
    }

    public function fetched_row_related( $arreglo_cambios, $nombre_campo){

        return $arreglo_cambios[$nombre_campo];
    }

    public function buildJsonAudit( $id_direccion,$cp_actual,$cp_por_actualizar,$pais_actual,$pais_por_actualizar,$estado_actual,$estado_por_actualizar,$municipio_actual,$municipio_por_actualizar,$ciudad_actual,$ciudad_por_actualizar,$colonia_actual,$colonia_por_actualizar,$calle_actual,$calle_por_actualizar,$numext_actual,$numext_por_actualizar,$numint_actual,$numint_por_actualizar,$full_direccion_actual,$full_direccion_por_actualizar,$fecha_cambio,$plataforma ){

        $json_audit_direccion='{
            "id_direccion":"'. $id_direccion . '",
            "cp_actual":"'. $cp_actual . '",
            "cp_por_actualizar":"'. $cp_por_actualizar . '",
            "pais_actual":"'. $pais_actual . '",
            "pais_por_actualizar":"'. $pais_por_actualizar . '",
            "estado_actual":"'. $estado_actual . '",
            "estado_por_actualizar":"'. $estado_por_actualizar . '",
            "municipio_actual":"'. $municipio_actual . '",
            "municipio_por_actualizar":"'. $municipio_por_actualizar . '",
            "ciudad_actual":"'. $ciudad_actual . '",
            "ciudad_por_actualizar":"'. $ciudad_por_actualizar . '",
            "colonia_actual":"'. $colonia_actual . '",
            "colonia_por_actualizar":"'. $colonia_por_actualizar . '",
            "calle_actual":"'. $calle_actual . '",
            "calle_por_actualizar":"'. $calle_por_actualizar . '",
            "numext_actual":"'. $numext_actual . '",
            "numext_por_actualizar":"'. $numext_por_actualizar . '",
            "numint_actual":"'. $numint_actual . '",
            "numint_por_actualizar":"'. $numint_por_actualizar . '",
            "direccion_completa_actual":"'. $full_direccion_actual . '",
            "direccion_completa_por_actualizar":"'. $full_direccion_por_actualizar . '",
            "fecha_cambio":"'. $fecha_cambio .'",
            "plataforma":"'. $plataforma .'"
        }';

        return $json_audit_direccion;

    }

    public function revierteValores( $bean,$cp_actual,$pais_actual,$estado_actual,$municipio_actual,$ciudad_actual,$colonia_actual ){

        $bean->name = $bean->fetched_row['name'];
        $bean->dire_direccion_dire_codigopostaldire_codigopostal_ida = $bean->fetched_rel_row['dire_direccion_dire_codigopostaldire_codigopostal_ida'];
        //$bean->dire_direccion_dire_codigopostal_name = $bean->rel_fields_before_value['dire_direccion_dire_codigopostal_name'];
        
        $bean->dire_direccion_dire_paisdire_pais_ida = $pais_actual;
        $bean->dire_direccion_dire_pais_name = $bean->rel_fields_before_value['dire_direccion_dire_pais_name'];
        
        $bean->dire_direccion_dire_estadodire_estado_ida = $estado_actual;
        $bean->dire_direccion_dire_estado_name = $bean->rel_fields_before_value['dire_direccion_dire_estado_name'];
        
        $bean->dire_direccion_dire_municipiodire_municipio_ida = $municipio_actual;
        $bean->dire_direccion_dire_municipio_name = $bean->rel_fields_before_value['dire_direccion_dire_municipio_name'];
        
        $bean->dire_direccion_dire_ciudaddire_ciudad_ida = $ciudad_actual;
        $bean->dire_direccion_dire_ciudad_name = $bean->rel_fields_before_value['dire_direccion_dire_ciudad_name'];
        
        $bean->dire_direccion_dire_coloniadire_colonia_ida = $colonia_actual;
        $bean->dire_direccion_dire_colonia_name = $bean->rel_fields_before_value['dire_direccion_dire_colonia_name'];

        $bean->calle = $bean->fetched_row['calle'];
        $bean->numext = $bean->fetched_row['numext'];
        $bean->numint = $bean->fetched_row['numint'];

    }

    public function setCheckEnvioMsjCuenta( $idCuenta ){

        if( $idCuenta !== "" && $idCuenta !== null ){
            $GLOBALS['log']->fatal('Actualiza bandera de la cuenta relacionada');
            $queryUpdate = "UPDATE accounts_cstm SET enviar_mensaje_c = '1' WHERE id_c = '{$idCuenta}'";
            $GLOBALS['db']->query($queryUpdate);
        }
        
    }
}