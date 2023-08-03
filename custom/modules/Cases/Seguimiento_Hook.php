<?php
// Creado por: Erick de Jesús
// tactos
require_once 'modules/Teams/TeamSet.php';
class Seguimiento_Hook
{
    function Fecha_Seguimiento($bean, $event, $args)
    {
        global $current_user;
        //Eventos para establecer fecha de seguimiento:
        if(!$args['isUpdate']){//Es creación, evento disparador número 1
            $fecha_s = "";
            //$GLOBALS['log']->fatal("********** Prioridad **********");
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
            //$GLOBALS['log']->fatal("********** Fecha de seguimiento **********");

            /*
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

            if($bean->subtipo_c== '15' || $bean->subtipo_c== '18' || $bean->subtipo_c== '20' || $bean->subtipo_c== '21' || $bean->subtipo_c== '22' || $bean->subtipo_c== '25' || $bean->subtipo_c== '26' || $bean->subtipo_c== '28' || $bean->subtipo_c== '29' || $bean->subtipo_c== '30' || $bean->subtipo_c== '32' || $bean->subtipo_c== '34' || $bean->subtipo_c== '35' || $bean->subtipo_c== '36' || $bean->subtipo_c== '37' || $bean->subtipo_c== '38' || $bean->subtipo_c== '40' || $bean->subtipo_c== '42' || $bean->subtipo_c== '43' || $bean->subtipo_c== '44' || $bean->subtipo_c== '45' || $bean->subtipo_c== '46' || $bean->subtipo_c== '48' || $bean->subtipo_c== '49' || $bean->subtipo_c== '51' || $bean->subtipo_c== '56' || $bean->subtipo_c== '57' || $bean->subtipo_c== '58' || $bean->subtipo_c== '59' || $bean->subtipo_c== '60' || $bean->subtipo_c== '61' || $bean->subtipo_c== '62'){
                $fecha_s = $this->dia_seguimiento(1);
            }

            if($bean->subtipo_c== '31' || $bean->subtipo_c== '50' || $bean->subtipo_c== '52' || $bean->subtipo_c== '53' || $bean->subtipo_c== '54' || $bean->subtipo_c== '55'){
                $fecha_s = $this->dia_seguimiento(2);
            }

            if($bean->subtipo_c== '16' || $bean->subtipo_c== '17' || $bean->subtipo_c== '24' || $bean->subtipo_c== '27' || $bean->subtipo_c== '33' || $bean->subtipo_c== '39' || $bean->subtipo_c== '47'){
                $fecha_s = $this->dia_seguimiento(3);
            }

            if($bean->subtipo_c== '23' || $bean->subtipo_c== '41' || $bean->subtipo_c== '78' || $bean->subtipo_c== '79' || $bean->subtipo_c== '80' || $bean->subtipo_c== '81' || $bean->subtipo_c== '82' || $bean->subtipo_c== '83' || $bean->subtipo_c== '84' || $bean->subtipo_c== '85' || $bean->subtipo_c== '86' || $bean->subtipo_c== '87' || $bean->subtipo_c== '88' || $bean->subtipo_c== '92'){
                $fecha_s = $this->dia_seguimiento(5);
            }

            if($bean->subtipo_c== '19'){
                $fecha_s = $this->dia_seguimiento(30);
            }
            */

            if($bean->type=='12' || $bean->type=='13' || $bean->type=='14'){
                //El seguimiento se establece en Horas
                $horas_seguimiento=$this->get_tiempo_seguimiento($bean->type,'Horas',$bean->subtipo_c);

                //ToDo: Comprobar Shifts
                $days_of_week =['monday','tuesday','wednesday','thursday','friday'];
                $days_of_week_map=['monday'=>'1','tuesday'=>'2','wednesday'=>'3','thursday'=>'4','friday'=>'5'];
                $days_of_week_map_invert=['1'=>'monday','2'=>'tuesday','3'=>'wednesday','4'=>'thursday','5'=>'friday'];
                $GLOBALS['log']->fatal('SE ESTABLECEN '.$horas_seguimiento.' Horas DE SEGUIMIENTO');

                $queryShifts="SELECT is_open_monday,
                concat(monday_open_hour,':',monday_open_minutes) open_time_monday,
                concat(monday_close_hour,':',monday_close_minutes) close_time_monday,
                is_open_tuesday,
                concat(tuesday_open_hour,':',tuesday_open_minutes) open_time_tuesday,
                concat(tuesday_close_hour,':',tuesday_close_minutes) close_time_tuesday,
                is_open_wednesday,
                concat(wednesday_open_hour,':',wednesday_open_minutes) open_time_wednesday,
                concat(wednesday_close_hour,':',wednesday_close_minutes) close_time_wednesday,
                is_open_thursday,
                concat(thursday_open_hour,':',thursday_open_minutes) open_time_thursday,
                concat(thursday_close_hour,':',thursday_close_minutes) close_time_thursday,
                is_open_friday,
                concat(friday_open_hour,':',friday_open_minutes) open_time_friday,
                concat(friday_close_hour,':',friday_close_minutes) close_time_friday
                FROM shifts
                ORDER BY date_modified ASC;";

                $queryShiftsResult = $GLOBALS['db']->query($queryShifts);
                $current_day = strtolower(date('l', strtotime("this week")));
                //$current_day="friday";

                //$current_day_number = date('w');
                //$current_day_number ='1';
                
                $horarios=[];
                $matriz_semana=array();
                //Recorriendo query para armar horarios de disponibilidad
                $matriz_semana=[];
                $array_dia=[];
                while ($row = $GLOBALS['db']->fetchByAssoc($queryShiftsResult)) {
                    
                    for ($i=0; $i <count($days_of_week) ; $i++) { 
                        $open_hour=$row['open_time_'.$days_of_week[$i]];
                        $close_hour=$row['close_time_'.$days_of_week[$i]];
                        $horario=$open_hour."-".$close_hour;

                        //Se obtiene el número de día con base al nombre del día
                        $key_dia=array_search($days_of_week_map_invert[$i+1], $days_of_week_map_invert);
                        $array_dia[$key_dia][]=$horario;
                    }
                    array_push($matriz_semana,$array_dia);
                }
                $matriz_semana=$matriz_semana[1];
                
                $dia_actual=$days_of_week_map[strtolower(date('l'))];
                //$dia_actual='5';
            
                $hora_actual=date('H:i');
                //$hora_actual="14:00";
                $dia_suma=0;

                $horario_matutino=$matriz_semana[$dia_actual][0];
                $horario_vespertino=$matriz_semana[$dia_actual][1];

                $limite_inferior_matutino=explode("-",$horario_matutino)[0];
                $limite_superior_matutino=explode("-",$horario_matutino)[1];

                $limite_inferior_vespertino=explode("-",$horario_vespertino)[0];
                $limite_superior_vespertino=explode("-",$horario_vespertino)[1];

                $dia_inicio=$this->get_dia_inicio($hora_actual,$dia_actual,$limite_superior_vespertino);
                //$GLOBALS['log']->fatal("Dia inicio: ".$dia_inicio);
                
                $indice_turno=$this->get_indice_turno($dia_inicio,$dia_actual,$hora_actual,$limite_superior_matutino);
                //$GLOBALS['log']->fatal("Indice turno: ".$indice_turno);

                $intervalo=$matriz_semana[$dia_inicio][$indice_turno];
                //$GLOBALS['log']->fatal("El intervalo para tomar en cuenta es: ".$intervalo);
                $limite_inferior_intervalo=explode("-",$intervalo)[0];
                $limite_superior_intervalo=explode("-",$intervalo)[1];

                $hora_inicio=$this->get_hora_inicio($hora_actual,$dia_inicio,$dia_actual,$limite_inferior_intervalo,$limite_superior_intervalo,$limite_inferior_matutino,$limite_superior_matutino,$limite_inferior_vespertino);
                //$GLOBALS['log']->fatal("La hora inicio es: ".$hora_inicio);
                //Cuando la hora actual supera el intervalo encontrado, quiere decir que se debe establecer el día siguiente
                if(strtotime($hora_actual)>strtotime($limite_superior_intervalo)){
                    $dia_suma++;
                }
                
                $diferencia_horas=$horas_seguimiento;
                
                while($diferencia_horas > 0){
                    $intervalo=$matriz_semana[$dia_inicio][$indice_turno];
                    //$GLOBALS['log']->fatal("El intervalo para tomar en cuenta es: ".$intervalo);
                    $limite_inferior_intervalo=explode("-",$intervalo)[0];
                    $limite_superior_intervalo=explode("-",$intervalo)[1];
                    $date1 = new DateTime($hora_inicio);
                    $date2 = new DateTime($limite_superior_intervalo);
                    //$GLOBALS['log']->fatal("RESTANDO : ".$hora_inicio. " - ".$limite_superior_intervalo);
                    $diff = $date1->diff($date2);
                    $diferencia_en_horas=$diff->format("%h");
                    $diferencia_en_minutos=$diff->format("%i");

                    $diferencia_horas_result=$this->convert_hours_to_decimal($diferencia_en_horas,$diferencia_en_minutos);
                    $diferencia_horas=$diferencia_horas - $diferencia_horas_result;
                    $hora_establecer="";
                    if($diferencia_horas <=0){
                        $interval=$matriz_semana[$dia_inicio][$indice_turno];
                        $limite_inferior_interval=explode("-",$interval)[0];
                        $limite_superior_interval=explode("-",$interval)[1];

                        $hora_original=date_create($limite_superior_interval);
                        date_add($hora_original, date_interval_create_from_date_string(($diferencia_horas*3600).' seconds'));

                        $hora_establecer=date_format($hora_original, 'H:i:s');
                        $GLOBALS['log']->fatal("La hora a establecer es: ".$hora_establecer);
                    }else{
                        if($indice_turno==1){
                            $indice_turno=0;
                            if($dia_inicio==5){
                                $dia_inicio=1;
                                $dia_suma=$dia_suma+3;
                            }else{
                                $dia_inicio+=1;
                                $dia_suma+=1;
                            }
                        }else{
                            $indice_turno=1;
                        }
                        
                        $intervalo_nuevo=$matriz_semana[$dia_inicio][$indice_turno];
                        $limite_inferior_intervalo_nuevo=explode("-",$intervalo_nuevo)[0];
                        $limite_superior_intervalo_nuevo=explode("-",$intervalo_nuevo)[1];

                        $hora_inicio=$limite_inferior_intervalo_nuevo;
                    }
                }
                
                //Estableciendo la fecha de seguimiento->  DiaActual + DiaSuma : HoraEstablecer
                $fecha=date('Y-m-d '.$hora_establecer);

                $fecha_seguimiento= date('Y-m-d H:i:s', strtotime($fecha. ' + '.$dia_suma.' days'));
                $sugar_date_time = new SugarDateTime($fecha_seguimiento);
                $fecha_s = $sugar_date_time->formatDateTime("datetime", "db", $current_user);

            }else if( $bean->type=='5' || $bean->type=='6' || $bean->type=='9' ){ // 5 - Documentos, 6 - Facturación, 9 - Pagos y Saldos
                $GLOBALS['log']->fatal('CASO PARA CARTERA');
                //El seguimiento se establece en Horas
                $dias_seguimiento=$this->get_tiempo_seguimiento($bean->type,'Dias',$bean->subtipo_c);
                $GLOBALS['log']->fatal('SE ESTABLECEN '.$dias_seguimiento.' Dias de seguimiento');
                $fecha_s = $this->dia_seguimiento($dias_seguimiento);

            }else{
                $tiempo=$this->get_tiempo_seguimiento("",'Dias',$bean->subtipo_c);
                $fecha_s = $this->dia_seguimiento($tiempo);
                $GLOBALS['log']->fatal('SE ESTABLECEN '.$tiempo.' DIAS DE SEGUIMIENTO');

            }

            $bean->follow_up_datetime = $fecha_s;
        }else{
            if($bean->fetched_row['status'] != $bean->status && $bean->status == '3'){
                $bean->resolved_datetime = $bean->date_modified;
            }
        }

    }

