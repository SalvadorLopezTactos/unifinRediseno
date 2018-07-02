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
require_once 'modules/Reports/Report.php';

class SubpanelFromReports extends Report {
	public function __construct($report) {
		parent::Report($report->content);
		if (isset($this->report_def['display_columns'])) {	
			if (!empty($this->report_def['display_columns'])) {
				foreach ($this->report_def['display_columns'] as $key => $column) {
					// If self column exists, return Report class
					if ($column['table_key'] == 'self') {
						return $this;
					}
				}
			} 
			$this->_appendNecessaryColumn();
		}
	} 
	
	/**
	 *  Because one self column needed to generate primaryid for subpanel list
	 */
	private function _appendNecessaryColumn() {
		array_push($this->report_def['display_columns'], array (
			'label' => 'Name',
			'name' => 'name',
			'table_key' => 'self'
		));
	}
}