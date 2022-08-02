<?php

/**
 * Created by Tactos.
 * User: JG
 * Date: 26/12/19
 * Time: 10:15 AM
 */
class leads_validateString
{

    public function textToUppperCase($bean = null, $event = null, $args = null)
    {
        //$GLOBALS['log']->fatal('CONVIERTO A MAYUSCULAS');
        $moduleRequest = isset($_REQUEST['module']) ? $_REQUEST['module'] : '';
        if ($moduleRequest != 'Import') {
            foreach ($bean as $field => $value) {
                $fieldName = isset($bean->field_defs[$field]['name']) ? $bean->field_defs[$field]['name'] : '';
                $fieldType = isset($bean->field_defs[$field]['type']) ? $bean->field_defs[$field]['type'] : '';
                if ($fieldName != 'nombre_de_cargar_c' && $fieldName != 'resultado_de_carga_c') {

                    if ($fieldType == 'varchar') {
                        $value = mb_strtoupper($value, "UTF-8");
                        $bean->$field = $value;
                    }
                    if ($fieldName == 'name') {
                        $value = mb_strtoupper($value, "UTF-8");
                        $bean->$field = $value;
                    }
                }
            }
        }

        //Validación de PM - Nombre empresa
        if ($bean->regimen_fiscal_c == '3' && !empty($bean->nombre_c) && empty($bean->nombre_empresa_c)) {
            $bean->nombre_empresa_c = $bean->nombre_c;
            $bean->name_c = $bean->nombre_c;
            $bean->nombre_c = '';
        }
    }


    public function quitaespacios($bean = null, $event = null, $args = null)
    {
        // $GLOBALS['log']->fatal('QUITO ESPACIOS Y REEMPLAZO POR NUEVOS VALORES');

        global $db;
        global $app_list_strings, $current_user; //Obtención de listas de valores
        $idCuenta = $bean->id;
        //$GLOBALS['log']->fatal('Limpia espacios');
        //Se crean variables que limpien los excesos de espacios en los campos establecidos.
        $limpianame = preg_replace('/\s\s+/', ' ', $bean->fullname); // PENDIENTE
        $limpianombre = preg_replace('/\s\s+/', ' ', $bean->nombre_c);
        $limpiaapaterno = preg_replace('/\s\s+/', ' ', $bean->apellido_paterno_c);
        $limpiamaterno = preg_replace('/\s\s+/', ' ', $bean->apellido_materno_c);
        $limpiarazon = preg_replace('/\s\s+/', ' ', $bean->nombre_empresa_c); # prendiente
        //$limpianomcomercial= preg_replace('/\s\s+/', ' ', $bean->nombre_empresa_c);

        //Actualiza valores limpios a los campos de la Cuenta
        $bean->fullname = $limpianame;
        $bean->nombre_c = $limpianombre;
        $bean->apellido_paterno_c = $limpiaapaterno;
        $bean->apellido_materno_c = $limpiamaterno;
        $bean->nombre_empresa_c = $limpiarazon;

        //Consumir servicio de cleanName, declarado en custom api
        require_once("custom/clients/base/api/cleanName.php");
        $apiCleanName= new cleanName();
        $body=array('name'=>$bean->last_name); //Se identificó que sobre el campo last_name se concatena el nombre del lead
        $response=$apiCleanName->getCleanName(null,$body);
        if ($response['status']=='200') {
            $bean->clean_name_c = $response['cleanName'];
        }
    }


