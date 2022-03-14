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
            */
            if( ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='1') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='2') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='7') ||
                ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='8')
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
            
            if($bean->fetched_row['origen_cuenta_c'] != $bean->origen_cuenta_c){//Se editó el valor de origen, es el evento disparador número 2
                $GLOBALS['log']->fatal("**********Actualiza fecha de bloqueo en Cuentas**********");
                //La fecha de bloqueo se establece a 1 año para los tipos:
                /*
                Prospecto=2, Sin Contactar=1
                Prospecto=2 Contactado=2
                Prospecto=2 Interesado=7
                Prospecto=2 Integración Expediente=8
                */
                if( ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='1') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='2') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='7') ||
                    ($bean->tipo_registro_cuenta_c=='2' && $bean->subtipo_registro_cuenta_c=='8')
                ){
                    
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
                $bean->fecha_bloqueo_origen_c='2100-01-01';
            }

            //Cambió de Prospecto Crédito a Prospecto Rechazado, es el evento disparador número 4
            if(($bean->fetched_row['subtipo_registro_cuenta_c'] == '9' && $bean->subtipo_registro_cuenta_c=='10' && $bean->tipo_registro_cuenta_c=='2')){
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

            $fecha_bloqueo=new SugarDateTime($bean->fecha_bloqueo_origen_c);
            $fecha_bloqueo_format=$fecha_bloqueo->format("Y-m-d");

            $GLOBALS['log']->fatal("Validando fecha de bloqueo antes de cambiar el origen en Cuentas");
            $GLOBALS['log']->fatal("Fecha actual: ".$fecha_actual. ", Fecha bloqueo: ".$fecha_bloqueo_format);

            if($fecha_actual <= $fecha_bloqueo_format){
                $GLOBALS['log']->fatal("********** La fecha de bloqueo no se ha cumplido, el origen se queda igual **********");
                //Aún no se cumple la fecha de bloqueo por lo tanto el valor de "origen" no se puede cambiar
                $bean->origen_c=$bean->fetched_row['origen_c'];
            }

        }
    }
}