    function get_dia_inicio($hora_actual,$dia_actual,$limite_superior_vespertino){
        $dia_inicio="";
        if(strtotime($hora_actual) < strtotime($limite_superior_vespertino)){
            $dia_inicio=$dia_actual;
        }

        if(strtotime($hora_actual) >= strtotime($limite_superior_vespertino)){
            $dia_inicio=intval($dia_actual) +1;
        }

        if(strtotime($hora_actual) >= strtotime($limite_superior_vespertino) && $dia_actual=='5'){
            $dia_inicio=1;
        }

        return $dia_inicio;
    }

    function get_indice_turno($dia_inicio,$dia_actual,$hora_actual,$limite_superior_matutino){
        $indice_turno=0;
        
        if($dia_inicio != $dia_actual || ($dia_inicio==$dia_actual && strtotime($hora_actual) < strtotime($limite_superior_matutino))){
            $indice_turno=0;
        }
        if($dia_inicio == $dia_actual && strtotime($hora_actual)>= strtotime($limite_superior_matutino)){
            $indice_turno=1;
        }

        return $indice_turno;
    }

    function get_hora_inicio($hora_actual,$dia_inicio,$dia_actual,$limite_inferior_intervalo,$limite_superior_intervalo,$limite_inferior_matutino,$limite_superior_matutino,$limite_inferior_vespertino){
        if(strtotime($hora_actual) >= strtotime($limite_inferior_intervalo) && strtotime($hora_actual)<=strtotime($limite_superior_intervalo)){
            $hora_inicio=$hora_actual;
        }

        if(strtotime($hora_actual) <= strtotime($limite_inferior_matutino)){
            $hora_inicio=$limite_inferior_matutino;
        }

        if($dia_inicio != $dia_actual){
            $hora_inicio=$limite_inferior_intervalo;
        }

        if(strtotime($hora_actual) >= strtotime($limite_superior_matutino) && strtotime($hora_actual) < strtotime($limite_inferior_vespertino)){
            $hora_inicio=$limite_inferior_vespertino;
        }

        return $hora_inicio;
    }

