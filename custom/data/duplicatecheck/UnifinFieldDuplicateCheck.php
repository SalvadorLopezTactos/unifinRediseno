<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class UnifinFieldDuplicateCheck extends DuplicateCheckStrategy
{

    protected $field1;
    protected $field2;
    protected $field3;

    public function setMetadata($metadata)
    {
        if (isset($metadata['field'])) {
            $this->field = $metadata['field'];
        }
    }

    public function findDuplicates()
    {
        $Query = new SugarQuery();
        $Query->from($this->bean);
        $Query->where()
          ->queryOr()
          ->equals('clean_name',$this->bean->clean_name)
            ->queryAnd()
              ->equals('rfc_c',$this->bean->rfc_c)
              ->notNull('rfc_c')
              ->notEquals('rfc_c','')
              ->notEquals('rfc_c','XXX010101XXX')
              ->notEquals('rfc_c','XXXX010101XXX')
              ;

        //$Query->where()->ends('clean_name',$this->bean->clean_name);
        $Query->limit(20);
        //Filter out the same Bean during Edits
        if (!empty($this->bean->id)) {
            $Query->where()->notEquals('id',$this->bean->id);
        }

        $results = $Query->execute();
        return array(
            'records' => $results
        );
    }
}
