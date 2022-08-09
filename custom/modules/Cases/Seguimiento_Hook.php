<?php
// Creado por: Erick de Jesús
// tactos
class Seguimiento_Hook
{
    function Fecha_Seguimiento($bean, $event, $args)
    {  
        //Eventos para establecer fecha de seguimiento:
        if(!$args['isUpdate']){//Es creación, evento disparador número 1
            $fecha_s = ""; 
            $GLOBALS['log']->fatal("********** Prioridad **********");
            /* ******************** Prioridad *****************+
            Prioridad Baja: Usuario y contraseña del portal , Error para visualizar información ,Error en la carga de archivos ,Error para descarga de archivos
            Prioridad Media: Cantidad cobrada no coincide, Cargos duplicados,Cargos cancelados,Reporte por daño
            Prioridad Alta: Cargos no reconocidos,Bloqueos preventivos por fraude, Reporte por robo,Reporte por extravío,Caída completa de plataformas
            */
            if($bean->subtipo_c == '9' || $bean->subtipo_c == '10' || $bean->subtipo_c == '11' || $bean->subtipo_c == '12'){
                $bean->priority = 'P3'; 
            }
            if($bean->subtipo_c == '1' || $bean->subtipo_c == '2' || $bean->subtipo_c == '3' || $bean->subtipo_c == '8'){
                $bean->priority = 'P2'; 
            }
            if($bean->subtipo_c == '4' || $bean->subtipo_c == '5' || $bean->subtipo_c == '6'|| $bean->subtipo_c == '7'|| $bean->subtipo_c == '13'){
                $bean->priority = 'P1'; 
            }
            
            /*La fecha de seguimiento se establece deacuerdo a:
            |Subtipo de caso|Prioridad|Fecha de seguimiento|
            |Cargos no reconocidos|Alta|1 día|
            |Bloqueos preventivos por fraude|Alta|1 día|
            |Reporte por robo|Alta|1 día|
            |Reporte por extravío|Alta|1 día|
            |Caída completa de plataformas|Alta|1 día|
            |Reporte por daño|Media|4 días|
            |Cantidad cobrada no coincide|Media|2 días|
            |Cargos duplicados|Media|2 días|
            |Cargos cancelados|Media|2 días|
            |Error para visualizar información|Baja|4 días|
            |Error en la carga de archivos|Baja|4 días|
            |Error para descarga de archivos|Baja|4 días|
            |Usuario y contraseña del portal|Baja|1 día|
            */
            $GLOBALS['log']->fatal("********** Fecha de seguimiento **********");
             
            if($bean->priority == 'P1' ){
                if($bean->subtipo_c == '4' || $bean->subtipo_c == '5' || $bean->subtipo_c == '6'|| $bean->subtipo_c == '7'|| $bean->subtipo_c == '13'){
                    $fecha_s = $this->dia_seguimiento(1);   //1 dia
                }
            }
            if($bean->priority == 'P2' ){
                if($bean->subtipo_c == '8'){
                    $fecha_s = $this->dia_seguimiento(4);  //4
                }
                if($bean->subtipo_c == '1' || $bean->subtipo_c == '2' || $bean->subtipo_c == '3'){
                    $fecha_s = $this->dia_seguimiento(2);   //2
                }
            }
            if($bean->priority == 'P3' ){
                if($bean->subtipo_c == '10' || $bean->subtipo_c == '11' || $bean->subtipo_c == '12'){
                    $fecha_s = $this->dia_seguimiento(4);   //4
                }
                if($bean->subtipo_c == '9'){
                    $fecha_s = $this->dia_seguimiento(1);   //1
                }
            }

            $bean->follow_up_datetime = $fecha_s;
        }else{
            if($bean->fetched_row['status'] != $bean->status && $bean->status == '3'){
                $bean->resolved_datetime = $bean->date_modified;
            }
        }
        
    }

    function dia_seguimiento($add){
        $fecha_actual = date("Y-m-d H:i:s"); 
        //$GLOBALS['log']->fatal("hpy".$fecha_actual);
        $hoy =  date("Y-m-d H:i:s",strtotime($fecha_actual."+ ".$add." days"));
        $dsemana = date('D',strtotime($fecha_actual."+ ".$add." days"));
      
        if($dsemana == "Sat"){
            $hoy =  date("Y-m-d H:i:s",strtotime($fecha_actual."+ ".($add+2)." days"));
            $dsemana = date('D',strtotime($fecha_actual."+ ".($add+2)." days"));
        }
        if($dsemana == "Sun"){
            $hoy =  date("Y-m-d H:i:s",strtotime($fecha_actual."+ ".($add+1)." days"));
            $dsemana = date('D',strtotime($fecha_actual."+ ".($add+1)." days"));
        }
        $GLOBALS['log']->fatal("hpy".$hoy);
        $GLOBALS['log']->fatal("hpy1".$dsemana);
        return $hoy;
    }

    
}