    function convert_hours_to_decimal($hours,$minutes){
        return $hours + round($minutes / 60, 2);
    }

    function get_tiempo_seguimiento($tipo,$unidad_medida,$subtipo){
        if($tipo != ""){
            $tipo="AND tipo= {$tipo}";
        }
        $subtipo=($subtipo=="") ? " IS NULL" : "= '{$subtipo}'"; 
        
        $query = "SELECT * FROM unifin_casos_control_seguimiento WHERE unidad_medida='{$unidad_medida}' AND subtipo{$subtipo} {$tipo}";
        $GLOBALS['log']->fatal($query);
        $seguimiento='';
        $queryResult = $GLOBALS['db']->query($query);
        while ($row = $GLOBALS['db']->fetchByAssoc($queryResult)) {
            $seguimiento=$row['cantidad'];
        }

        return $seguimiento;
    }

    function dia_seguimiento($add){
        global $current_user;

        $GLOBALS['log']->fatal("Días a sumar: ".$add);
        $hoy=$this->sumDays($add, 'Y-m-d H:i:s');

        $due_date_time = new SugarDateTime($hoy);
        $user_datetime_string = $due_date_time->formatDateTime("datetime", "db", $current_user);

        //$GLOBALS['log']->fatal("FECHA FORMATEADA PARA BD : ".$user_datetime_string);

        return $user_datetime_string;
    }

