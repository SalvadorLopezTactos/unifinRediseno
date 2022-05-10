<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class LeadFieldDuplicateCheck extends DuplicateCheckStrategy
{

    protected $field;

    public function setMetadata($metadata)
    {
        if (isset($metadata['field'])) {
            $this->field = $metadata['field'];
        }
    }

    public function findDuplicates()
    {
        if (empty($this->field)) {
            return null;
        }

        $Query = new SugarQuery();
        $Query->from($this->bean);
        $Query->where()->equals($this->field, $this->bean->{$this->field});
        $Query->limit(10);
        //Filter out the same Bean during Edits
        if (!empty($this->bean->id)) {
            $Query->where()->notEquals('id', $this->bean->id);
        }
        $results = $Query->execute();
        // $GLOBALS['log']->fatal('RESULT_FILTER');
        return array(
            'records' => $results
        );
    }
}
