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
 
require_once('include/MVC/View/views/view.ajax.php');

class ViewEditFields extends ViewAjax{
 	
    public function __construct(){
        $rel = $this->rel = $_REQUEST['rel'];
        $this->id = $_REQUEST['id'];
        $moduleName = $this->module = $_REQUEST['rel_module'];

        global $beanList;
        require_once("data/Link.php");

        $beanName = $beanList [ $moduleName ];
        $link = new Link($this->rel, new $beanName(), array());
        $this->fields = $link->_get_link_table_definition($rel, 'fields');
 	}

 	function display(){

        //echo "<pre>".print_r($this->fields, true)."</pre>";
        echo "<form name='edit_rel_fields'>" .
             '<input type="submit" class="button primary" value="Save">' .
             '<input type="button" class="button" onclick="editRelPanel.hide()" value="Cancel">' .
             '<input type="hidden" name="module" value="Relationships">' .
             '<input type="hidden" name="action" value="saverelfields">' .
             '<input type="hidden" name="rel" value="' . $this->rel .'">' .
             '<input type="hidden" name="id"  value="' . $this->id  .'">' .
             '<input type="hidden" name="rel_module" value="' . $this->module .'">' .
             "<table class='edit view'><tr>";
        $count = 0;
        foreach($this->fields as $def)
        {
            if (!empty($def['relationship_field'])) {
                $label = !empty($def['vname']) ? $def['vname'] : $def['name'];
                echo "<td>" . translate($label, $this->module) . ":</td>"
                   . "<td><input id='{$def['name']}' name='{$def['name']}'>"  ;

                if ($count%1)
                    echo "</tr><tr>";
                $count++;
            }
        }
        echo "</tr></table></form>";
 	}

}