    function sumDays($days = 0, $format = 'Y-m-d H:i:s') {
        $incrementing = $days > 0;
        $days         = abs($days);
        $actualDate   = date("Y-m-d H:i:s");

        while ($days > 0) {
            $tsDate    = strtotime($actualDate . ' ' . ($incrementing ? '+' : '-') . ' 1 days');
            $actualDate = date('Y-m-d H:i:s', $tsDate);

            if (date('N', $tsDate) < 6) {
                $days--;
            }
        }

        return date($format, strtotime($actualDate));
    }

    function set_private_team($bean, $event, $args){
        global $current_user, $app_list_strings, $db;
        $usuario_logueado=$current_user->id;
        $usuario_creador=$bean->created_by;
        $usuario_asignado=$bean->assigned_user_id;

        if($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id){
            $equiposCasos = array();
            //$usuario_creador="c57e811e-b81a-cde4-d6b4-5626c9961772";
            //Obtiene equipo privado del usuario creador y del usuario asignado
            $beanUserCreador = BeanFactory::getBean('Users', $usuario_creador, array('disable_row_level_security' => true));
            $teamSetBean = new TeamSet();
            //Retrieve the teams from the team_set_id
            $teams = $teamSetBean->getTeamIds($beanUserCreador->team_set_id);

            //$GLOBALS['log']->fatal(print_r($teams,true));


            $User = new User();
            $User->retrieve($usuario_creador);
            $equipoPrivadoCreador=$User->getPrivateTeamID();
            $equiposCasos[] = $equipoPrivadoCreador;

            //$GLOBALS['log']->fatal("PRIVADO CREADOR: ".$equipoPrivadoCreador);

            $UserAsignado = new User();
            $UserAsignado->retrieve($usuario_asignado);
            $equipoPrivadoAsignado=$UserAsignado->getPrivateTeamID();
            $equiposCasos[] = $equipoPrivadoAsignado;

            //$GLOBALS['log']->fatal("PRIVADO ASIGNADO: ".$equipoPrivadoAsignado);
            
            //Funcionalidad para casos con tipo 15,16,17: Cambio nombre, dirección, ambos
            if(!$args['isUpdate'] && ($bean->type=='15' || $bean->type=='16' || $bean->type=='17') ){
                //$GLOBALS['log']->fatal("Add teams 1 ");
                if($bean->assigned_user_id != $current_user->id){
                  //$GLOBALS['log']->fatal("Add teams 2 ");
                    //Recupera equipo de resposanle de seguimiento leasing
                    $responsableLeasing =  $app_list_strings['asesor_leasing_id_list']['1'];
                    $userSegLeasing = new User(); 
                    $userSegLeasing->retrieve($responsableLeasing);
                    $equipoPrivadoAsignado=$userSegLeasing->getPrivateTeamID();
                    $equiposCasos[] = $equipoPrivadoAsignado;
                    //$GLOBALS['log']->fatal("Add teams 3 ". $equipoPrivadoAsignado);
                    
                    //Agrega asesores otros productos
                    $queryUsuarios = "select distinct up.tipo_producto, u.status, u.id user_id, concat(u.first_name,' ' ,u.last_name) user_name , ur.id reports_id, concat(ur.first_name,' ' ,ur.last_name) reports_name
                       from uni_productos up
                       inner join uni_productos_cstm upc on upc.id_c = up.id
                       inner join accounts_uni_productos_1_c ap on ap.accounts_uni_productos_1uni_productos_idb = up.id
                       inner join users u on u.id = up.assigned_user_id
                       left join users ur on ur.id = u.reports_to_id
                       where 
                       ap.accounts_uni_productos_1accounts_ida='".$bean->account_id."'
                       and up.tipo_producto in ('3','4','8')
                       and u.status='Active'
                       and u.is_group = false 
                       limit 10;";
                    $result_usr = $db->query($queryUsuarios);
                    while ($row = $db->fetchByAssoc($result_usr)) {
                        $userProducto = new User(); 
                        $userProducto->retrieve($row['user_id']);
                        $equipoPrivadoAsignado=$userProducto->getPrivateTeamID();
                        $equiposCasos[] = $equipoPrivadoAsignado;
                        //$GLOBALS['log']->fatal("Add teams n ");
                    }
                    
                }

            }
            
            //$GLOBALS['log']->fatal(print_r($equiposCasos,true));
            $bean->load_relationship('teams');

            //Add the teams
            $bean->teams->add(
                $equiposCasos
            );

        }

    }

