<?php
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

class SugarQuery_Builder_Orderby
{
    public $column;
    public $direction = 'DESC';
    public $query;

    public function __construct($query, $direction = 'DESC')
    {
        $this->query = $query;
        $this->direction = $direction;
    }

    public function addField($column, $options = array())
    {
        $this->column = new SugarQuery_Builder_Field_Orderby($column, $this->query, $this->direction);
        return $this;
    }

    public function addRaw($expression) {
        $this->column = new SugarQuery_Builder_Field_Raw($expression, $this->query);
    }
}
