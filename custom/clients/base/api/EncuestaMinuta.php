<?php
/**
 * @author: Tactos.AF 2019-07-10
 * Enpoint habilitado para extender funcionalidad de componente SurveyRocket.
 *
 */


if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/utils.php');
class EncuestaMinuta extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POST_Survey_Submission' => array(
                'reqType' => 'POST',
                'path' => array('createSubmission'),
                'pathVars' => array(''),
                'method' => 'createSurveySubmission',
                'shortHelp' => 'Ingresa registro en tablas: bc_survey_submission y bc_survey_submission_bc_survey_c para identificar a que usuario se genera la encuesta desde minuta',
            ),
        );
    }

    public function createSurveySubmission ($api, $args){
        //Recupera variables
        global $db, $current_user, $app_list_strings;
        $idReunion = $args['data']['idMeeting'];
        $idUsuario = $args['data']['idUser'];
        $nombreUsuario = $args['data']['nameUser'];
        $listaEncuestas = $app_list_strings['encuestas_ids_list'];
        $idEncuesta = $listaEncuestas['minuta_agente_telefonico_usuario'];
        $idSubmission = "";

        //Valida existencia de idReunion
        if(empty($idReunion)|| $idReunion == "" ){
            return false;
        }

        //Genera consulta a submission
        //$GLOBALS['log']->fatal('TCT - Consulta BD: Identifica si ya existe envío para survey');
        $query = "select id from bc_survey_submission WHERE parent_id=? and parent_type='Meetings' and deleted=0";
        $conn = $db->getConnection();
        $stmt = $conn->executeQuery($query, array($idReunion));
        foreach($stmt->fetchAll() as $row){
            $idSubmission = $row['id'];
            //$GLOBALS['log']->fatal('TCT - Recupera BD: idSubmission: '. $idSubmission);
        }

        //Valida existencia de submission
        if (empty($idSubmission) || $idSubmission == "") {
            //Ejecuta proceso para insertar registro
            $idSubmission = create_guid();
            //$GLOBALS['log']->fatal('TCT - Genera GUID: idSubmission: '. $idSubmission);

            //Genera insert a tabla bc_survey_submission: Registro de envío de encuesta a destinatario
            $insertS = "INSERT INTO bc_survey_submission
            (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `description`, `deleted`, `email_opened`, `survey_send`, `schedule_on`, `status`, `customer_name`, `resubmit`, `resubmit_counter`, `change_request`, `resend`, `resend_counter`, `recipient_as`, `base_score`,`obtained_score`, `score_percentage`, `parent_type`, `parent_id`, `target_parent_type`, `target_parent_id`, `team_id`, `team_set_id`, `submission_type`, `consent_accepted`, `survey_trackdatetime_temp`)
            VALUES
            ( '{$idSubmission}',
              '{$nombreUsuario}',
              utc_timestamp(),
              utc_timestamp(),
              '{$idUsuario}',
              '{$idUsuario}',
              'Encuesta generada desde minuta',
              '0',
              '1',
              '1',
              utc_timestamp(),
              'Pending',
              '{$nombreUsuario}',
              '0',
              '0',
              'N/A',
              '0',
              '0',
              'to',
              '0',
              '0',
              '0',
              'Meetings',
              '{$idReunion}',
              'Users',
              '{$idUsuario}',
              '1',
              '1',
              'Open Ended',
              '0',
              utc_timestamp()
            );";
            //Ejecuta insert
            $resultInsertS = $db->query($insertS);

            //Genera insert a tabla bc_survey_submission_bc_survey_c: Relación entre envío y encuesta
            $insertSS = "INSERT INTO bc_survey_submission_bc_survey_c
            (`id`, `date_modified`, `deleted`, `bc_survey_submission_bc_surveybc_survey_ida`, `bc_survey_submission_bc_surveybc_survey_submission_idb`)
            VALUES
            ( UUID(),
              utc_timestamp(),
              '0',
              '{$idEncuesta}',
              '{$idSubmission}'
            );";
            //Ejecuta insert
            $resultInsertSS = $db->query($insertSS);
        }

        //Genera encode Base 64 de url
        $urlSurvey = $idEncuesta."&ctype=Users&cid=".$idUsuario."&sub_id=".$idSubmission;
        //$GLOBALS['log']->fatal('TCT - urlSurvey: '. $urlSurvey);
        $stringBase64 = base64_encode($urlSurvey);
        //$GLOBALS['log']->fatal('TCT - stringBase64: '. $stringBase64);
        //Regresa url en base64
        return $stringBase64;

    }
}