    function set_asignado_responsable($bean, $event, $args){
        global $db;
        global $current_user;
        $esCAC = isset($current_user->cac_c) ? $current_user->cac_c : false;
        //Se establece asignado y responsable
        // $GLOBALS['log']->fatal("Creado por: ". $bean->created_by);
        // $GLOBALS['log']->fatal("Asignado a: ".$bean->assigned_user_id);
        // $GLOBALS['log']->fatal("Logueado: ".$current_user->id);
        if($bean->producto_c != "B621" && $bean->producto_c !="B601"){
            if( $bean->area_interna_c != "Cobranza" ){

                if(($bean->fetched_row['area_interna_c'] != $bean->area_interna_c) || ($bean->fetched_row['equipo_soporte_c'] != $bean->equipo_soporte_c) || !$args['isUpdate'] ){

                    $area_interna="='".$bean->area_interna_c."'";
                    $equipo_soporte="='".$bean->equipo_soporte_c."'";

                    if( !empty( $bean->account_id ) && $bean->valida_cambio_fiscal_c == 1 ){
                        $GLOBALS['log']->fatal('Entra validación para establecer área interna');
                        $area_interna_por_cambio_razon_social = $this->getAreaInternaParaCambioRazonSocial( $bean->account_id );
                        if( $area_interna_por_cambio_razon_social !== "" ){
                            $GLOBALS['log']->fatal('Se establece área interna por cambio de razón social: '.$area_interna_por_cambio_razon_social);
                            $bean->area_interna_c = $area_interna_por_cambio_razon_social;
                            $area_interna="='".$area_interna_por_cambio_razon_social."'";
                        }
                    }
                    
                    if($bean->area_interna_c==''){
                        $area_interna='IS NULL';
                    }

                    if($bean->equipo_soporte_c==''){
                        $equipo_soporte='IS NULL';
                    }

                    $query="SELECT * FROM unifin_casos_soporte_area WHERE area_interna {$area_interna} AND equipo {$equipo_soporte}";

                    // $GLOBALS['log']->fatal("QUERY PARA OBTENER RESPONSABLE Y ASIGNADO");
                    // $GLOBALS['log']->fatal($query);

                    $responsable="";
                    $asignado="";

                    $result = $GLOBALS['db']->query($query);

                    $registros_encontrados=$result->num_rows;

                    //$GLOBALS['log']->fatal("REGISTROS: ".$registros_encontrados);

                    if($registros_encontrados>0){

                        while($row = $GLOBALS['db']->fetchByAssoc($result)){
                            $id_registro=$row['id'];
                            $responsable=$row['responsable'];
                            $asignado= (!$esCAC || ($esCAC && $bean->created_by == $bean->assigned_user_id) ) ? $row['responsable'] : $bean->assigned_user_id;
                            $ultimo_asignado=intval($row['ultimo_asignado_carrusel']);

                            $asignacion_carrusel=($row['asignacion_carrousel']==1) ? true : false;
                            $responsable_en_carrusel=($row['responsable_carrousel']==1) ? true : false;
                            //Calculando el asignado, dependiendo si se tiene asignación en carrusel
                            if($asignacion_carrusel){
                                $usuarios_carrusel=$this->getUsersReportsTo($responsable);

                                $GLOBALS['log']->fatal(print_r($usuarios_carrusel,true));

                                if($responsable_en_carrusel){
                                    //Se toma en cuenta en el carrusel al usuario responsable, por lo tanto se pone al inicio de la lista de usuarios disponibles
                                    array_unshift($usuarios_carrusel,$responsable);
                                }

                                //Sólo procesa asgnado si: 1) No es caso creado por CAC o 2) Es CAC, pero establece asignado manualmente
                                if(!$esCAC || ($esCAC && $bean->created_by == $bean->assigned_user_id ) )
                                {
                                    $usersVacaciones=array();
                                    //Se arma arreglo para buscar el usuario que se va a asignar, el arreglo armado es del estlo:
                                    /**
                                     * (
                                     * 0:( 
                                     *  id_usuario1=>(
                                     *      fecha_vacacion1,
                                     *      fecha_vacacion2)
                                     *  ),
                                     * 1:(
                                     *  id_usuario2=>(
                                     *      fecha_vacacion1,
                                     *      fecha_vacacion2)
                                     *  ),....
                                     * )
                                     **/
                                    for($i=0;$i<count($usuarios_carrusel);$i++){
                                        $queryHoliday="SELECT holiday_date from holidays WHERE person_id='{$usuarios_carrusel[$i]}' AND deleted=0";
                                        $resultHoliday = $GLOBALS['db']->query($queryHoliday);
                                        $arrUsersVacaciones=array();
                                        $arrHolidays=array();
                                        if($resultHoliday->num_rows > 0){
                                            
                                            while ($row = $db->fetchByAssoc($resultHoliday)){
                                                $hoy=date('Y-m-d');
                                                $holidayDate = $row['holiday_date'];
                                                array_push($arrHolidays,$holidayDate);
                                            }
                                            //array_push($arrUsersVacaciones,$arrHolidays);
                                            //$arrUsersVacaciones[$usuarios_carrusel[$i]]=$arrHolidays;

                                        }else{
                                            array_push($arrHolidays,'');
                                        }
                                        array_push($usersVacaciones,$arrHolidays);
                                        //$usersVacaciones[$usuarios_carrusel[$i]]=$arrUsersVacaciones;
                                    }

                                    $GLOBALS['log']->fatal("ARREGLO USERS VACACIONES");
                                    $GLOBALS['log']->fatal(print_r($usersVacaciones,true));
                                    
                                    $conteoArregloUsuariosCompleto=count($usersVacaciones);
                                    $conteo=0;
                                    //for ($i=$aux_ultimo_asignado; $i < $conteoArregloUsuariosCompleto; $i++) {
                                    $index=$ultimo_asignado;
                                    while($index < $conteoArregloUsuariosCompleto){
                                        $hoy=date('Y-m-d');
                                        $GLOBALS['log']->fatal("Buscando en el indice: ".$index." la fecha actual ".$hoy);
                                        $arregloFechas=$usersVacaciones[$index];
                                        
                                        if(in_array($hoy,$arregloFechas)){
                                            $GLOBALS['log']->fatal("Usuario no disponible, tiene vacaciones");
                                            $conteo+=1;

                                            $GLOBALS['log']->fatal("index: ".$index);
                                            //$GLOBALS['log']->fatal("count(usersVacaciones): ".count($usersVacaciones));
                                            //$GLOBALS['log']->fatal("conteo: ".$conteo);
                                            //Si no se ha encontrado el usuario disponible,
                                            //Se aplican 2 validaciones:
                                            //Si no se han recorrido todos los usuarios disponibles y ya se llegó al final del arreglo
                                            if($index==count($usersVacaciones)-1 && $conteo < count($usersVacaciones)){
                                                $index=-1;
                                                $conteoArregloUsuariosCompleto=$conteoArregloUsuariosCompleto-$conteo;
                                                $GLOBALS['log']->fatal("conteo: ".$conteo);
                                                $GLOBALS['log']->fatal("conteoArregloUsuariosCompleto: ".$conteoArregloUsuariosCompleto);
                                                $GLOBALS['log']->fatal("No se encontró usuario disponible, se reinicia el ciclo for");
                                            }
                                            if($conteo == count($usersVacaciones)){
                                                //En este caso, ya se recorrieron todos los usuarios que reportan, pero ninguno está disponible para asignación
                                                //ya se llegó al conteo total del ciclo, se procede a asignar al usuario responsable
                                                $index=$conteoArregloUsuariosCompleto;
                                                $GLOBALS['log']->fatal("No se encontró usuario disponible, se procede a asignar al responsable");
                                                array_unshift($usuarios_carrusel,$responsable);
                                                $ultimo_asignado=0;
                                            }
                                        }else{
                                            //Rompe el ciclo ya que si no se encuentra la fecha, quiere decir que el usuario se encuentra disponible y se puede asignar
                                            $ultimo_asignado=$index;
                                            $index=$conteoArregloUsuariosCompleto;
                                            $GLOBALS['log']->fatal("Indice asignar: ".$ultimo_asignado);
                                            $GLOBALS['log']->fatal("Se rompe ciclo, el usuario se encuentra disponible ".$usuarios_carrusel[$ultimo_asignado]);
                                        }
                                        $index++;
                                    }
                                    //Antes de asignar, se toma en cuenta el valor del último asignado
                                    $asignado=$usuarios_carrusel[$ultimo_asignado];

                                    $ultimo_asignado+=1;

                                    if($ultimo_asignado==count($usuarios_carrusel)){
                                        //En caso de que el contador llegue al mismo número de usuarios disponibles para asignación, se procede a reiniciar dicho contador
                                        $ultimo_asignado=0;
                                    }

                                    $queryUpdate="UPDATE unifin_casos_soporte_area SET ultimo_asignado_carrusel='{$ultimo_asignado}' WHERE id='{$id_registro}'";

                                    $resultUpdate=$GLOBALS['db']->query($queryUpdate);
                                }else{
                                    $asignado=$bean->assigned_user_id;
                                }
                            }
                        }

                    }else{
                        if($esCAC){
                            $responsable=$bean->user_id_c;
                            $asignado=$bean->assigned_user_id;
                        }else{
                            $responsable=$current_user->id;
                            $asignado=$current_user->id;
                        }
                    }

                    //En caso de que el área interna sea de Uniclick, el usuario asignado, autmáticamente se asigna con Samuel Álvarez,
                    //esto, se establece con base a lo requerido para el proceso de seguimiento al cambio de razón social y direcciones
                    $idSamuel = "92b04f7d-e547-9d4f-c96a-5a31da014bdd";
                    if( $bean->area_interna_c == 'Uniclick' ){
                        $bean->assigned_user_id=$idSamuel;
                    }else{
                        $bean->assigned_user_id=$asignado;
                    }
                    $bean->user_id_c=$responsable;

                    //ENVIANDO NOTIFICACIÓN
                    $notify_user = BeanFactory::retrieveBean('Users', $bean->assigned_user_id);
                    $admin = Administration::getSettings();

                    $xtpl= $this->createNotificationEmailTemplate("Case", $notify_user,$bean);

                    $subject      = $xtpl->text("Case" . "_Subject");
                    $textBody     = trim($xtpl->text("Case"));

                    $this->enviarNotificacion($notify_user,$admin,$subject,$textBody);

                }
            }else{
                //Condición para área de Administración de Cartera (Cobranza)
                //En la creación de un caso con usuario de CAC y área interna Cobranza, entra proceso para establecer responsables
                if( !$args['isUpdate'] && $esCAC ){
                    $producto = $bean->producto_c;
                    
                    if( $producto != "" ){
                        $query="SELECT * FROM unifin_casos_soporte_area WHERE producto = '{$producto}'";

                        $GLOBALS['log']->fatal("QUERY PARA OBTENER RESPONSABLE Y ASIGNADO DE COBRANZA");
                        $GLOBALS['log']->fatal($query);

                        $result = $GLOBALS['db']->query($query);

                        $registros_encontrados=$result->num_rows;
                        $responsable = "";
                        $asignado = "";
                        if($registros_encontrados>0){
                            while($row = $GLOBALS['db']->fetchByAssoc($result)){
                                $responsable = $row['responsable'];
                            }

                        }

                        //Se establece responsable_interno y asignado con base a la consulta a la bd
                        $GLOBALS['log']->fatal("Responsable y asignado: ".$responsable);
                        $bean->assigned_user_id = $responsable;
                        $bean->user_id_c = $responsable;

                        //ENVIANDO NOTIFICACIÓN
                        $notify_user = BeanFactory::retrieveBean('Users', $responsable);
                        $admin = Administration::getSettings();

                        $xtpl= $this->createNotificationEmailTemplate("Case", $notify_user,$bean);

                        $subject      = $xtpl->text("Case" . "_Subject");
                        $textBody     = trim($xtpl->text("Case"));

                        $this->enviarNotificacion($notify_user,$admin,$subject,$textBody);

                    }
                    

                }

            }
            
        }

    }

