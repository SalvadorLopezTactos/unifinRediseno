<?PHP
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/bc_survey_submit_question/bc_survey_submit_question_sugar.php');
class bc_survey_submit_question extends bc_survey_submit_question_sugar {

    function custom_retrieve_by_string_fields($fields_array, $encode = true, $deleted = true) {
        global $db;
        if ($db->dbType == "mssql") {
            $group_con = " STRING_AGG(sa.name,',') ";
        }else{
            $group_con = " GROUP_CONCAT(sa.name) ";
        }
        $where_clause = $this->get_where($fields_array, $deleted);
        $whereClause = " ssq.survey_ID = '{$fields_array['survey_ID']}' and ssq.deleted = 0";
        if (array_key_exists('submission_id', $fields_array)) {
            $whereClause = " ssq.survey_ID = '{$fields_array['survey_ID']}' and ssq.submission_id = '{$fields_array['submission_id']}'  and ssq.deleted = 0 ";
        }
        $query = "SELECT
                    ssq.id,
                    ssq.name AS qName,
                    {$group_con} AS ansName
                  FROM
                    bc_survey_submit_question AS ssq
                  LEFT JOIN
                    bc_survey_submit_question_bc_survey_answers_c AS ssqsa ON ssqsa.bc_survey_c9f6uestion_ida = ssq.id 
                    AND ssqsa.deleted = 0 
                    AND ssq.deleted = 0
                  LEFT JOIN
                    bc_survey_answers AS sa ON sa.id = ssqsa.bc_survey_submit_question_bc_survey_answersbc_survey_answers_idb 
                    AND sa.deleted = 0
                  LEFT JOIN
                    bc_survey_questions_bc_survey_submit_question_1_c 
                    ON bc_survey_questions_bc_survey_submit_question_1_c.bc_survey_bb7auestion_idb = ssq.id 
                    AND bc_survey_questions_bc_survey_submit_question_1_c.deleted = 0
                  LEFT JOIN
                    bc_survey_questions ON bc_survey_questions.id = bc_survey_questions_bc_survey_submit_question_1_c.bc_survey_6a25estions_ida 
                    AND bc_survey_questions.deleted = 0
                   left join bc_survey_pages_bc_survey_questions_c on bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_questions_idb = bc_survey_questions.id
                    and bc_survey_questions.deleted = 0 and bc_survey_pages_bc_survey_questions_c.deleted = 0
                    left join bc_survey_pages on bc_survey_pages.id = bc_survey_pages_bc_survey_questions_c.bc_survey_pages_bc_survey_questionsbc_survey_pages_ida
                    and bc_survey_pages.deleted = 0
                  WHERE
                    {$whereClause} AND ssq.deleted = 0 and ssq.name != ''
                    Group by ssq.id,ssq.name,bc_survey_pages.page_sequence,bc_survey_questions.question_sequence
                    order by bc_survey_pages.page_sequence asc, bc_survey_questions.question_sequence asc";
        $runQuery = $this->db->query($query);
        $returnDataArr = array();
        while ($result = $this->db->fetchByAssoc($runQuery)) {
            if ($result['ansName'] == 'selection_default_value_dropdown' || empty($result['ansName'])) {
                $result['ansName'] = 'N/A';
}
            $returnDataArr[] = array($result['qName'] => $result['ansName']);
        }

        return $returnDataArr;
    }

}