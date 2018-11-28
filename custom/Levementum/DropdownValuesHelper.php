<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 6/30/2015
 * Time: 7:26 PM
 */

class DropdownValuesHelper{

    public function getTipodepersonaInt ($stringValue){
        global $current_user;
        try
        {
            if($stringValue == 'Persona Fisica'){
                $RegimenFiscal = 1;
            }elseif($stringValue == 'Persona Fisica con Actividad Empresarial'){
                $RegimenFiscal = 2;
            }elseif($stringValue == 'Persona Moral'){
                $RegimenFiscal = 3;
            }

            if(isset($RegimenFiscal)) {
                return $RegimenFiscal;
            }
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function getEstadoCivilInt($stringValue){
    global $current_user;
        try
        {
            if($stringValue == 'Sin Regimen Conyugal'){
                $RegimenConyugal = 0;
            }
            if($stringValue == 'Casado'){
                $RegimenConyugal = 1;
            }
            if($stringValue == 'Soltero'){
                $RegimenConyugal = 2;
            }
            if($stringValue == 'Divorciado'){
                $RegimenConyugal = 3;
            }
            if($stringValue == 'Viudo'){
                $RegimenConyugal = 4;
            }
            if($stringValue == 'Union Libre'){
                $RegimenConyugal = 5;
            }
            if($stringValue == 'Separado'){
                $RegimenConyugal = 6;
            }

            if(isset($RegimenConyugal)){
                return $RegimenConyugal;
            }
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function getTipoCliente($stringValue, $stringStatus = 'Interesado', $EsProveedor = 0, $Relaciones = 'Contacto',$cedente, $deudor){
    try
        {
            //$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <czaragoza> : Antes cedente: " . $cedente. " deudor: " . $deudor);
            $cedente = $cedente==1?32:0;
            $deudor = $deudor==1?64:0;
            $EsProveedor = $EsProveedor==1?2:0;
    	switch ($stringValue){
      /*
        AF - 2018-08-15
        Modificación para establecer Mismas validación en Prospecto a Cliente
      */
			case 'Prospecto':
				//$tipoCliente = ($stringStatus == 'Interesado' ? 1 : 0);
        $tipoCliente = 1 + $EsProveedor; //($EsProveedor == 1 ? 3 : 1);
                $tipoCliente = $tipoCliente + ($cedente + $deudor);
				break;
			case 'Cliente':
			 	$tipoCliente = 1 + $EsProveedor; ($EsProveedor == 1 ? 3 : 1);
                $tipoCliente = $tipoCliente + ($cedente + $deudor);
                //$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <czaragoza> : cedente: " . $cedente. " deudor: " . $deudor);
                //$GLOBALS['log']->fatal(__CLASS__ . "->" . __FUNCTION__ . " <czaragoza> : Tipo Cliente: " . $tipoCliente);
                break;
			case 'Proveedor':
				if ($cedente > 1 || $deudor > 1 ){
                    $tipoCliente = $cedente + $deudor;
                }
                $tipoCliente= $tipoCliente + $EsProveedor;
				break;
			case 'Persona':
				if ($cedente > 1 || $deudor > 1 || $EsProveedor > 1){
					 $tipoCliente = $cedente + $deudor + $EsProveedor;
				}else{
					$tipoCliente = 0;
					/*
					$listTipoRelacion = split(",", $Relaciones);
					foreach($listTipoRelacion as $Relacion){
						$IdTipoRelacion = $this->getIdTipoRelacion(str_replace('^', '', $Relacion));
						$tipoCliente = $tipoCliente + ($IdTipoRelacion != 0 ?  $IdTipoRelacion : 0);
					}
					//Si no hubo relaciones en UNICS
					$tipoCliente = ($tipoCliente == 0 ? 2048 :  $tipoCliente);
					*/
				}
				break;
            default:
                $tipoCliente = 0;
		}
	if(isset($tipoCliente)) {
        return $tipoCliente;
	}else{
                return "";
            }

        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error ".$e->getMessage());
        }
    }

    public function getEstadoId($IdtoSanitize){

        $IdtoSanitize = substr($IdtoSanitize, -3, 3);
        return $IdtoSanitize;
    }

    public function getMunicipioId($IdtoSanitize){

        $IdtoSanitize = substr($IdtoSanitize, -3, 3);
        return $IdtoSanitize;
    }

    public function getCiudadId($IdtoSanitize){

        $IdtoSanitize = substr($IdtoSanitize, -5, 5);
        return $IdtoSanitize;
    }

    public function getCodigoPostalId($IdtoSanitize){

        $IdtoSanitize = substr($IdtoSanitize, -5, 5);
        return $IdtoSanitize;
    }

	/***CVV INICIO***/
    public function getUserName($Id){
		global $db;
		$query = <<<SQL
SELECT user_name FROM users where id = '{$Id}'
SQL;
		$queryResult = $db->getOne($query);
        return $queryResult;
    }
	/***CVV FIN***/
    /*** ALI INICIO ***/
    public function getIdTipoRelacion($descRelacion){
        switch ($descRelacion) {
            case 'Aval': $IdTipoRelacion = 4; break;
            case 'Fiador': $IdTipoRelacion = 128; break;
            case 'Depositario': $IdTipoRelacion = 256; break;
            case 'Representante': $IdTipoRelacion = 1024; break;
            case 'Contacto': $IdTipoRelacion = 2048; break;
            case 'Directivo': $IdTipoRelacion = 4096; break;
            case 'Accionista': $IdTipoRelacion = 8192; break;
            case 'Conyuge': $IdTipoRelacion = 16384; break;
            case 'Obligado solidario': $IdTipoRelacion = 32768; break;
            case 'Coacreditado': $IdTipoRelacion = 65536; break;
            case 'Referencia Personal': $IdTipoRelacion = 4; break;
            case 'Referencia Cliente': $IdTipoRelacion = 4; break;
            case 'Referencia Proveedor': $IdTipoRelacion = 4; break;
            case '': $IdTipoRelacion = 0; break;
            default:
                $IdTipoRelacion = 0; break;
        }
        return $IdTipoRelacion;
    }

    public function getIdTipoContacto($descContacto){
        $tipo_contactos = str_replace('^','',$descContacto);
        $arreglo = explode(',', $tipo_contactos);
        $IdTipoContacto = 0;
        $suma=0;
        foreach ($arreglo as $key => $value) {
            switch ($value) {
                case 'Promocion': $IdTipoContacto = 1; break;
                case 'Cobranza': $IdTipoContacto = 2; break;
                case 'Administracion': $IdTipoContacto = 4; break;
                case 'Entrega de bienes': $IdTipoContacto = 16; break;
                case 'Factoraje': $IdTipoContacto = 8; break;
                case 'FirmanteVR': $IdTipoContacto = 32; break;
                case '': $IdTipoContacto = 0; break;
                default:
                    $IdTipoContacto = 1;
            }
            $suma = $suma + $IdTipoContacto;
        }
        return $suma;

    }

    /*** ALI FIN ***/

    public function matchListLabel($db_val, $lista){
        global $app_list_strings;
        $list = array();
        if (isset($app_list_strings[$lista]))
        {
            $list = $app_list_strings[$lista];
        }
        foreach($list as $key=>$value){
            if($key == $db_val){
                $match_val = $value;
            }
        }
        if($match_val != ''){
            return $match_val;
        }else{
            return $db_val;
        }
    }
}
