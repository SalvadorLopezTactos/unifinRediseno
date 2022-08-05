<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 15/03/22
 * Time: 10:07
 */

use Sugarcrm\Sugarcrm\Security\Subject\Formatter\BeanFormatter;

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class AltaSolicitud extends SugarApi
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
                'reqType' => 'POST',
                //'noLoginRequired' => true,
                //endpoint path
                'path' => array('AltaSolicitud'),
                //endpoint variables
                'pathVars' => array('method'),
                //method to call
                'method' => 'estableceSolicitud',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Actualiza valores de Solicitud dummy en caso de que la Cuenta relacionada cuente con una, en otro caso se genera una nueva solicitud normal, todo esto desde Onboarding',
                //long help to be displayed in the help documentation
                'longHelp' => '',
            ),


        );

    }

    public function estableceSolicitud($api, $args){

        $id_cuenta = isset($args['account_id']) ? $args['account_id'] : '';
        $tipo_producto = isset($args['tipo_producto_c']) ? $args['tipo_producto_c'] : '';
        $negocio = isset($args['negocio_c']) ? $args['negocio_c'] : '';
        $producto_financiero = isset($args['producto_financiero_c']) ? $args['producto_financiero_c'] : '';
        $monto = isset($args['monto_c']) ? $args['monto_c'] : '';
        $id_usuario_asignado = isset($args['assigned_user_id']) ? $args['assigned_user_id'] : '';
        $onboarding = isset($args['onboarding_chk_c']) ? $args['onboarding_chk_c'] : '';
        $origen = isset($args['origen_c']) ? $args['origen_c'] : '';
        $detalle_origen=isset($args['detalle_origen_c']) ? $args['detalle_origen_c'] : '';
        $medio_digital=isset($args['medio_digital_c']) ? $args['medio_digital_c'] : '';
        $evento=isset($args['evento_c']) ? $args['evento_c'] : '';
        $origen_busqueda=isset($args['origen_busqueda_c']) ? $args['origen_busqueda_c'] : '';
        $camara=isset($args['camara_c']) ? $args['camara_c'] : '';
        $prospeccion_propia=isset($args['prospeccion_propia_c']) ? $args['prospeccion_propia_c'] : '';
        
        //Obtiene solicitudes de la cuenta para saber si ya cuenta con solicitudes dummy
        $beanCuenta = BeanFactory::getBean("Accounts", $id_cuenta);

        if ($beanCuenta->load_relationship('opportunities')) {
            $beanSolicitud=null;
            $solicitudes = $beanCuenta->opportunities->getBeans($beanCuenta->id, array('disable_row_level_security' => true));
            $numero_solicitudes=count($solicitudes);
            $GLOBALS['log']->fatal("la cuenta tiene: ".$numero_solicitudes. " solicitudes");
            $tieneDummy=false;
            if($numero_solicitudes>0){

                foreach ($solicitudes as $sol) {
                    //Condición para encontrar la solicitud Dummy
                    if($sol->monto_c==0 && $sol->onboarding_chk_c==1){

                        $tieneDummy=true;
                        $GLOBALS['log']->fatal("La cuenta tiene solicitud dummy : ".$sol->id);
                        $sol->tipo_producto_c=$tipo_producto;
                        $sol->negocio_c=$negocio;
                        $sol->producto_financiero_c=$producto_financiero;
                        $sol->monto_c=$monto;
                        $sol->assigned_user_id=$id_usuario_asignado;

                        $sol->origen_c=$origen;
                        $sol->detalle_origen_c=$detalle_origen;
                        $sol->medio_digital_c=$medio_digital;
                        $sol->evento_c=$evento;
                        $sol->origen_busqueda_c=$origen_busqueda;
                        $sol->camara_c=$camara;
                        $sol->prospeccion_propia_c=$prospeccion_propia;

                        //Se establece bandera para que Process Author no actualice la Cuenta a Prospecto Contactado
                        $sol->no_convertir_prospecto_c=0;

                        //Se establece en validación comercial
                        if((($sol->tipo_producto_c=="1" && $sol->negocio_c=="5" && ($sol->producto_financiero_c=="" || $sol->producto_financiero_c=="0")) || ($sol->tipo_producto_c=="2" && ($sol->negocio_c!="2" || $sol->negocio_c!="10"))) && $sol->tct_etapa_ddw_c=="SI"){
                            $GLOBALS['log']->fatal("La solicitud dummy se establece como en Validación Comercial");
                            $sol->estatus_c="1";
                        }

                        $sol->save();
                        $beanSolicitud=$sol;

                        break;
                    }
                }

            }

            if(!$tieneDummy){
                $GLOBALS['log']->fatal("La cuenta NO tiene solicitud dummy, se procede a generar nueva solicitud");
                //Si no existe solicitud Dummy, se crea la solicitud con los datos que se envían en la petición
                $beanSolicitud= BeanFactory::newBean('Opportunities');
                
                $beanSolicitud->tipo_producto_c=$tipo_producto;
                $beanSolicitud->negocio_c=$negocio;
                $beanSolicitud->producto_financiero_c=$producto_financiero;
                $beanSolicitud->monto_c=$monto;
                $beanSolicitud->assigned_user_id=$id_usuario_asignado;
                $beanSolicitud->onboarding_chk_c=$onboarding;
                $beanSolicitud->account_id=$id_cuenta;

                $beanSolicitud->origen_c=$origen;
                $beanSolicitud->detalle_origen_c=$detalle_origen;
                $beanSolicitud->medio_digital_c=$medio_digital;
                $beanSolicitud->evento_c=$evento;
                $beanSolicitud->origen_busqueda_c=$origen_busqueda;
                $beanSolicitud->camara_c=$camara;
                $beanSolicitud->prospeccion_propia_c=$prospeccion_propia;

                //Se establece bandera para que Process Author no actualice la Cuenta a Prospecto Contactado
                $beanSolicitud->no_convertir_prospecto_c=0;

                if((($beanSolicitud->tipo_producto_c=="1" && $beanSolicitud->negocio_c=="5" && ($beanSolicitud->producto_financiero_c=="" || $beanSolicitud->producto_financiero_c=="0")) || ($beanSolicitud->tipo_producto_c=="2" && ($beanSolicitud->negocio_c!="2" || $beanSolicitud->negocio_c!="10"))) && $beanSolicitud->tct_etapa_ddw_c=="SI"){
                    $GLOBALS['log']->fatal("La solicitud dummy se establece como en Validación Comercial");
                    $beanSolicitud->estatus_c="1";
                }
                
                $beanSolicitud->save();
                
            }

        }

        //Se manda a llamar formatBean para poder regresar la lista de campos de la solicitud recientemente creada o actualizada
        $data = $this->formatBean($api, $args, $beanSolicitud);

        return $data;
       
    }
}