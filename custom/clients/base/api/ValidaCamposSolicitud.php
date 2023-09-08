<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 20/07/2018
 * Time: 01:08 PM
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class ValidaCamposSolicitud extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            //GET
            'retrieve' => array(
                //request type
                'reqType' => 'GET',
                'noLoginRequired' => true,
                //endpoint path
                'path' => array('ObligatoriosCuentasSolicitud', '?', '?','?'),
                //endpoint variables
                'pathVars' => array('module', 'id_cuenta', 'caso','producto'),
                //method to call
                'method' => 'validaRequeridos',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Método GET para validar que cumpla con los datos necesarios para crear la solicitud',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),

        );

    }

    // FUNCIONES PARA VALIDACIONES
    public function validaRequeridos($api, $args)
    {
        $option = $args['caso'];
        $producto = $args['producto'];
        global $db;

        $req_pm = "origen_cuenta_c,tipodepersona_c," .
            "nombre_comercial_c," .
            "empleados_c,promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        $req_pf_y_pfae = "origen_cuenta_c,tipodepersona_c," .
            "primernombre_c,apellidopaterno_c,apellidomaterno_c," .
            "empleados_c," .
            "promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        if ($option == '2') {
            $req_pm .= ",rfc_c,fechaconstitutiva_c," .
                "pais_nacimiento_c,estado_nacimiento_c," .
                "zonageografica_c,ventas_anuales_c,tct_ano_ventas_ddw_c," .
                "potencial_cuenta_c,activo_fijo_c";

            $req_pf_y_pfae .= ",rfc_c,fechadenacimiento_c," .
                "pais_nacimiento_c,estado_nacimiento_c,zonageografica_c," .
                "genero_c,curp_c," .
                "estadocivil_c,ventas_anuales_c,tct_ano_ventas_ddw_c,potencial_cuenta_c,activo_fijo_c";
        }

        $id_cuenta = $args['id_cuenta'];

        $array_errores = array();

        $beanPersona = BeanFactory::getBean("Accounts", $id_cuenta);
        $field_defs['Accounts'] = $beanPersona->getFieldDefinitions();

        if ($beanPersona->tipodepersona_c == 'Persona Moral') {
            $array_campos = explode(',', $req_pm);

            foreach ($array_campos as $key) {

                //cast
                if ($key=="ventas_anuales_c"  && floatval($beanPersona->$key) == 0) {
                    $beanPersona->$key = "";
                }
                if ($key=="activo_fijo_c" && floatval($beanPersona->$key) == 0) {
                    $beanPersona->$key = "";
                }
                if ($key=="actividadeconomica_c" && $beanPersona->actividadeconomica_c == "0") {
                    $beanPersona->$key = "";
                }

                if ($beanPersona->$key == "" || $beanPersona->$key == null) {
                    $label = $beanPersona->field_defs[$key]['labelValue'];
                    $label = ($key=="estado_nacimiento_c") ? "Estado de Constitución" : $label;
                    $label = ($key=="pais_nacimiento_c") ? "País de Constitución" : $label;
                    array_push($array_errores, $label);
                }
            }

        } else {
            $array_campos = explode(',', $req_pf_y_pfae);

            foreach ($array_campos as $key) {

                //cast
                if ($key=="ventas_anuales_c"  && floatval($beanPersona->$key) == 0) {
                    $beanPersona->$key = "";
                }
                if ($key=="activo_fijo_c" && floatval($beanPersona->$key) == 0) {
                    $beanPersona->$key = "";
                }
                if ($key=="actividadeconomica_c" && $beanPersona->actividadeconomica_c == "0") {
                    $beanPersona->$key = "";
                }

                if ($beanPersona->$key == "" || $beanPersona->$key == null) {
                    $label = $beanPersona->field_defs[$key]['labelValue'];

                    array_push($array_errores, $label);
                }
            }

        }

        $beanPersona->load_relationship('accounts_dire_direccion_1');
        $relatedBeansDir = $beanPersona->accounts_dire_direccion_1->getBeans();
        $direccion = count($relatedBeansDir);
        if ($direccion == 0) {
            array_push($array_errores, 'Dirección');
        }

        if ($option=='2'){
            $telefono = 0;
            $beanPersona->load_relationship('accounts_tel_telefonos_1');
            foreach ($beanPersona->accounts_tel_telefonos_1->getBeans() as $a_telefono) {
                //$GLOBALS['log']->fatal($telefono);
                //$GLOBALS['log']->fatal($a_telefono->estatus);
                if ($a_telefono->estatus=='Activo') {
                    $telefono++;
                    
                }
            }
            if ($beanPersona->email1 == "" || $beanPersona->email1 == null) {
                array_push($array_errores, 'Email');
            }

            if ($telefono == 0) {
                array_push($array_errores, 'Teléfono');
            }
        }

        if ($option == '2' && $beanPersona->tipodepersona_c == 'Persona Moral') {
            $beanPersona->load_relationship('rel_relaciones_accounts_1');
            $relatedBeansRel = $beanPersona->rel_relaciones_accounts_1->getBeans();
            $relaciones = 0;

            foreach ($relatedBeansRel as $clave ) {
               $resultado= strpos($clave->relaciones_activas , "Propietario Real");
                if (!empty($resultado) && $resultado>=0){
                    $relaciones++;
                }
            }
            if ($relaciones==0){
                array_push($array_errores, 'Propietario Real');
            }
        }
        if ($option == '2'){
            $faltantes_relaciones="";
            $no_correo=0;
            $no_tels=0;
            $nombres_mail="";
            $nombres_tel="";
            //$GLOBALS['log']->fatal('Entra validación para relaciones Activas y tels/correos');
            //$GLOBALS['log']->fatal('ID de la cuenta es :' .$id_cuenta);
            $query="SELECT distinct 
                    rel.relaciones_activas relActivas,relp.rel_relaciones_accounts_1accounts_ida cuentaPadre, relc.account_id1_c cuentaHija, cuentaH.name,
                    MAX(IF(email.email_address_id is null,0,1 )) correo,
                    MAX(IF(tel.id is null,0,1 )) tel
                    from rel_relaciones rel
                    inner join rel_relaciones_cstm relc on relc.id_c=rel.id 
                    inner join rel_relaciones_accounts_1_c relp on relp.rel_relaciones_accounts_1rel_relaciones_idb = rel.id
                    inner join accounts cuentaH on cuentaH.id = relc.account_id1_c
                    left join email_addr_bean_rel email on email.bean_id = relc.account_id1_c and email.deleted=0
                    left join accounts_tel_telefonos_1_c telAc on telAc.accounts_tel_telefonos_1accounts_ida = relc.account_id1_c and telAc.deleted=0
                    left join tel_telefonos tel on tel.id = telAc.accounts_tel_telefonos_1tel_telefonos_idb and tel.estatus='Activo' 
                    where 
                    rel.deleted=0
                    -- and (email.id is null or tel.id is null )
                    and relp.rel_relaciones_accounts_1accounts_ida='{$id_cuenta}'
                    and (
                    rel.relaciones_activas like '%Aval%'
                    or rel.relaciones_activas like '%Accionista%'
                    or rel.relaciones_activas like '%Depositario%'
                    or rel.relaciones_activas like '%Representante%'
                    or rel.relaciones_activas like '%Propietario Real%'
                    )
                    group by relc.account_id1_c;";
            //$GLOBALS['log']->fatal('La consulta es :' .print_r($query,1));
            $result = $db->query($query);
            //$GLOBALS['log']->fatal('Ejecuto consulta para obtener tels o correos en las relaciones activas.');

            while($row = $GLOBALS['db']->fetchByAssoc($result)){
                //$GLOBALS['log']->fatal("Entra a While");
                //$GLOBALS['log']->fatal($row['correo'].$row['name'].$row['tel']);
                if ($row['correo']==false){
                    $no_correo++;
                    $nombres_mail.='<br>-<a href="#Accounts/' .$row['cuentaHija'].'" target= "_blank">'.$row['name'].'</a>';
                    
                    //array_push($array_errores, 'La siguiente relación requiere de un Correo:<br> '.$row['name']);
                    //$GLOBALS['log']->fatal('Setea correo faltante en la relacion.'.$row['name']);
                }
                if ($row['tel']==false){
                    $no_tels++;
                    $nombres_tel.='<br>-<a href="#Accounts/' .$row['cuentaHija'].'" target= "_blank">'.$row['name'].'</a>';
                    //array_push($array_errores, 'La siguiente relación requiere de un Teléfono:<br> '.$row['name']);
                    //$GLOBALS['log']->fatal('Setea Teléfono faltante en la relacion.'.$row['name']);
                }
            }
            
        }
        //Recuperar informacion de PLD
        $beanPersona->load_relationship('accounts_tct_pld_1');
        $pldRel = $beanPersona->accounts_tct_pld_1->getBeans();
        $proveedorR = 0;


        foreach ($pldRel as $registro) {
            if ($registro->tct_pld_campo4_ddw=="2" && $registro->description=="AP" && $producto==1 ) {
                $proveedorR=1;
            }
            if ($registro->tct_pld_campo4_ddw=="2" && $registro->description=="FF" && $producto==4 ) {
                $proveedorR=1;
            }
            if ($registro->tct_pld_campo4_ddw=="2" && $registro->description=="CA" && $producto==3 ) {
                $proveedorR=1;
            }
            if ($registro->tct_pld_campo4_ddw=="2" && $registro->description=="CS" && $producto==2 ) {
                $proveedorR=1;
            }
        }

        if ($option == '2') {
            $beanPersona->load_relationship('rel_relaciones_accounts_1');
            $relatedBeansRel = $beanPersona->rel_relaciones_accounts_1->getBeans();
            $relaciones = 0;

            if ($producto == 1 && $proveedorR==1) {
                foreach ($relatedBeansRel as $clave) {
                    $resultado = strpos($clave->relaciones_activas, "Proveedor de Recursos L");
                    if (!empty($resultado) && $resultado >= 0) {
                        $relaciones++;
                    }
                }
                if ($relaciones == 0) {
                    array_push($array_errores, 'Proveedor de Recursos Leasing');
                }
            }
            if ($producto == 4 && $proveedorR==1) {
                foreach ($relatedBeansRel as $clave) {
                    $resultado = strpos($clave->relaciones_activas, "Proveedor de Recursos F");
                    if (!empty($resultado) && $resultado >= 0) {
                        $relaciones++;
                    }
                }
                if ($relaciones == 0) {
                    array_push($array_errores, 'Proveedor de Recursos Factoraje Financiero');
                }
            }
            if ($producto == 3 && $proveedorR==1) {
                foreach ($relatedBeansRel as $clave) {
                    $resultado = strpos($clave->relaciones_activas, "Proveedor de Recursos CA");
                    if (!empty($resultado) && $resultado >= 0) {
                        $relaciones++;
                    }
                }
                if ($relaciones == 0) {
                    array_push($array_errores, 'Proveedor de Recursos Crédito Automotriz');
                }
            }
            if ($producto == 2 && $proveedorR==1) {
                foreach ($relatedBeansRel as $clave) {
                    $resultado = strpos($clave->relaciones_activas, "Proveedor de Recursos CS");
                    if (!empty($resultado) && $resultado >= 0) {
                        $relaciones++;
                    }
                }
                if ($relaciones == 0) {
                    array_push($array_errores, 'Proveedor de Recursos Crédito Simple');
                }
            }
        }
        if (count($array_errores) > 0) {
            $strResult = implode('<br>', $array_errores);
            $strResult = "<b>" . $strResult . "</b>";

            if($option == '2' && ($no_correo || $no_tels)){
                $strResult.='<br>';
                if($no_correo>0){
                    $strResult.= '<br>La(s) siguiente(s) relación(es) requiere(n) de un Correo: <b>'.$nombres_mail.'</b><br>';
                }
                if($no_tels>0){
                    $strResult.= '<br>La(s) siguiente(s) relación(es) requiere(n) de un Teléfono: <b>'.$nombres_tel.'</b><br>';
                }
            }
            return $strResult;
        } else {
            return "";
        }


    }
}
