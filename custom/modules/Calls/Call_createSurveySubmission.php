<?php
/**
 * Created by JG.
 * User: tactos
 * Date: 8/02/21
 * Time: 08:35 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/utils.php');

class Call_createSurveySubmission
{
    function createSurveySubmissionCalls($bean, $event, $arguments)
    {
        //Declara variables globales
        global $db, $current_user, $app_list_strings;
        /* Criterios:
            1) Llamada asignada a Cuenta
            2) Usuario que cierra llamada contiene producto Leasing = 1
            3) Llamada en estatus Realizado
            4) Resultado de llamada; Checklist_expediente,Llamada_servicio
			      5) Puesto usuario asignado a la llamada sea de Leasing
        */
        $puesto_usuario = $bean->asignado_puesto_c;
        $lista_puestos = $app_list_strings['puestos_encuestas_list'];
        if ($bean->parent_type == 'Accounts' && !empty($bean->parent_id) && $current_user->tipodeproducto_c=='1' && array_key_exists($puesto_usuario, $lista_puestos) && $bean->status == "Held" && $bean->fetched_row['status'] != $bean->status && ($bean->tct_resultado_llamada_ddw_c == "Checklist_expediente" || $bean->tct_resultado_llamada_ddw_c == "Llamada_servicio" )) {
            //$GLOBALS['log']->fatal('*****ENTRA CONDICIÓN CREACION DE LLAMADA PARA ENCUESTA*****');
			      // Recupera variables de llamada
            $idCall = $bean->id;
            $idParentCalls = isset($bean->parent_id) ? $bean->parent_id : '';
            $idPersonaCalls = isset($bean->persona_relacion_c) ? $bean->persona_relacion_c : '';
            $idUserCalls = $current_user->id;
            $nameUserCalls = $current_user->full_name;
            //$listaEncuestas = isset($app_list_strings['encuestas_ids_list']) ? $app_list_strings['encuestas_ids_list'] : '';
            //$idEncuesta = isset($listaEncuestas['encuesta_calls_heald_accounts']) ? $listaEncuestas['encuesta_calls_heald_accounts'] : '';
	          //Consulta Id de Encuesta NPS
      			$queryNPS = "select id from qpro_gestion_encuestas where name = 'Encuesta NPS' and deleted = 0";
      			$resultNPS = $db->query($queryNPS);
      			$rowNPS = $db->fetchByAssoc($resultNPS);
      			$idEncuesta = $rowNPS['id'];
      			$idParent = '';
            $idSubmission = '';
            $emailPersona = '';
            //Recupera cuenta asociada
            $beanAccount = BeanFactory::getBean('Accounts', $idParentCalls, array('disable_row_level_security' => true));
            //Valida que sea Cliente
            if($beanAccount->tipo_registro_cuenta_c == '3'){
                //$GLOBALS['log']->fatal('*****CUENTA RELACIONADA ES CLIENTE*****');
                //Moral: Valida que tenga persona asociada
                if ($beanAccount->tipodepersona_c == 'Persona Moral') {
                    //$GLOBALS['log']->fatal('*****CUENTA RELACIONADA ES PERSONA MORAL*****');
                    if (!empty($idPersonaCalls)) {
				                $idParent = $idPersonaCalls;
                        //Recupera persona relacionada con relación negocio
                        $personaRelacionada = false;
                        $queryP = "select t2.account_id1_c,ac.name,t1.relaciones_activas
                          FROM rel_relaciones_accounts_1_c rel
                            INNER JOIN rel_relaciones t1
                              ON t1.id=rel.rel_relaciones_accounts_1rel_relaciones_idb
                            INNER JOIN rel_relaciones_cstm t2
                              ON t2.id_c=t1.id
                            INNER join accounts ac
                            ON ac.id=t2.account_id1_c
                          WHERE rel.rel_relaciones_accounts_1accounts_ida='{$idParentCalls}'
                                AND t2.account_id1_c='{$idPersonaCalls}';";
                        $resultP = $db->query($queryP);
                        while ($row = $db->fetchByAssoc($resultP)) {
                            $personaRelacionada = true;
                        }
                        if ($personaRelacionada) {
                            //$GLOBALS['log']->fatal('*****CUENTA RELACIONADA TIENE RELACION DE TIPO NEGOCIO*****');
                            $beanPersona = BeanFactory::getBean('Accounts', $idPersonaCalls, array('disable_row_level_security' => true));
                            $namePersonaCalls = $beanPersona->name;
                            $emailPersona = $beanPersona->email1;
                            $nameParentCalls = $beanAccount->name;
                        }
                    }
                } else {
                    //$GLOBALS['log']->fatal('*****CUENTA RELACIONADA'.$idParentCalls.' NO ES PERSONA MORAL*****');
	                  $idParent = $idParentCalls;
                    $namePersonaCalls = $beanAccount->name;
                    $emailPersona = $beanAccount->email1;
                    $nameParentCalls = $beanAccount->name;
                }
                //Valida generación de encuesta en último trimestre
                $encuestaExistente = $this->existeEncuestaTrimestre($idEncuesta, $idParent, $idUserCalls);
                if (!$encuestaExistente && !empty($emailPersona) && !empty($idEncuesta)) {
                    // $GLOBALS['log']->fatal('*****CUENTA RELACIONADA'.$idParentCalls.' NO TIENE ENCUESTA EN ULTIMO TRIMESTRE, PROCEDE A GENERAR ENCUESTA*****');
                    // $GLOBALS['log']->fatal('*****EMAIL:'.$emailPersona.'*****');
                    // $GLOBALS['log']->fatal('*****ID ENCUESTA:'.$idEncuesta.'*****');
                    //Ejecuta proceso para insertar registro en Encuestas
          					$beanEncuesta= BeanFactory::newBean('QPRO_Encuestas');
          					$beanEncuesta->name = $namePersonaCalls;
          					$beanEncuesta->related_module = "Accounts";
          					$beanEncuesta->account_id_c = $idParent;
          					$beanEncuesta->qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida = $idEncuesta;
          					$beanEncuesta->assigned_user_id = $idUserCalls;
          					$beanEncuesta->save();
                }
            }
        }
    }

    //Función para validar existencia de encuesta en el mismo trimestre
    function existeEncuestaTrimestre($idEncuesta, $idParent, $idUserCalls)
    {
        /*
          Validación:
            mismo trimestre y mismo año
            misma encuesta
            misma cuenta
            mismo asesor
        */
        global $db;
        $existente = false;
        $query = "select a.id, a.name, year(a.date_entered) anio, quarter(a.date_entered) q, a.related_id, a.assigned_user_id
          from qpro_encuestas a, qpro_gestion_encuestas_qpro_encuestas_c b where a.id = b.qpro_gestion_encuestas_qpro_encuestasqpro_encuestas_idb
          and a.deleted = 0 and b.deleted = 0 and a.related_id = '{$idParent}' and year(a.date_entered) = year(now()) and quarter(a.date_entered) = quarter(now())
          and a.assigned_user_id = '{$idUserCalls}' and qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida = '{$idEncuesta}'";
        $result = $db->query($query);
        while ($row = $db->fetchByAssoc($result)) {
            $existente = true;
        }
        //Regresa validación de encuesta existene
        return $existente;
    }
}
