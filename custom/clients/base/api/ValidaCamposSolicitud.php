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
                'path' => array('ObligatoriosCuentasSolicitud', '?','?'),
                //endpoint variables
                'pathVars' => array('module', 'id_cuenta','caso'),
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
        $option=$args['caso'];

        $req_pm = "origendelprospecto_c,tipodepersona_c," .
            "nombre_comercial_c,sectoreconomico_c," .
            "subsectoreconomico_c,actividadeconomica_c," .
            "empleados_c,promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        $req_pf_y_pfae = "origendelprospecto_c,tipodepersona_c," .
            "primernombre_c,apellidopaterno_c,apellidomaterno_c," .
            "nombre_comercial_c," .
            "sectoreconomico_c,subsectoreconomico_c,actividadeconomica_c," .
            "empleados_c," .
            "promotorleasing_c,promotorfactoraje_c,promotorcredit_c";

        if($option=='2'){
            $req_pm .= ",rfc_c,fechadenacimiento_c," .
                "pais_nacimiento_c,estado_nacimiento_c," .
                "zonageografica_c,ventas_anuales_c," .
                "potencial_cuenta_c,activo_fijo_c";

            $req_pf_y_pfae .= ",rfc_c,fechadenacimiento_c," .
                "pais_nacimiento_c,estado_nacimiento_c,zonageografica_c," .
                "genero_c,ifepasaporte_c,curp_c," .
                "estadocivil_c,regimenpatrimonial_c,profesion_c,ventas_anuales_c,potencial_cuenta_c,activo_fijo_c";
        }

        $id_cuenta = $args['id_cuenta'];

        $array_errores = array();

        $beanPersona = BeanFactory::getBean("Accounts", $id_cuenta);
        $field_defs['Accounts'] = $beanPersona->getFieldDefinitions();


        if ($beanPersona->tipodepersona_c == 'Persona Moral') {
            $array_campos = explode(',', $req_pm);

            foreach ($array_campos as $key) {
                if ($beanPersona->$key == "" || $beanPersona->$key == null) {
                    $label = $beanPersona->field_defs[$key]['labelValue'];

                    array_push($array_errores, $label);
                }
            }

        } else {
            $array_campos = explode(',', $req_pf_y_pfae);

            foreach ($array_campos as $key) {
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


        if (count($array_errores) > 0) {
            return implode(',',$array_errores);
        } else {
            return "";
        }


}
}
