<?php
// Creado por: Erick de Jesús
// tactos
require_once 'modules/Teams/TeamSet.php';
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

    function set_private_team($bean, $event, $args){
        global $current_user;
        $usuario_logueado=$current_user->id;
        $usuario_creador=$bean->created_by;
        $usuario_asignado=$bean->assigned_user_id;

        if($bean->fetched_row['assigned_user_id'] != $bean->assigned_user_id){
            
            //$usuario_creador="c57e811e-b81a-cde4-d6b4-5626c9961772";
            //Obtiene equipo privado del usuario creador y del usuario asignado
            $beanUserCreador = BeanFactory::getBean('Users', $usuario_creador, array('disable_row_level_security' => true));
            $teamSetBean = new TeamSet();
            //Retrieve the teams from the team_set_id
            $teams = $teamSetBean->getTeamIds($beanUserCreador->team_set_id);
            
            $GLOBALS['log']->fatal(print_r($teams,true));

            
            $User = new User();
            $User->retrieve($usuario_creador);
            $equipoPrivadoCreador=$User->getPrivateTeamID();
            
            $GLOBALS['log']->fatal("PRIVADO CREADOR: ".$equipoPrivadoCreador);

            $UserAsignado = new User();
            $UserAsignado->retrieve($usuario_asignado);
            $equipoPrivadoAsignado=$UserAsignado->getPrivateTeamID();

            $GLOBALS['log']->fatal("PRIVADO ASIGNADO: ".$equipoPrivadoAsignado);

            $bean->load_relationship('teams');

            //Add the teams
            $bean->teams->add(
                array(
                    $equipoPrivadoCreador, 
                    $equipoPrivadoAsignado
                )
            );

        }

    }

    function set_asignado_responsable($bean, $event, $args){
        global $db;
        //Se establece asignado y responsable
        if(($bean->fetched_row['area_interna_c'] != $bean->area_interna_c) || ($bean->fetched_row['equipo_soporte_c'] != $bean->equipo_soporte_c) || !$args['isUpdate']){

            $area_interna="='".$bean->area_interna_c."'";
            $equipo_soporte="='".$bean->equipo_soporte_c."'";

            if($bean->area_interna_c==''){
                $area_interna='IS NULL';
            }

            if($bean->equipo_soporte_c==''){
                $equipo_soporte='IS NULL';
            }

            $query="SELECT * FROM unifin_casos_soporte_area WHERE area_interna {$area_interna} AND equipo {$equipo_soporte}";

            $GLOBALS['log']->fatal("QUERY PARA OBTENER RESPONSABLE Y ASIGNADO");
            $GLOBALS['log']->fatal($query);

            $responsable="";
            $asignado="";
            
            $result = $GLOBALS['db']->query($query);

            $registros_encontrados=$result->num_rows;

            $GLOBALS['log']->fatal("REGISTROS: ".$registros_encontrados);
        
            if($registros_encontrados>0){

                while($row = $GLOBALS['db']->fetchByAssoc($result)){
                    $id_registro=$row['id'];
                    $responsable=$row['responsable'];
                    $asignado=$row['responsable'];
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

                        //Antes de asignar, se toma en cuenta el valor del último asignado
                        $asignado=$usuarios_carrusel[$ultimo_asignado];
                        
                        $ultimo_asignado+=1;

                        if($ultimo_asignado==count($usuarios_carrusel)){
                            //En caso de que el contador llegue al mismo número de usuarios disponibles para asignación, se procede a reiniciar dicho contador
                            $ultimo_asignado=0;
                        }

                        $queryUpdate="UPDATE unifin_casos_soporte_area SET ultimo_asignado_carrusel='{$ultimo_asignado}' WHERE id='{$id_registro}'";

                        $resultUpdate=$GLOBALS['db']->query($queryUpdate);
                    }
                }

            }

            $bean->assigned_user_id=$responsable;
            $bean->user_id_c=$asignado;
        }
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
