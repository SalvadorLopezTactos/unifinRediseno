<?php

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

class TemplateAddressCountry extends TemplateEnum
{
    public $group = '';

    public function get_field_def()
    {
        $def = parent::get_field_def();
        $def['group'] = $this->group;
        $def['options'] = 'countries_dom';
        return $def;
    }
}