    /*
    * Con base a los productos relacionados a la Cuenta, se establece el Área interna para el proceso que crea casos en el cambio de razón social y direcciones
    * Si el producto Uniclick en tipo_cuenta es Cliente ('3') y no es Cliente en ningún otro Producto, el área interna para asignar será Uniclick
    * Si en cualquier producto en tipo_cuenta es Cliente ('3'), se considera como multiproducto, por lo tanto, se asigna el área de Crédito
    */
    function getAreaInternaParaCambioRazonSocial( $idCuentaRelacionada ){

        $area_interna = "";
        $beanPersona = BeanFactory::getBean("Accounts", $idCuentaRelacionada, array('disable_row_level_security' => true));

        if( !empty( $beanPersona ) ){
            if ($beanPersona->load_relationship('accounts_uni_productos_1')) {
                //Recupera Productos para conocer el tipo de cuenta por cada uno
                $relateProduct = $beanPersona->accounts_uni_productos_1->getBeans($beanPersona->id,array('disable_row_level_security' => true));
                $array_tipo_cuenta_producto = array();
                foreach ($relateProduct as $product) {
                    //Recupera valores por producto
                    $tipoCuenta = $product->tipo_cuenta;
                    $tipoProducto = $product->tipo_producto;
                    $subtipo = $product->subtipo_cuenta; // 11 - Venta Activo
                    if( $subtipo != "11" ){
                        switch ($tipoProducto) {
                            case '1': //Leasing
                                $array_tipo_cuenta_producto['leasing'] = $tipoCuenta;
                                break;
                            case '2': //Crédito Simple
                                $array_tipo_cuenta_producto['cs'] = $tipoCuenta;
                                break;
                            case '3': //Credito-Automotriz
                                $array_tipo_cuenta_producto['ca'] = $tipoCuenta;
                                break;
                            case '4': //Factoraje
                                $array_tipo_cuenta_producto['factoraje'] = $tipoCuenta;
                                break;
                            case '6': //Fleet
                                $array_tipo_cuenta_producto['fleet'] = $tipoCuenta;
                                break;
                            case '8': //Uniclick
                                $array_tipo_cuenta_producto['uniclick'] = $tipoCuenta;
                                break;
                            case '14': //Tarjeta Crédito
                                $array_tipo_cuenta_producto['tc'] = $tipoCuenta;
                                break;
                            
                        }

                    }
                    
                }

                //Recorre arreglo generado para conocer si es multiproducto y el caso se debe asignar a Area Interna Crédito o Uniclick
                $contador_cliente = 0;
                $contador_cliente_uniclick = 0;
                foreach ( $array_tipo_cuenta_producto as $key => $value ){
                    if( $value == '3' ){
                        if( $key == 'uniclick' ){
                            $contador_cliente_uniclick += 1; 
                        }else{
                            $contador_cliente += 1;
                        }
                    }
                }
                if( $contador_cliente_uniclick > 0 && $contador_cliente == 0 ){
                    //ES CLIENTE UNICLICK, SE ESTABLECE ÁREA INTERNA UNICLICK
                    $GLOBALS['log']->fatal("ES CLIENTE UNICLICK, SE ESTABLECE ÁREA INTERNA UNICLICK");
                    $area_interna = 'Uniclick';
                
                }
                if( $contador_cliente > 0 ){
                    //ES MULTIPRODUCTO, SE ESTABLECE ÁREA INTERNA CRÉDITO
                    $GLOBALS['log']->fatal("ES MULTIPRODUCTO, SE ESTABLECE ÁREA INTERNA CRÉDITO");
                    $area_interna = 'Credito';
                }
                
                if( $contador_cliente == 0 && $contador_cliente_uniclick == 0){
                    //NO ES CLIENTE EN NINGÚN PRODUCTO
                    $GLOBALS['log']->fatal("NO ES CLIENTE EN NINGÚN PRODUCTO");
                    $area_interna = '';
                }

            }
        }

        return $area_interna;

    }

