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

        if ($bean->tipo_registro_c == "Persona Moral") {
            $bean->name = $bean->nombre_empresa_c;
        }
        //Crea Clean_name (exclusivo para aplicativos externos a CRM)
        // if ($bean->clean_name_c == "" || $bean->clean_name_c == null) {

        $tipo = $app_list_strings['validacion_simbolos_list']; //obtencion lista simbolos
        $acronimos = $app_list_strings['validacion_duplicados_list'];

        //  $GLOBALS['log']->fatal('full name ' . $bean->full_name);

        if ($bean->regimen_fiscal_c != "Persona Moral") {
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

        $GLOBALS['log']->fatal("cOMIENZA A vALIDAR dUPLICADO " . $GLOBALS['service']->platform);

        if ($GLOBALS['service']->platform != "api" && $GLOBALS['service']->platform != "unifinAPI") {
            // omitir si el leads es cancelado no se haga nada o si ya esta convertido se brinca la validación
            if ($bean->subtipo_registro_c != 3 && $bean->subtipo_registro_c != 4) {
                //  $GLOBALS['log']->fatal("cOMIENZA A vALIDAR dUPLICADO ");
                // $GLOBALS['log']->fatal("para moral " . $bean->clean_name_c);
                //$duplicateproductMessageAccounts = 'Ya existe una cuenta con la misma información';
                $sql = new SugarQuery();
                $sql->select(array('id', 'clean_name'));
                $sql->from(BeanFactory::newBean('Accounts'), array('team_security' => false));
                $sql->where()->equals('clean_name', $bean->clean_name_c);
                $sql->where()->notEquals('id', $bean->id);

                $result = $sql->execute();
                $count = count($result);

                $duplicateproductMessageLeads = 'El registro que intentas guardar ya existe como Lead/Cuenta.';
                $sqlLead = new SugarQuery();
                $sqlLead->select(array('id', 'clean_name_c'));
                $sqlLead->from(BeanFactory::newBean('Leads'), array('team_security' => false));
                $sqlLead->where()->equals('clean_name_c', $bean->clean_name_c);
                $sqlLead->where()->notEquals('id', $bean->id);
                $resultLead = $sqlLead->execute();
                $countLead = count($resultLead);

                $GLOBALS['log']->fatal("c---- " . $countLead . "  " . $count);


                if ($count > 0 || $countLead > 0) {

                    if ($_REQUEST['module'] != 'Import') {
                        throw new SugarApiExceptionInvalidParameter($duplicateproductMessageLeads);
                    }
                    {
                        $bean->deleted = 1;
                        $bean->resultado_de_carga_c = 'Registro Duplicado';
                    }

                } else {
                    $bean->resultado_de_carga_c = 'Registro Exitoso';
                }
                $fechaCarga = date("Ymd");
                //$GLOBALS['log']->fatal("fecha hoy ". $fechaCarga . " valor campo ". $bean->nombre_de_cargar_c);

                $bean->nombre_de_cargar_c = ($bean->nombre_de_cargar_c == "" && $_REQUEST['module'] == 'Import') ? "Carga_" . $fechaCarga : $bean->nombre_de_cargar_c;


            } else {
                //  $GLOBALS['log']->fatal("Ya esta convertido o cancelado no hago nada ");

            }
        }


        //$GLOBALS['log']->fatal("Termina validacion dUPLICADO ");
    }

}

