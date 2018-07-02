<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

/**
 * Represents a many to many relationship that is table based.
 * @api
 */
class EmailAddressRelationship extends M2MRelationship
{
    /**
     * For Email Addresses, there is only a link from the left side, so we need a new add function that ignores rhs
     * @param  $lhs SugarBean left side bean to add to the relationship.
     * @param  $rhs SugarBean right side bean to add to the relationship.
     * @param  $additionalFields key=>value pairs of fields to save on the relationship
     * @return boolean true if successful
     */
    public function add($lhs, $rhs, $additionalFields = array())
    {
        $lhsLinkName = $this->lhsLink;

        if (empty($lhs->$lhsLinkName) && !$lhs->load_relationship($lhsLinkName))
        {
            $lhsClass = get_class($lhs);
            $GLOBALS['log']->fatal("could not load LHS $lhsLinkName in $lhsClass");
            return false;
        }

        if ((empty($_SESSION['disable_workflow']) || $_SESSION['disable_workflow'] != "Yes"))
        {
            if ($lhs->$lhsLinkName->beansAreLoaded())
                $lhs->$lhsLinkName->addBean($rhs);

            $this->callBeforeAdd($lhs, $rhs, $lhsLinkName);
        }

        //Many to many has no additional logic, so just add a new row to the table and notify the beans.
        $dataToInsert = $this->getRowToInsert($lhs, $rhs, $additionalFields);

        $success = true;
        if ($this->addRow($dataToInsert) === false) {
            $success = false;
            LoggerManager::getLogger()->error("Warning: failed trying to call addRow() for relationship {$this->name} within EmailAddressRelationship->add(). dataToInsert: $dataToInsert");
        }

        if ($this->addSelfReferencing($lhs, $rhs, $additionalFields) === false) {
            $success = false;
            LoggerManager::getLogger()->error("Warning: failure calling addSelfReferencing for relationship {$this->name} within EmailAddressRelationship->add() ");
        }

        if ((empty($_SESSION['disable_workflow']) || $_SESSION['disable_workflow'] != "Yes"))
        {
            if ($lhs->$lhsLinkName->beansAreLoaded())
                $lhs->$lhsLinkName->addBean($rhs);

            $this->callAfterAdd($lhs, $rhs, $lhsLinkName);
        }

        return $success;
    }

    public function remove($lhs, $rhs)
    {
        $lhsLinkName = $this->lhsLink;

        if (!($lhs instanceof SugarBean)) {
            $GLOBALS['log']->fatal("LHS is not a SugarBean object");
            return false;
        }
        if (!($rhs instanceof SugarBean)) {
            $GLOBALS['log']->fatal("RHS is not a SugarBean object");
            return false;
        }
        if (empty($lhs->$lhsLinkName) && !$lhs->load_relationship($lhsLinkName))
        {
            $GLOBALS['log']->fatal("could not load LHS $lhsLinkName");
            return false;
        }

        if (empty($_SESSION['disable_workflow']) || $_SESSION['disable_workflow'] != "Yes")
        {
            if (!empty($lhs->$lhsLinkName))
            {
                $lhs->$lhsLinkName->load();
                $this->callBeforeDelete($lhs, $rhs, $lhsLinkName);
            }
        }

        $dataToRemove = array(
            $this->def['join_key_lhs'] => $lhs->id,
            $this->def['join_key_rhs'] => $rhs->id
        );

        $success = true;
        if ($this->removeRow($dataToRemove) === false) {
            LoggerManager::getLogger()->error("Warning: failure calling removingRow() for relationship {$this->name} within EmailAddressRelationship->remove()  dataToRemove: ".var_export($dataToRemove,true));
            $success = false;
        }


        if ($this->self_referencing) {
            if ($this->removeSelfReferencing($lhs, $rhs) === false) {
                $success = false;
                LoggerManager::getLogger()->error("Warning: failure calling removeSelfReferencing() for relationship {$this->name} within EmailAddressRelationship->remove() ");
            }
        }

        if (empty($_SESSION['disable_workflow']) || $_SESSION['disable_workflow'] != "Yes")
        {
            if (!empty($lhs->$lhsLinkName))
            {
                $lhs->$lhsLinkName->load();
                $this->callAfterDelete($lhs, $rhs, $lhsLinkName);
            }
        }

        return $success;
    }
}
