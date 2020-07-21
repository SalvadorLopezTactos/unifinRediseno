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
        if ($_REQUEST['module'] != 'Import') {
            foreach ($bean as $field => $value) {

                if ($bean->field_defs[$field]['name'] != 'nombre_de_cargar_c' && $bean->field_defs[$field]['name'] != 'resultado_de_carga_c') {

                    if ($bean->field_defs[$field]['type'] == 'varchar') {
                        $value = mb_strtoupper($value, "UTF-8");
                        $bean->$field = $value;
                    }
                    if ($bean->field_defs[$field]['name'] == 'name') {
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

        /*if ($bean->tipo_registro_c == "Persona Moral") {
            $bean->name = $bean->nombre_empresa_c;
        }*/
        //Crea Clean_name (exclusivo para aplicativos externos a CRM)
        // if ($bean->clean_name_c == "" || $bean->clean_name_c == null) {

        $tipo = $app_list_strings['validacion_simbolos_list']; //obtencion lista simbolos
        $acronimos = $app_list_strings['validacion_duplicados_list'];

        //  $GLOBALS['log']->fatal('full name ' . $bean->full_name);

        if ($bean->regimen_fiscal_c != "3") {
            $full_name = $bean->nombre_c . " " . $bean->apellido_paterno_c . " " . $bean->apellido_materno_c;
            //$GLOBALS['log']->fatal(print_r($tipo,true));
            //Cambia a mayúsculas y quita espacios a cada campo
            //Concatena los tres campos para formar el clean_name
            $nombre = $full_name;
            $nombre = mb_strtoupper($nombre, "UTF-8");
            $separa = explode(" ", $nombre);
            //$GLOBALS['log']->fatal(print_r($separa,true));
            $longitud = count($separa);
            //Itera el arreglo separado
            for ($i = 0; $i < $longitud; $i++) {
                foreach ($tipo as $t => $key) {
                    $separa[$i] = str_replace($key, "", $separa[$i]);
                }
            }
            $une = implode($separa);
            $bean->clean_name_c = $une;

            //    $GLOBALS['log']->fatal("para fisica " . $bean->clean_name_c);

        } else {
            //$GLOBALS['log']->fatal($bean->razonsocial_c);
            $nombre = $bean->nombre_empresa_c;
            $nombre = mb_strtoupper($nombre, "UTF-8");
            $separa = explode(" ", $nombre);
            $separa_limpio = $separa;
            // $GLOBALS['log']->fatal(print_r($separa, true));
            $longitud = count($separa);
            $eliminados = 0;
            //Itera el arreglo separado
            for ($i = 0; $i < $longitud; $i++) {
                foreach ($tipo as $t => $key) {
                    $separa[$i] = str_replace($key, "", $separa[$i]);
                    $separa_limpio[$i] = str_replace($key, "", $separa_limpio[$i]);
                }
                foreach ($acronimos as $a => $key) {
                    if ($separa[$i] == $a) {
                        $separa[$i] = "";
                        $eliminados++;
                    }
                    //$GLOBALS['log']->fatal($a);
                    //   $GLOBALS['log']->fatal(print_r($separa, true));


                }
            }
            //Condicion para eliminar los acronimos
            if (($longitud - $eliminados) <= 1) {
                $separa = $separa_limpio;
            }
            //Convierte el array a string nuevamente
            $une = implode($separa);
            $bean->clean_name_c = $une;

            //  $GLOBALS['log']->fatal("para moral " . $bean->clean_name_c);

        }
        //}
    }


    public function ExistenciaEnCuentas($bean = null, $event = null, $args = null)
    {
        $idPadre = "";

        $servicio= isset($GLOBALS['service']->platform)?$GLOBALS['service']->platform:"base";

        if ($servicio!= "api" && $servicio != "unifinAPI") {

            // omitir si el leads es cancelado no se haga nada o si ya esta convertido se brinca la validación
            if ($bean->subtipo_registro_c != 3 && $bean->subtipo_registro_c != 4) {

                $idPadre = $this->createCleanName($bean->leads_leads_1_name);
                //  $GLOBALS['log']->fatal("cOMIENZA A vALIDAR dUPLICADO ");
                // $GLOBALS['log']->fatal("para moral " . $bean->clean_name_c);
                $exprNumerica = "/^[0-9]*$/";
                /**********************VALIDACION DE CAMPOS PB ID Y DUNS ID DEBEN SER NUMERICOS*********************/
                if (!preg_match($exprNumerica, $bean->pb_id_c)) {

                    $bean->pb_id_c = "";
                }
                if (!preg_match($exprNumerica, $bean->duns_id_c)) {

                    $bean->duns_id_c = "";
                }

                //$duplicateproductMessageAccounts = 'Ya existe una cuenta con la misma información';
                $sql = new SugarQuery();
                $sql->select(array('id', 'clean_name'));
                $sql->from(BeanFactory::newBean('Accounts'), array('team_security' => false));
                $sql->where()->equals('clean_name', $bean->clean_name_c);
                $sql->where()->notEquals('id', $bean->id);

                $result = $sql->execute();
                $count = count($result);
                /************SUGARQUERY PARA VALIDAR IMPORTACION DE REGISTROS SI TIENEN IGUAL LOS MISMOS VALORES DE CLEAN_NAME O PB_ID O DUNS_ID*********/
                $duplicateproductMessageLeads = 'El registro que intentas guardar ya existe como Lead/Cuenta.';
                $sqlLead = new SugarQuery();
                $sqlLead->select(array('id', 'clean_name_c', 'pb_id_c', 'duns_id_c'));
                $sqlLead->from(BeanFactory::newBean('Leads'), array('team_security' => false));
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

                $GLOBALS['log']->fatal("c---- " . $countLead . "  " . $count);

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

                $bean->nombre_de_cargar_c = ($bean->nombre_de_cargar_c == "" && $_REQUEST['module'] == 'Import') ? "Carga_" . $fechaCarga : $bean->nombre_de_cargar_c;
            }
        }
    }
    public function createCleanName($nameCuenta)
    {
        // $GLOBALS['log']->fatal('QUITO ESPACIOS Y REEMPLAZO POR NUEVOS VALORES');

        global $db;
        global $app_list_strings, $current_user; //Obtención de listas de valores


        $limpianomcomercial = preg_replace('/\s\s+/', ' ', $nameCuenta);

        $tipo = $app_list_strings['validacion_simbolos_list']; //obtencion lista simbolos
        $acronimos = $app_list_strings['validacion_duplicados_list'];

        $nombre = mb_strtoupper($limpianomcomercial, "UTF-8");
        $separa = explode(" ", $nombre);
        $separa_limpio = $separa;
        $longitud = count($separa);
        $eliminados = 0;
        //Itera el arreglo separado
        for ($i = 0; $i < $longitud; $i++) {
            foreach ($tipo as $t => $key) {
                $separa[$i] = str_replace($key, "", $separa[$i]);
                $separa_limpio[$i] = str_replace($key, "", $separa_limpio[$i]);
            }
            foreach ($acronimos as $a => $key) {
                if ($separa[$i] == $a) {
                    $separa[$i] = "";
                    $eliminados++;
                }
            }
        }
        //Condicion para eliminar los acronimos
        if (($longitud - $eliminados) <= 1) {
            $separa = $separa_limpio;
        }
        //Convierte el array a string nuevamente
        $une = implode($separa);
        $cleanName = $une;

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
