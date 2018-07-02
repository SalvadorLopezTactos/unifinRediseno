<?php

require_once('include/MVC/View/views/view.list.php');

class CustomAccountsViewList extends ViewList
{
 	public function Display()
 	{
		parent::Display();
		$this->lv->quickViewLinks = false; //This removes Edit Link
 	}
}