    public function ExistenciaEnCuentas($bean = null, $event = null, $args = null)
    {
        $idPadre = "";

        $servicio= isset($GLOBALS['service']->platform)?$GLOBALS['service']->platform:"base";

        //$GLOBALS['log']->fatal("servicio",$servicio);
        if ($servicio== "base" || $servicio == "mobile") {

            // omitir si el leads es cancelado no se haga nada o si ya esta convertido se brinca la validación
            if ($bean->subtipo_registro_c != 3 && $bean->subtipo_registro_c != 4 && $bean->homonimo_c==0 && $bean->omite_match_c==0) {

                $idPadre = $this->createCleanName($bean->leads_leads_1_name);
                //$GLOBALS['log']->fatal("cOMIENZA A vALIDAR dUPLICADO ");
                //$GLOBALS['log']->fatal("para moral " . $bean->clean_name_c);
                //$GLOBALS['log']->fatal("para id " . $bean->id);
                $exprNumerica = "/^[0-9]*$/";
                /**********************VALIDACION DE CAMPOS PB ID Y DUNS ID DEBEN SER NUMERICOS*********************/
                if (!preg_match($exprNumerica, $bean->pb_id_c)) {

                    $bean->pb_id_c = "";
                }
                if (!preg_match($exprNumerica, $bean->duns_id_c)) {

                    $bean->duns_id_c = "";
                }

                //$duplicateproductMessageAccounts = 'Ya existe una cuenta con la misma información';
                /*
                $sql = new SugarQuery();
                $sql->select(array('id', 'clean_name'));
                $sql->from(BeanFactory::newBean('Accounts'), array('team_security' => false));
                $sql->where()->queryAnd()->equals('clean_name',$bean->clean_name_c)->notEquals('id', $bean->id);
                */
                //$sql->where()->equals('clean_name', $bean->clean_name_c);
                //$sql->where()->notEquals('id', $bean->id);

                $query = "SELECT lc.id_c, lc.clean_name_c FROM leads_cstm lc JOIN leads l
                on l.id = lc.id_c WHERE lc.clean_name_c = '{$bean->clean_name_c}'
                AND lc.id_c <> '{$bean->id}' AND l.deleted =0";
                $results = $GLOBALS['db']->query($query);

                //$result = $sql->execute();
                //$count = count($result);
                $count = $results->num_rows;
                //$GLOBALS['log']->fatal("pcount" . $count);
                /************SUGARQUERY PARA VALIDAR IMPORTACION DE REGISTROS SI TIENEN IGUAL LOS MISMOS VALORES DE CLEAN_NAME O PB_ID O DUNS_ID*********/
                $duplicateproductMessageLeads = 'El registro que intentas guardar ya existe como Lead/Cuenta.';
                $sqlLead = new SugarQuery();
                $sqlLead->select(array('id', 'clean_name_c', 'pb_id_c', 'duns_id_c'));
                $sqlLead->from(BeanFactory::newBean('Leads'), array('team_security' => false));
                $sqlLead->where()->equals('homonimo_c', 0);
                $sqlLead->where()
                    ->queryOr()
                    ->equals('clean_name_c', $bean->clean_name_c)
                    ->equals('pb_id_c', $bean->pb_id_c)
                    ->equals('duns_id_c', $bean->duns_id_c);
                $sqlLead->where()->notEquals('id', $bean->id);
                $resultLead = $sqlLead->execute();
                // $GLOBALS['log']->fatal("Result SugarQuery Lead " . print_r($resultLead));
                $countLead = count($resultLead);
                //Get the Name of the account
               // $Leadone = $resultLead[0];

                $idExistenteLead = $countLead>0? $resultLead[0]['id']:"";

                //$GLOBALS['log']->fatal("c---- " . $countLead . "  " . $count);
                if ($count > 0 || $countLead > 0) {
                    if ($_REQUEST['module'] != 'Import') {

                        throw new SugarApiExceptionInvalidParameter($duplicateproductMessageLeads);

                    } else {
                        $bean->deleted = 1;
                        $bean->resultado_de_carga_c = 'Registro Duplicado';

                        if ($countLead > 0 && $bean->leads_leads_1_name != "" && $idExistenteLead != "" && $idPadre != "") {
                            // recuerpara el id del lead existente
                            // actualizarlo y agregra el id padre
                            // $bean->leads_leads_1leads_ida="id padre recuperado";
                            // getbeand y  save
                            $GLOBALS['log']->fatal('Registro duplicado en importacion ' . $idExistenteLead);

                            $beanLeadExist = BeanFactory::retrieveBean('Leads', $idExistenteLead, array('disable_row_level_security' => true));
                            $beanLeadExist->leads_leads_1leads_ida = $idPadre;
                            $beanLeadExist->leads_leads_1_name = $bean->leads_leads_1_name;
                            $beanLeadExist->save();
                        }
                    }

                } else {
                    $bean->resultado_de_carga_c = 'Registro Exitoso';
                    $bean->leads_leads_1leads_ida = $idPadre != "" ? $idPadre : "";

                }
                $fechaCarga = date("Ymd");
                //$GLOBALS['log']->fatal("fecha hoy ". $fechaCarga . " valor campo ". $bean->nombre_de_cargar_c);
                $requestModule = isset($_REQUEST['module']) ? $_REQUEST['module'] : '';
                $bean->nombre_de_cargar_c = ($bean->nombre_de_cargar_c == "" && $requestModule == 'Import') ? "Carga_" . $fechaCarga : $bean->nombre_de_cargar_c;
            }
        }
    }
    public function createCleanName($nameCuenta)
    {
        global $db;
        $cleanName = '';
        //Consumir servicio de cleanName, declarado en custom api
        require_once("custom/clients/base/api/cleanName.php");
        $apiCleanName= new cleanName();
        $body=array('name'=>$nameCuenta); //Se identificó que sobre el campo last_name se concatena el nombre del lead
        $response=$apiCleanName->getCleanName(null,$body);
        if ($response['status']=='200') {
            $cleanName = $response['cleanName'];
        }

        $sqlLead = new SugarQuery();
        $sqlLead->select(array('id', 'clean_name_c'));
        $sqlLead->from(BeanFactory::newBean('Leads'), array('team_security' => false));
        $sqlLead->where()->equals('clean_name_c', $cleanName);
        // $sqlLead->where()->notEquals('id', $bean->id);
        $sqlLead->where()->equals('deleted', '0');
        $resultLead = $sqlLead->execute();
        $countLead = count($resultLead);

        $idPadre = $countLead>0? $resultLead[0]['id']:"";

        return $idPadre;

    }

}
