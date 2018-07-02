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

use Sugarcrm\Sugarcrm\Security\InputValidation\Request;

 require_once('include/ListView/ListViewSmarty.php');
 
class ListViewPackages extends ListViewSmarty{
    var $secondaryDisplayColumns;

    /**
     * @deprecated Use __construct() instead
     */
    public function ListViewPackages(Request $request = null)
    {
        self::__construct($request);
    }

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * Override the setup method in ListViewSmarty since we are not passing in a bean
     * 
     * @param data  the data to display on the page
     * @param file  the template file to parse
     */
    public function setup($data, $file, $where, $params = array(), $offset = 0, $limit = -1,  $filter_fields = array(), $id_field = 'id')
    {
        $this->data = $data;
        $this->tpl = $file;       
    }
    
    /**
     * Override the display method
     */
    public function display($end = true)
    {
        global $odd_bg, $even_bg, $app_strings;
        $this->ss->assign('rowColor', array('oddListRow', 'evenListRow'));
        $this->ss->assign('bgColor', array($odd_bg, $even_bg));
        $this->ss->assign('displayColumns', $this->displayColumns);
        $this->ss->assign('secondaryDisplayColumns', $this->secondaryDisplayColumns);
        $this->ss->assign('data', $this->data); 
        return $this->ss->fetch($this->tpl);  
    }  
}
