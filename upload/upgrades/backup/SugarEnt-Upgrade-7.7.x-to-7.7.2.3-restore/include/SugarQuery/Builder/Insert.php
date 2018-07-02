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

class SugarQuery_Builder_Insert {
	/**
	 * Table to do the insert on
	 */
	protected $table;

	/**
	 * Columns array for the inserts
	 */
	protected $columns = array();

	/**
	 * Values of the insert
	 */
	protected $values = array();

	/**
	 * Constructor, sets up the insert
	 * @param string $table 
	 * @param array $columns 
	 * @return object this
	 */
	public function __construct($table = NULL, array $columns = NULL)
	{
		if ($table)
		{
			// Set the inital table name
			$this->table = $table;
		}

		if ($columns)
		{
			// Set the column names
			$this->columns = $columns;
		}
	}

	/**
	 * Set the Table for the insert
	 * @param string $table 
	 * @return object this
	 */
	public function table($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Set the columns for the insert
	 * @param array $columns 
	 * @return object this
	 */
	public function columns(array $columns)
	{
		$this->columns = $columns;

		return $this;
	}

	/**
	 * Set the values for the insert
	 * @param array $values 
	 * @return object this
	 */
	public function values(array $values)
	{
		// Get all of the passed values
		$values = func_get_args();

		$this->values = array_merge($this->values, $values);

		return $this;
	}

	public function __get($name)
	{
		return $this->$name;
	}

}