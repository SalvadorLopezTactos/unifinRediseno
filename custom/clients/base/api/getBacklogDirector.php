<?php
/*/**
 * Created by Tactos:AF
 * Date: 2022-09-28
 * Time: 11:45 AM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class getBacklogDirector extends SugarApi
{

    public function registerApiRest()
    {
        return array(
            'getBacklogDirector' => array(
                'reqType' => 'GET',
                'path' => array('getBacklogDirector'),
                'pathVars' => array(''),
                'method' => 'getBacklogsDirector',
                'shortHelp' => 'Endpoint para recuperar backlogs asociados a un Director Equipo/Regional',
            ),
        );
    }

    public function getBacklogsDirector($api, $args){
        //Varibles globales
        global $app_list_strings, $current_user,$sugar_config,$db;

        //Declara estructura para gestión de backlogs
        $respuestaBL = array (
            "Prospecto" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            ),
            "Devuelta" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            ),
            "Credito" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            ),
            "Rechazada" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            ),
            "AutorizadaSinSolicitud" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            ),
            "AutorizadaConSolicitud" => array(
                "SumaBLS" => 0,
                "totalBLS" => 0,
                "Registros" => array(
                )
            )
        );

        //Recupera información de usuario logueado
        $posicionOperativa = $current_user->posicion_operativa_c; //1 - Dir Equipo, 2- Dir Regional
        $equipoPrincipal = $current_user->equipo_c;
        $region = $current_user->region_c;
        $equiposPromocion = $current_user->equipos_c;
        $equiposPromocion = str_replace("^","'",$equiposPromocion);
        $esDirEquipo = (strpos($posicionOperativa,'^1^') === false) ? false : true;
        $esDirRegion = (strpos($posicionOperativa,'^2^') === false) ? false : true;

        //Valida Posición operativa de usuario para definir consulta
        if ($esDirRegion) {
            //Consulta Dir Regional
            $queryBL = "select
                  	b.equipo Equipo,
                  	b.progreso EstadoSolicitud,
                      b.anio Anio,
                      b.mes Mes,
                      bc.etapa_c Etapa,
                      bc.producto_c Producto,
                      sum(bc.monto_final_comprometido_c) Monto,
                      count(bc.monto_final_comprometido_c) BacklogsAgrupados
                  from
                  	lev_backlog b
                  	inner join lev_backlog_cstm bc on bc.id_c = b.id
                      inner join users_cstm uc on uc.id_c = b.assigned_user_id
                  where
                  	concat(b.anio,lpad(b.mes,2,0)) >= concat(year(now()), lpad(month(now()),2,0) ) -- Mes actual y superiores
                      and uc.region_c = '{$region}' -- Variable DirRegional
                  group by
                  	Equipo, EstadoSolicitud, Anio, Mes,  bc.etapa_c, bc.producto_c
                  order by
                  	Equipo asc
                  limit 1000
            ;";
        }elseif ($esDirEquipo) {
            //Consulta Dir Equipo
            $queryBL = "select
                    b.numero_de_backlog NoBacklog,
                      b.progreso EstadoSolicitud,
                      b.anio Anio,
                      b.mes Mes,
                      concat(b.anio,lpad(b.mes,2,0)) AnioMes,
                      bc.etapa_c Etapa,
                      bc.monto_final_comprometido_c Monto,
                      bc.producto_c,
                      a.name Cliente,
                      a.id ClienteId,
                      concat(u.first_name,' ', u.last_name) Asesor,
                      u.id AsesorId,
                      u.reports_to_id ReportaA,
                      uc.equipo_c Equipo,
                      uc.region_c Region
                  from
                    lev_backlog b
                    inner join lev_backlog_cstm bc on bc.id_c = b.id
                      inner join accounts a on a.id = b.account_id_c
                      inner join users u on u.id = b.assigned_user_id
                      inner join users_cstm uc on uc.id_c = u.id
                  where
                    concat(b.anio,lpad(b.mes,2,0)) >= concat(year(now()), lpad(month(now()),2,0) ) -- Mes actual y superiores
                    and uc.equipo_c in ({$equiposPromocion}) -- Variable DirEquipo
                  order by
                    AnioMes asc, Cliente asc
                  limit 1000
            ;";
        }else {
          $queryBL = 'select null'; //Valor para no recuperar información
        }

        //Ejecuta e interpreta resultado
        $resultBL = $db->query($queryBL);
        while ($row = $db->fetchByAssoc($resultBL)) {
            $users[] = $row['id'];
            //Agrupa por estado
            switch ($row['Etapa']) {
              case 1: //Autorizada:: 1- Con Solicitud, 2- Sin solicitud
                if($row['EstadoSolicitud'] == '1'){
                    $respuestaBL['AutorizadaConSolicitud']['SumaBLS'] += $row['Monto'];
                    $respuestaBL['AutorizadaConSolicitud']['totalBLS'] ++;
                    $respuestaBL['AutorizadaConSolicitud']['Registros'][] = $row;
                }else{
                    $respuestaBL['AutorizadaSinSolicitud']['SumaBLS'] += $row['Monto'];
                    $respuestaBL['AutorizadaSinSolicitud']['totalBLS'] ++;
                    $respuestaBL['AutorizadaSinSolicitud']['Registros'][] = $row;
                }
                break;
              case 2: //Rechazada
                $respuestaBL['Rechazada']['SumaBLS'] += $row['Monto'];
                $respuestaBL['Rechazada']['totalBLS'] ++;
                $respuestaBL['Rechazada']['Registros'][] = $row;
                break;
              case 3: //Prospecto
                $respuestaBL['Prospecto']['SumaBLS'] += $row['Monto'];
                $respuestaBL['Prospecto']['totalBLS'] ++;
                $respuestaBL['Prospecto']['Registros'][] = $row;
                break;
              case 4: //Crédito
                $respuestaBL['Credito']['SumaBLS'] += $row['Monto'];
                $respuestaBL['Credito']['totalBLS'] ++;
                $respuestaBL['Credito']['Registros'][] = $row;
                break;
              case 5: //Devuelta
                $respuestaBL['Devuelta']['SumaBLS'] += $row['Monto'];
                $respuestaBL['Devuelta']['totalBLS'] ++;
                $respuestaBL['Devuelta']['Registros'][] = $row;
                break;
              default:
                $no = true;
            }
        }

        //Salida de servicio
        return $respuestaBL;
    }

}
