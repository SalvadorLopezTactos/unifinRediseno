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

class Message extends Basic
{
    public $aws_contact_id;
    public $module_dir = 'Messages';
    public $object_name = 'Message';
    public $table_name = 'messages';
    public $module_name = 'Messages';
    public $importable = true;

    /**
     * {@inheritDoc}
     *
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }
}
