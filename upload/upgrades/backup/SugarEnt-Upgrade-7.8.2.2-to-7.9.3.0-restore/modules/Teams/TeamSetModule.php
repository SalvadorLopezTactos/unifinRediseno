<?php


require_once('vendor/ytree/Tree.php');
require_once('vendor/ytree/Node.php');
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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
/**

 */
class TeamSetModule extends SugarBean{
    /*
    * char(36) GUID
    */
    var $id;

    var $team_set_id;
    var $module_table_name;

    var $table_name = "team_sets_modules";
    var $object_name = "TeamSetModule";
    var $module_name = 'TeamSetModule';
    var $module_dir = 'Teams';
    var $disable_custom_fields = true;

    /**
    * Default constructor
    *
    */
    public function __construct(){
        parent::__construct();
        $this->disable_row_level_security =true;
    }

    public function save($check_notify = false)
    {
        $sql = sprintf(
            'SELECT id FROM %s WHERE team_set_id = %s AND module_table_name = %s',
            $this->table_name,
            $this->db->quoted($this->team_set_id),
            $this->db->quoted($this->module_table_name)
        );
        $result = $this->db->query($sql);
        $row = $this->db->fetchByAssoc($result);
        if (!$row){
            $id = create_guid();
            // insert the record by means of plain SQL in order to not trigger all other logic in SugarBean::save(),
            // since this method is manually called from SugarBean::save()
            $sql = 'INSERT INTO ' . $this->table_name . ' (id, team_set_id, module_table_name, deleted) VALUES ('
                . $this->db->quoted($id) . ', '
                . $this->db->quoted($this->team_set_id) . ', '
                . $this->db->quoted($this->module_table_name) . ', '
                . '0)';
            $this->db->query($sql);
        }
    }
}
