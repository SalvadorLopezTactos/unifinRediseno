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

class SugarQuery_Builder_Update {
	/**
	 * Table for the update
	 */
	protected $table;

	/**
	 * SET Array for the updates
	 */
	protected $set = array();

	protected $order_by = array();

	protected $limit = NULL;

	/**
	 * Set up the UPDATE with the initial table
	 * @param string $table 
	 */
	public function __construct($table = NULL)
	{
		if ($table)
		{
			// Set the inital table name
			$this->table = $table;
		}
	}

	/**
	 * Set a Table to user
	 * @param string $table 
	 * @return object this
	 */
	public function table($table)
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Set the SET Paramaters
	 * @param array $pairs 
	 * @return object this
	 */
	public function set(array $pairs)
	{
		foreach ($pairs as $column => $value)
		{
			$this->set[] = array($column, $value);
		}

		return $this;
	}

	/**
	 * Set the Column, Value 
	 * @param string $column
	 * @param string $value 
	 * @return object this
	 */
	public function value($column, $value)
	{
		$this->set[] = array($column, $value);

		return $this;
	}

	public function __get($name)
	{
		return $this->$name;
	}


	/**
	 * Set an Order By Close
	 * @param string $column 
	 * @param string $direction 
	 * @return object this
	 */
	public function orderBy($column, $direction = NULL)
	{
		$this->order_by[] = array($column, $direction);

		return $this;
	}

	/**
	 * Set a LIMIT clause
	 * @param int $number 
	 * @return object this
	 */
	public function limit($number)
	{
		$this->limit = $number;

		return $this;
	}	

}