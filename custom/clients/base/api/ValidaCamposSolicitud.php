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

        $req_pm = "origen_cuenta_c,tipodepersona_c," .
            "nombre_comercial_c,actividadeconomica_c," .
            "empleados_c,promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        $req_pf_y_pfae = "origen_cuenta_c,tipodepersona_c," .
            "primernombre_c,apellidopaterno_c,apellidomaterno_c," .
            "actividadeconomica_c," .
            "empleados_c," .
            "promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        if ($option == '2') {
            $req_pm .= ",rfc_c,fechaconstitutiva_c," .
                "pais_nacimiento_c,estado_nacimiento_c," .
                "zonageografica_c,ventas_anuales_c,tct_ano_ventas_ddw_c," .
                "potencial_cuenta_c,activo_fijo_c";

            $req_pf_y_pfae .= ",rfc_c,fechadenacimiento_c," .
                "pais_nacimiento_c,estado_nacimiento_c,zonageografica_c," .
                "genero_c,ifepasaporte_c,curp_c," .
                "estadocivil_c,profesion_c,ventas_anuales_c,tct_ano_ventas_ddw_c,potencial_cuenta_c,activo_fijo_c";
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

        $beanPersona->load_relationship('accounts_tel_telefonos_1');
        $relatedBeansTel = $beanPersona->accounts_tel_telefonos_1->getBeans();
        $telefono = count($relatedBeansTel);
        if ($telefono == 0 && ($beanPersona->email1 == "" || $beanPersona->email1 == null)) {
            array_push($array_errores, 'Teléfono o Email');
        }

        if ($telefono == 0 && $beanPersona->tipo_registro_cuenta_c == "2") { // Prospecto - 2
            array_push($array_errores, 'Teléfono');
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

            return $strResult;
        } else {
            return "";
        }


    }
}
