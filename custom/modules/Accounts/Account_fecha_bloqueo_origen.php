<?php
// Creado por: Salvador Lopez Balleza
// salvador.lopez@tactos.com.mx
class Account_fecha_bloqueo_origen
{
    function establece_fecha_bloqueo_account($bean, $event, $args)
    {
        //Eventos para establecer la fecha de bloqueo:
        //Creación de Cuenta
        //Edición de Origen
        //Cambio a Prospecto Crédito o Cliente
        //Cambio de Prospecto Crédito a Prospecto Rechazado, tomar fecha de vigencia previa.

        if(!$args['isUpdate']){//Es creación, evento disparador número 1

            //La fecha de bloqueo se establece a 1 año para los tipos:
            /*
            Prospecto=2, Sin Contactar=1
            Prospecto=2 Contactado=2
            Prospecto=2 Interesado=7
            Prospecto=2 Integración Expediente=8
            Prospecto=2 Rechazado=10
            */
            if( ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='1') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='2') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='7') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='8') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='10')
            ){
                $GLOBALS['log']->fatal("**********Actualiza fecha de bloqueo en Cuentas**********");
                //La fecha de bloqueo se establece a 1 año
                $current_date_time = new SugarDateTime();
                $fecha_6_meses=$current_date_time->modify("+12 month");
                $fecha_6_meses_formateada=$fecha_6_meses->format("Y-m-d");

                $GLOBALS['log']->fatal(print_r($fecha_6_meses_formateada,true));

                $bean->fecha_bloqueo_origen_c=$fecha_6_meses_formateada;


            }
        }else{//Es actualización

            if($bean->fetched_row['origen_cuenta_c'] != $bean->origen_cuenta_c && $bean->onboarding_chk_c!=1){//Se editó el valor de origen, es el evento disparador número 2
                $GLOBALS['log']->fatal("**********Actualiza fecha de bloqueo en Cuentas**********");
                //La fecha de bloqueo se establece a 1 año para los tipos:
                /*
                Prospecto=2, Sin Contactar=1
                Prospecto=2 Contactado=2
                Prospecto=2 Interesado=7
                Prospecto=2 Integración Expediente=8
                Prospecto=2 Rechazado=10
                */
                if( ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='1') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='2') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='7') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='8') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='10')
                ){
                    $GLOBALS['log']->fatal("**********Entra evento disparador 2**********");
                    //La fecha de bloqueo se establece a 6 meses a partir de la fecha actual
                    $current_date_time = new SugarDateTime();
                    $fecha_6_meses=$current_date_time->modify("+12 month");
                    $fecha_6_meses_formateada=$fecha_6_meses->format("Y-m-d");

                    $GLOBALS['log']->fatal(print_r($fecha_6_meses_formateada,true));

                    $bean->fecha_bloqueo_origen_c=$fecha_6_meses_formateada;

                }else{
                    // Prospecto Crédito y Cliente, se bloquea permanentemente, por lo tanto se establece una fecha muy grande
                    if( ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='9') ||
                        ($bean->tipo_registro_cuenta_c=='3')){
                        $bean->fecha_bloqueo_origen_c='2100-01-01';
                    }
                }

            }

            //Cambió a Prospecto Crédito o Cliente, es el evento disparador número 3
            if( ($bean->fetched_row['subtipo_registro_cuenta_c'] != $bean->subtipo_registro_cuenta_c && $bean->subtipo_registro_cuenta_c=='9' && $bean->tipo_registro_cuenta_c=='2') ||
                ($bean->fetched_row['tipo_registro_cuenta_c'] != $bean->tipo_registro_cuenta_c && $bean->tipo_registro_cuenta_c=='3')
            ){
                $GLOBALS['log']->fatal("**********Entra evento disparador 3 para fecha de bloqueo**********");
                $bean->fecha_bloqueo_origen_c='2100-01-01';
            }

            //Cambió de Prospecto Crédito a Prospecto Rechazado, es el evento disparador número 4
            if($bean->fetched_row['subtipo_registro_cuenta_c'] == '9' && $bean->subtipo_registro_cuenta_c=='10' && $bean->tipo_registro_cuenta_c=='2'){
                $GLOBALS['log']->fatal("**********Entra evento disparador 4: Prospecto rechazado, bloqueo se establece a 1 año**********");
                $bean->fecha_bloqueo_origen_c='2100-01-01';
            }
        }

    }

    function valida_fecha_bloqueo_origen($bean, $event, $args)
    {
        //Antes de cambiar el valor del origen, se valida que efectivamente el cambio se pueda realizar, validando que la fecha de bloqueo se haya cumplido
        if($bean->fetched_row['origen_cuenta_c'] != $bean->origen_cuenta_c){
            $current_date_time = new SugarDateTime();
            $fecha_actual=$current_date_time->format("Y-m-d");

            if($bean->fecha_bloqueo_origen_c!="" && $bean->fecha_bloqueo_origen_c!=null){
                $fecha_bloqueo=new SugarDateTime($bean->fecha_bloqueo_origen_c);
                $fecha_bloqueo_format=$fecha_bloqueo->format("Y-m-d");

                $GLOBALS['log']->fatal("Validando fecha de bloqueo antes de cambiar el origen en Cuentas");
                $GLOBALS['log']->fatal("Fecha actual: ".$fecha_actual. ", Fecha bloqueo: ".$fecha_bloqueo_format);

                if($fecha_actual <= $fecha_bloqueo_format && !empty($bean->fetched_row['origen_cuenta_c'])){
                    $GLOBALS['log']->fatal("********** La fecha de bloqueo no se ha cumplido, el origen se queda igual **********");
                    //Aún no se cumple la fecha de bloqueo por lo tanto el valor de "origen" no se puede cambiar
                    $bean->origen_cuenta_c=$bean->fetched_row['origen_cuenta_c'];
                }

            }

        }
    }

    function solicitudes_dummy_onboarding($bean, $event, $args){

        //Cuando la cuenta es Nueva y viene desde onboarding, se genera Presolicitud como "Solicitud Inicial"
        //Cuando la cuenta ya es existente (actualización) y viene desde Onboarding
        $tiposNoProcesa = array("4", "5"); //No procesa Persona y Proveedor
        if(!$args['isUpdate']){//Es creación
            if($bean->onboarding_chk_c==1 && !in_array($bean->tipo_registro_cuenta_c, $tiposNoProcesa) ){
                $GLOBALS['log']->fatal("********** Entra condición para generar solicitud Dummy proveniente de Onboarding **********");
                //Modificar Process Author: Solicitud inicial a Prospecto v2, añadiendo la condición que solo convierta
                //a Prospecto Interesado cuando el nuevo campo no_convertir_prospecto_c es null o false
                //$bean_llamada->load_relationship('leads');
                //$bean_llamada->leads->add($bean->parent_id);
                $beanSolicitud= BeanFactory::newBean('Opportunities');
                $beanSolicitud->tipo_producto_c= ($bean->origen_cuenta_c== 8) ? "1" : "";
                $beanSolicitud->tct_etapa_ddw_c='SI';
                $beanSolicitud->onboarding_chk_c=1;

                //Establece bandera para evitar convertir a Prospecto Interesado
                $beanSolicitud->no_convertir_prospecto_c=1;
                $beanSolicitud->monto_c=0;

                //Campos de origen
                //$GLOBALS['log']->fatal("Valor del Referido de la cuenta: ".$bean->account_id1_c);
                $beanSolicitud->origen_c=$bean->origen_cuenta_c;
                $beanSolicitud->account_id3_c=$bean->account_id1_c;
                $beanSolicitud->detalle_origen_c=$bean->detalle_origen_c;
                $beanSolicitud->medio_digital_c=$bean->medio_digital_c;
                $beanSolicitud->evento_c=$bean->evento_c;
                $beanSolicitud->origen_busqueda_c=$bean->origen_busqueda_c;
                $beanSolicitud->camara_c=$bean->camara_c;
                $beanSolicitud->prospeccion_propia_c=$bean->prospeccion_propia_c;
                $beanSolicitud->account_id4_c=$bean->account_id_c; //Socio comercial
                $beanSolicitud->codigo_expo_c=$bean->codigo_expo_c; //Código Expo
                //Relaciona Solicitud con la cuenta Actual
                $beanSolicitud->account_id=$bean->id;
                $beanSolicitud->save();

            }
        }else{
            //Cuando sea actualización, antes de establecer la actualización del origen, validar si ya se cumplió la fecha de bloqueo del origen para la cuenta
            if($bean->onboarding_chk_c==1 && $bean->fetched_row['onboarding_chk_c'] != $bean->onboarding_chk_c && !in_array($bean->tipo_registro_cuenta_c, $tiposNoProcesa) ){
                //Valida si la fecha de bloqueo ya se cumplió
                if($bean->fetched_row['origen_cuenta_c'] != $bean->origen_cuenta_c){
                    $GLOBALS['log']->fatal("********** Entra condición (actualización de Cuenta) para generar solicitud Dummy proveniente de Onboarding **********");
                    //$GLOBALS['log']->fatal("Valor del id del referido:".$bean->account_id1_c);
                    //Se genera solicitud dummy
                    $beanSolicitud= BeanFactory::newBean('Opportunities');
                    $beanSolicitud->tipo_producto_c= ($bean->origen_cuenta_c== 8) ? "1" : "";
                    $beanSolicitud->tct_etapa_ddw_c='SI';
                    $beanSolicitud->estatus_c='1';
                    $beanSolicitud->onboarding_chk_c=1;
                    //Establece bandera para evitar convertir a Prospecto Interesado
                    $beanSolicitud->no_convertir_prospecto_c=1;
                    $beanSolicitud->monto_c=0;
                    //Campos de origen
                    $beanSolicitud->origen_c=$bean->origen_cuenta_c;
                    $beanSolicitud->account_id3_c=$bean->account_id1_c;
                    $beanSolicitud->detalle_origen_c=$bean->detalle_origen_c;
                    $beanSolicitud->medio_digital_c=$bean->medio_digital_c;
                    $beanSolicitud->evento_c=$bean->evento_c;
                    $beanSolicitud->origen_busqueda_c=$bean->origen_busqueda_c;
                    $beanSolicitud->camara_c=$bean->camara_c;
                    $beanSolicitud->prospeccion_propia_c=$bean->prospeccion_propia_c;
                    $beanSolicitud->codigo_expo_c=$bean->codigo_expo_c; //Código Expo
                    $beanSolicitud->account_id4_c=$bean->account_id_c; //Socio comercial
                    //Relaciona Solicitud con la cuenta Actual
                    $beanSolicitud->account_id=$bean->id;
                    $beanSolicitud->save();

                    //Se valida que el origen se puede actualizar, tomando en cuenta la fecha de bloqueo
                    $current_date_time = new SugarDateTime();
                    $fecha_actual=$current_date_time->format("Y-m-d");

                    $fecha_bloqueo=new SugarDateTime($bean->fecha_bloqueo_origen_c);
                    $fecha_bloqueo_format=$fecha_bloqueo->format("Y-m-d");

                    $GLOBALS['log']->fatal("Validando fecha de bloqueo antes de cambiar el origen en Cuentas");
                    $GLOBALS['log']->fatal("Fecha actual: ".$fecha_actual. ", Fecha bloqueo: ".$fecha_bloqueo_format);

                    if($fecha_actual <= $fecha_bloqueo_format){
                        $GLOBALS['log']->fatal("********** La fecha de bloqueo no se ha cumplido, el origen de la Cuenta se queda igual **********");
                        //Aún no se cumple la fecha de bloqueo por lo tanto el valor de "origen" no se puede cambiar
                        $bean->origen_cuenta_c=$bean->fetched_row['origen_cuenta_c'];
                    }
                }
            }
        }

    }
}
