<?php
// Creado por: Salvador Lopez Balleza
// salvador.lopez@tactos.com.mx
class Fecha_bloqueo_origen
{
    function establece_fecha_bloqueo($bean, $event, $args)
    {
        //Eventos para establecer la fecha de bloqueo:
        //1.- Creación de Lead
        //2.- Edición Origen
        //3.- Cambio a Prospecto Convertido/Cancelado
        if(!$args['isUpdate']){//Es creación

            if(($bean->tipo_registro_c=='1' && $bean->subtipo_registro_c=='1')){// Lead Sin Contactar
                $GLOBALS['log']->fatal("**********Actualiza fecha de bloqueo en Leads**********");
                //La fecha de bloqueo se establece a 6 meses a partir de la fecha actual
                $current_date_time = new SugarDateTime();
                $fecha_6_meses=$current_date_time->modify("+6 month");
                $fecha_6_meses_formateada=$fecha_6_meses->format("Y-m-d");

                $GLOBALS['log']->fatal(print_r($fecha_6_meses_formateada,true));

                $bean->fecha_bloqueo_origen_c=$fecha_6_meses_formateada;
                

            }
        }else{//Es actualización
            
            if($bean->fetched_row['origen_c'] != $bean->origen_c){//Se editó el valor de origen, es el evento disparador número 2
                $GLOBALS['log']->fatal("**********Actualiza fecha de bloqueo en Leads**********");
                // Lead sin Contactar y Lead Contactado, se bloquea durante 6 meses
                if(($bean->tipo_registro_c=='1' && $bean->subtipo_registro_c=='1') || ($bean->tipo_registro_c=='1' && $bean->subtipo_registro_c=='2')){
                    
                    //La fecha de bloqueo se establece a 6 meses a partir de la fecha actual
                    $current_date_time = new SugarDateTime();
                    $fecha_6_meses=$current_date_time->modify("+6 month");
                    $fecha_6_meses_formateada=$fecha_6_meses->format("Y-m-d");
    
                    $GLOBALS['log']->fatal(print_r($fecha_6_meses_formateada,true));
    
                    $bean->fecha_bloqueo_origen_c=$fecha_6_meses_formateada;

                }else{
                    // Lead Convertido y Lead Cancelado, se bloquea permanentemente, por lo tanto se establece una fecha muy grande
                    if(($bean->tipo_registro_c=='1' && $bean->subtipo_registro_c=='4') || ($bean->tipo_registro_c=='1' && $bean->subtipo_registro_c=='3')){
                        $bean->fecha_bloqueo_origen_c='2100-01-01';
                    }
                }
                
            }

            if(($bean->fetched_row['subtipo_registro_c'] != $bean->subtipo_registro_c && $bean->subtipo_registro_c=='4') ||
            ($bean->fetched_row['subtipo_registro_c'] != $bean->subtipo_registro_c && $bean->subtipo_registro_c=='3') ||
            //Se agrega condición para el escenario en el que el lead se cancela desde la casilla de verifcación les_cancelado_c
            ($bean->lead_cancelado_c == 1 && $bean->motivo_cancelacion_c != '')
            ){//Cambió a Prospecto Convertido/Cancelado, es el evento disparador número 3
                $bean->fecha_bloqueo_origen_c='2100-01-01';
            }

        }

    }

    function valida_fecha_bloqueo($bean, $event, $args){
        //Antes de cambiar el valor del origen, se valida que efectivamente el cambio se pueda realizar, validando que la fecha de bloqueo se haya cumplido
        if($bean->fetched_row['origen_c'] != $bean->origen_c){
            $current_date_time = new SugarDateTime();
            $fecha_actual=$current_date_time->format("Y-m-d");

            if($bean->fecha_bloqueo_origen_c!="" && $bean->fecha_bloqueo_origen_c!=null){
                $fecha_bloqueo=new SugarDateTime($bean->fecha_bloqueo_origen_c);
                $fecha_bloqueo_format=$fecha_bloqueo->format("Y-m-d");

                $GLOBALS['log']->fatal("Validando fecha de bloqueo antes de cambiar el origen");
                $GLOBALS['log']->fatal("Fecha actual: ".$fecha_actual. ", Fecha bloqueo: ".$fecha_bloqueo_format);

                if($fecha_actual <= $fecha_bloqueo_format && !empty($bean->fetched_row['origen_c'])){
                    $GLOBALS['log']->fatal("********** La fecha de bloqueo no se ha cumplido, el origen se queda igual **********");
                    //Aún no se cumple la fecha de bloqueo por lo tanto el valor de "origen" no se puede cambiar
                    $bean->origen_c=$bean->fetched_row['origen_c'];
                }
            }
            

        }

    }
}