    public function createNotificationEmailTemplate($templateName, $notify_user = null,$bean)
    {
        global $sugar_config,
               $current_user,
               $sugar_version,
            $locale;

        if ($notify_user && !empty($notify_user->preferred_language)) {
            $currentLanguage = $notify_user->preferred_language;
        } else {
            $currentLanguage = $locale->getAuthenticatedUserLanguage();
        }

        $xtpl = new XTemplate(get_notify_template_file($currentLanguage));

        if (in_array('set_notification_body', get_class_methods($bean))) {
            $xtpl = $this->set_notification_body($xtpl, $bean);
            //$GLOBALS['log']->fatal("IF DE FUNCIÓN DE ERROR");
        } else {
            //Default uses OBJECT key for both subject and body (see en_us.notify_template.html)
            $singularModuleLabel = $GLOBALS['app_list_strings']['moduleListSingular']["Cases"];
            $xtpl->assign("OBJECT", $singularModuleLabel);
        }

        $xtpl->assign("ASSIGNED_USER", $bean->assigned_user_name);
        $xtpl->assign("ASSIGNER", $current_user->name);

        $parsedSiteUrl = parse_url($sugar_config['site_url']);
        $host          = $parsedSiteUrl['host'];

        if (!isset($parsedSiteUrl['port'])) {
            $parsedSiteUrl['port'] = 80;
        }

        $port		= ($parsedSiteUrl['port'] != 80) ? ":".$parsedSiteUrl['port'] : '';
        $path       = isset($parsedSiteUrl['path']) ? rtrim($parsedSiteUrl['path'], '/') : '';
        $cleanUrl	= "{$parsedSiteUrl['scheme']}://{$host}{$port}{$path}";

        if (isModuleBWC("Cases")) {
            $xtpl->assign("URL", $cleanUrl."/#bwc/index.php?module={$this->module_dir}&action=DetailView&record={$this->id}");
        } else {
            $xtpl->assign('URL', $cleanUrl . '/index.php#' . 'Cases' . '/' . $bean->id);
        }

        $xtpl->assign("SUGAR", "Sugar v{$sugar_version}");
        $xtpl->parse($templateName);
        $xtpl->parse($templateName . "_Subject");

        return $xtpl;
    }

    public function set_notification_body($xtpl, $case)
    {
        global $app_list_strings;

        $xtpl->assign("CASE_SUBJECT", $case->name);
        $xtpl->assign(
            "CASE_PRIORITY",
            (isset($case->priority) ? $app_list_strings['case_priority_dom'][$case->priority]:""));
        $xtpl->assign("CASE_STATUS", (isset($case->status) ? $app_list_strings['case_status_dom'][$case->status]:""));
        $xtpl->assign("CASE_DESCRIPTION", $case->description);

        return $xtpl;
    }
    public function enviarNotificacion($notify_user,$admin,$subject,$textBody){

        try {
            $mailer                   = $this->create_notification_email($notify_user);
            $mailTransmissionProtocol = $mailer->getMailTransmissionProtocol();

            // by default, use the following admin settings for the From email header
            $fromEmail = $admin->settings['notify_fromaddress'];
            $fromName  = $admin->settings['notify_fromname'];

            if (!empty($admin->settings['notify_send_from_assigning_user'])) {
                // the "notify_send_from_assigning_user" admin setting is set
                // use the current user's email address and name for the From email header
                $usersEmail = $GLOBALS["current_user"]->emailAddress->getReplyToAddress($GLOBALS["current_user"]);
                $usersName  = $GLOBALS["current_user"]->full_name;

                // only use it if a valid email address is returned for the current user
                if (!empty($usersEmail)) {
                    $fromEmail = $usersEmail;
                    $fromName = $usersName;
                }
            }

            // set the From and Reply-To email headers according to the values determined above (either default
            // or current user)
            $from = new EmailIdentity($fromEmail, $fromName);
            $mailer->setHeader(EmailHeaders::From, $from);
            $mailer->setHeader(EmailHeaders::ReplyTo, $from);

            // set the subject of the email
            $mailer->setSubject($subject);

            // set the body of the email... looks to be plain-text only
            $mailer->setTextBody($textBody);

            // set html text of the email
            /*
            if ($htmlBody && !isTruthy($emailTemplate->text_only)) {
                $mailer->setHtmlBody($htmlBody);
            }
            */

            // add the recipient
            $recipientEmailAddress = $notify_user->emailAddress->getPrimaryAddress($notify_user);
            $recipientName         = $notify_user->full_name;

            try {
                $mailer->addRecipientsTo(new EmailIdentity($recipientEmailAddress, $recipientName));
            } catch (MailerException $me) {
                $GLOBALS['log']->warn("Notifications: no e-mail address set for user {$notify_user->user_name}, cancelling send");
            }

            $mailer->send();
            $GLOBALS['log']->info("Notifications: e-mail successfully sent");
        } catch (MailerException $me) {
            $message = $me->getMessage();

            switch ($me->getCode()) {
                case MailerException::FailedToConnectToRemoteServer:
                    $GLOBALS['log']->fatal("Notifications: error sending e-mail, smtp server was not found ");
                    break;
                default:
                    $GLOBALS['log']->fatal("Notifications: error sending e-mail (method: {$mailTransmissionProtocol}), (error: {$message})");
                    break;
            }
        }

    }

    protected function create_notification_email($notify_user) {
        return MailerFactory::getSystemDefaultMailer();
    }


    public function getUsersReportsTo($responsable){

        $array_usuarios=array();

        $queryUsersReports="SELECT id FROM users
        WHERE reports_to_id='{$responsable}'
        AND status='Active' and deleted=0 ORDER BY user_name";

        $resultUsuarios = $GLOBALS['db']->query($queryUsersReports);

        $cantidad_usuarios=$resultUsuarios->num_rows;

        if($cantidad_usuarios>0){
            while($row = $GLOBALS['db']->fetchByAssoc($resultUsuarios)){
                array_push($array_usuarios,$row['id']);
            }
        }

        return $array_usuarios;

    }




}
