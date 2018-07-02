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
/**
 * Data access class for the product_template table
 */
class ProductTemplate extends SugarBean {
	var $field_name_map;
	// Stored fields
	var $id;
	var $deleted;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $created_by;
	var $created_by_name;
	var $modified_by_name;

	var $name;
	var $description;
	var $vendor_part_num;
	var $cost_price;
	var $discount_price;
	var $list_price;
	var $list_usdollar;
	var $discount_usdollar;
	var $cost_usdollar;
	var $currency_id;
    var $base_rate;
	var $mft_part_num;
	var $status;
	var $date_available;
	var $weight;
	var $qty_in_stock;
	var $website;
	var $tax_class;
	var $support_name;
	var $support_description;
	var $support_contact;
	var $support_term;
	var $pricing_formula;
	var $pricing_factor;
    var $currency_symbol;
	var $default_currency_symbol;
	var $tax_class_name;


	// These are for related fields
	var $type_name;
	var $type_id;
	var $manufacturer_name;
	var $manufacturer_id;
	var $category_name;
	var $category_id;


	var $parent_node_id;
	var $node_id;
	var $parent_name;
	var $type;
	var $default_tree_type;	//specified in save_branch function
	var $category_tree_table = "category_tree";

	var $table_name = "product_templates";
	var $rel_manufacturers = "manufacturers";
	var $rel_types = "product_types";
	var $rel_categories = "product_categories";
	var $module_dir = 'ProductTemplates';
	var $object_name = "ProductTemplate";

	var $new_schema = true;

	var $importable = true;
	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array(
		"manufacturer_name"
		,"parent_node_id"
		,"parent_name"
		,"node_id"
		,"type"
	);

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function ProductTemplate()
    {
        self::__construct();
    }

	public function __construct() {
		parent::__construct();
		$this->disable_row_level_security =true;

		$currency = BeanFactory::getBean('Currencies');
		$this->default_currency_symbol = $currency->getDefaultCurrencySymbol();
	}


	//////////////////////////TREEVIEW////////////////////////
	function clear_leaf($id){
		$query = "delete from $this->category_tree_table where self_id='$id'";
		$this->db->query($query,true,"rror removing leaf: ");
	//end function clear_leaf
	}

	function get_node_id($id){

		$query = "SELECT * from $this->category_tree_table where self_id = '$id'";
		$result =$this->db->query($query,true, "Error- query get_node_id");
		$row = $this->db->fetchByAssoc($result);
		return $row['node_id'];

	//end function get_node_id
	}

	//used for retrieving based on a node id
	function get_branch_id(){

		if($this->parent_node_id!="0"){
			$query = "SELECT $this->category_tree_table.self_id AS self_id, $this->rel_categories.name AS name
			FROM product_categories LEFT JOIN $this->category_tree_table ON $this->category_tree_table.self_id = $this->rel_categories.id
			WHERE $this->category_tree_table.node_id = '$this->parent_node_id'";

			$result =$this->db->query($query,true, "Error- query get_branch_id");
			$row = $this->db->fetchByAssoc($result);

			$this->category_id = $row['self_id'];
			$this->parent_id = $row['self_id'];
			if ($row['name'] != '') $this->parent_name = stripslashes($row['name']);
		}

	//end function get_branch_id
	}

	//used for retrieving based on a normal id
	function get_category_tree_info()
	{
		$query = "SELECT * from $this->category_tree_table where self_id = '$this->id'";
		$result =$this->db->query($query,true, "Error- query get_category_tree_info");

		// Get the id and the name.

		$row = $this->db->fetchByAssoc($result);


			if($row != null)
			{
				if ($row['parent_node_id'] != '') $this->parent_node_id = stripslashes($row['parent_node_id']);
				if ($row['node_id'] != '' ) $this->node_id = stripslashes($row['node_id']);
				if ($row['type'] != '' ) $this->type = stripslashes($row['type']);
			}

		$this->get_branch_id();

	//end function get_category_tree_info
	}

	function save_product_leaf($is_update=""){
	$this->default_tree_type = "Product";

		if($is_update=="Update"){
		//only update parent_node_id
		$query = "update $this->category_tree_table set parent_node_id='$this->parent_node_id' where self_id='$this->id'";

		$this->db->query($query,true,"Error updating a product tree leaf: ");

		//end if
		} else {
		//create new row
        if ($this->parent_node_id=="")
            $query = "insert into $this->category_tree_table set self_id='$this->id', parent_node_id=NULL, type='$this->default_tree_type'";
        else
            $query = "insert into $this->category_tree_table set self_id='$this->id', parent_node_id='$this->parent_node_id', type='$this->default_tree_type'";

		$this->db->query($query,true,"Error creating a product tree leaf: ");


		//end else
		}

	//end function save_product_leaf
	}

	//remove quotes so the javascript tree works properly
	function remove_quotes(){
		$this->name = js_escape($this->name, false);
	}
//////////////////////////TREEVIEW/////////



	function get_summary_text()
	{
		return "$this->name";
	}


	/** Returns a list of the associated opportunities
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_notes()
	{
		// First, get the list of IDs.
		$query = "SELECT id from notes where parent_id='$this->id' AND deleted=0";

		return $this->build_related_list($query, BeanFactory::getBean('Notes'));
	}

	function clear_note_product_template_relationship($product_template_id)
	{
		$query = "UPDATE notes set parent_id='', parent_type='' where (parent_id='$product_template_id') and deleted=0";
		$this->db->query($query,true,"Error clearing note to product_template relationship: ");
	}

	function mark_relationships_deleted($id)
	{
		$this->clear_note_product_template_relationship($id);
	}

	function fill_in_additional_list_fields()
	{
		$this->fill_in_additional_detail_fields();
	}

	function fill_in_additional_detail_fields() {
		global $app_list_strings;
		global $locale;
		global $sugar_config;
		// this is for quotes quicksearching a product. json_server does not make app_list_strings available
		// by default. If this code were added to json_server it would increase each call all the time
		if(empty($app_list_strings)) {
			if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '') {
				$current_language = $_SESSION['authenticated_user_language'];
			} else {
				$current_language = $sugar_config['default_language'];
			}
			$GLOBALS['log']->debug('current_language is: '.$current_language);

			//set module and application string arrays based upon selected language
			$app_list_strings = return_app_list_strings_language($current_language);
		}


        $currency = BeanFactory::getBean('Currencies', $this->currency_id);
        if($currency->id != $this->currency_id || $currency->deleted == 1) {
                $this->cost_price = $this->cost_usdollar;
                $this->discount_price = $this->discount_usdollar;
                $this->list_price = $this->list_usdollar;
                $this->currency_id = $currency->id;
                $this->base_rate = $currency->conversion_rate;
        }

 	    if(isset($this->currency_id) && !empty($this->currency_id)) {
	       $currency->retrieve($this->currency_id);
	       if($currency->deleted != 1){
	          $this->currency_symbol = $currency->symbol;
	       }
	    }

		$this->tax_class_name = (!empty($this->tax_class) && !empty($app_list_strings['tax_class_dom'][$this->tax_class])) ? $app_list_strings['tax_class_dom'][$this->tax_class] : "";
		//$this->get_manufacturer();
		//$this->get_type();
		//$this->get_category();

	}

    /**
     * This method has been deprecated.
     *
     *
     * @deprecated 6.2.0 - Oct 12, 2010
     *
     */
	function get_manufacturer(){
		$query = "SELECT m1.name from $this->rel_manufacturers m1, $this->table_name p1 where m1.id = p1.manufacturer_id and p1.id = '$this->id' and p1.deleted=0 and m1.deleted=0";
		$result = $this->db->query($query,true," Error filling in additional detail fields: ");

		// Get the id and the name.
		$row = $this->db->fetchByAssoc($result);

		if($row != null)
		{
			$this->manufacturer_name = $row['name'];
		}
		else
		{
			$this->manufacturer_name = '';
		}
	}

	/**
	 * This method has been deprecated.
	 *
	 * @deprecated 6.2.0 - Oct 12, 2010
	 */
	function get_type(){
		$query = "SELECT t1.name from $this->rel_types t1, $this->table_name p1 where t1.id = p1.type_id and p1.id = '$this->id' and p1.deleted=0 and t1.deleted=0";
		$result = $this->db->query($query,true," Error filling in additional detail fields: ");

		// Get the id and the name.
		$row = $this->db->fetchByAssoc($result);

		if($row != null)
		{
			$this->type_name = $row['name'];
		}
		else
		{
			$this->type_name = '';
		}
	}

	/**
	 * This method has been deprecated
	 *
	 * @deprecated 6.2.0 - Oct 12, 2010
	 */
	function get_category(){
		$query = "SELECT t1.name from $this->rel_categories t1, $this->table_name p1 where t1.id = p1.category_id and p1.id = '$this->id' and p1.deleted=0 and t1.deleted=0";
		$result = $this->db->query($query,true," Error filling in additional detail fields: ");

		// Get the id and the name.
		$row = $this->db->fetchByAssoc($result);

		if($row != null)
		{
			$this->category_name = $row['name'];
		}
		else
		{
			$this->category_name = '';
		}
	}

	function update_currency_id($fromid, $toid){
		$idequals = '';

		$currency = BeanFactory::getBean('Currencies', $toid);
		foreach($fromid as $f){
			if(!empty($idequals)){
				$idequals .=' or ';
			}
			$idequals .= "currency_id='$f'";
		}

		if(!empty($idequals)){

			$query = "select cost_price, list_price, discount_price, id from ".$this->table_name."  where (". $idequals. ") and deleted=0 ;";
			$result = $this->db->query($query);
			while($row = $this->db->fetchByAssoc($result)){
				$query = "update ".$this->table_name." set currency_id='".$currency->id."', cost_usdollar='".$currency->convertToDollar($row['cost_price'])."', list_usdollar='".$currency->convertToDollar($row['list_price'])."', discount_usdollar='".$currency->convertToDollar($row['discount_price'])."' where id='".$row['id']."';";
				$this->db->query($query);

			}
		}
	}

	function get_list_view_data(){
		global $app_list_strings;

		$temp_array = parent::get_list_view_data();
		$temp_array['NAME'] = (($this->name == "") ? "<em>blank</em>" : $this->name);
		$temp_array['STATUS'] = !empty($this->status) ? $app_list_strings['product_template_status_dom'][$this->status] : "";
		$temp_array['TAX_CLASS_NAME'] = !empty($this->tax_class)? $app_list_strings['tax_class_dom'][$this->tax_class] : "";
		$temp_array['PRICING_FORMULA_NAME'] = !empty($this->pricing_formula) ?$app_list_strings['pricing_formula_dom'][$this->pricing_formula]:"";
		$temp_array['ENCODED_NAME'] = $this->name;
		$temp_array['URL'] = $this->website;
		$temp_array['CATEGORY'] = $this->category_id;
		$temp_array['CATEGORY_NAME'] = $this->category_name;
		$temp_array['TYPE_NAME'] =  $this->type_name;
		$temp_array['QTY_IN_STOCK'] = $this->qty_in_stock;

		return $temp_array;
	}
	/**
		builds a generic search based on the query string using or
		do not include any $this-> because this is called on without having the class instantiated
	*/
	function build_generic_where_clause ($the_query_string) {
	$where_clauses = Array();
	$the_query_string = $GLOBALS['db']->quote($the_query_string);
	array_push($where_clauses, "name like '$the_query_string%'");
	if (is_numeric($the_query_string)) {
		array_push($where_clauses, "mft_part_num like '%$the_query_string%'");
		array_push($where_clauses, "vendor_part_num like '%$the_query_string%'");
	}

	$the_where = "";
	foreach($where_clauses as $clause)
	{
		if($the_where != "") $the_where .= " or ";
		$the_where .= $clause;
	}


	return $the_where;
}

    function save($check_notify = FALSE) {
        parent::save($check_notify);
    }
}

function getProductTypes($focus, $field='type_id', $value,$view='DetailView') {
	if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate') {

		$type = BeanFactory::getBean('ProductTypes');
		$html = "<select id=\"$field\" name=\"$field\">";
	    $html .= get_select_options_with_id($type->get_product_types(), $focus->type_id);
	    $html .= '</select>';
	    return $html;
	} else if(preg_match('/SearchForm_(basic|advanced)_search/', $view, $matches)) {
	   $id = $field.'_'.$matches[1];

	   $type = BeanFactory::getBean('ProductTypes');
       if(isset($_REQUEST[$id])) {
       	  return get_select_options_with_id($type->get_product_types(), $_REQUEST[$id]);
       }
	   return get_select_options_with_id($type->get_product_types(), $focus->type_id);
	}

	return $focus->type_name;
}

function getPricingFormula($focus, $field='pricing_formula', $value, $view='DetailView') {
	require_once('modules/ProductTemplates/Formulas.php');
    refresh_price_formulas();
	if($view == 'EditView' || $view == 'MassUpdate') {
		global $app_list_strings;
	    $html = "<select id=\"$field\" name=\"$field\"";
	    if($view != 'MassUpdate')
	    	$html .= " language=\"javascript\" onchange=\"show_factor(); set_discount_price(this.form);\"";
	    $html .= ">";
	    $html .= get_select_options_with_id($app_list_strings['pricing_formula_dom'], $focus->pricing_formula);
	    $html .= "</select>";
        $html .= "<input type=\"hidden\" name=\"pricing_factor\" id=\"pricing_factor\" value=\"1\">";
		$formulas = get_formula_details($focus->pricing_factor);
		$html .= get_edit($formulas, $focus->pricing_formula);
	    return $html;
	}
	return get_detail($focus->pricing_formula, $focus->pricing_factor);
}

function getManufacturers($focus, $field='manufacturer_id', $value, $view='DetailView') {

	if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate') {
	   $html = "<select id=\"$field\" name=\"$field\">";

	   $manufacturer = BeanFactory::getBean('Manufacturers');
	   $html .= get_select_options_with_id($manufacturer->get_manufacturers(), $focus->manufacturer_id);
	   $html .= "</select>";
	   return $html;
	} else if(preg_match('/SearchForm_(basic|advanced)_search/', $view, $matches)) {
	   $id = $field.'_'.$matches[1];

	   $manufacturer = BeanFactory::getBean('Manufacturers');

       if(isset($_REQUEST[$id])) {
       	  return get_select_options_with_id($manufacturer->get_manufacturers(), $_REQUEST[$id]);
       }
	   return get_select_options_with_id($manufacturer->get_manufacturers(), $focus->manufacturer_id);
	}
	return $focus->manufacturer_name;
}

function getCategories($focus, $field='category_id', $value,$view='DetailView') {
    if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate') {
	   $html = "<select id=\"$field\" name=\"$field\">";

	   $category = BeanFactory::getBean('ProductCategories');
	   $html .= get_select_options_with_id($category->get_product_categories(true), $focus->category_id);
	   $html .= "</select>";
	   return $html;
    } else if(preg_match('/SearchForm_(basic|advanced)_search/', $view, $matches)) {
	   $id = $field.'_'.$matches[1];

	   $category = BeanFactory::getBean('ProductCategories');
       $cats = $category->get_product_categories(true);
       array_shift($cats);
       if(isset($_REQUEST[$id])) {
       	  return get_select_options_with_id($cats, $_REQUEST[$id]);
       }
	   return get_select_options_with_id($cats, $focus->category_id);
	}

    return $focus->category_name;

}

function getSupportTerms($focus, $field='support_term', $value,$view='DetailView') {
    if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate') {
	   $html = "<select id=\"$field\" name=\"$field\">";
	   global $app_list_strings;
	   $the_term_dom = $app_list_strings['support_term_dom'];
	   array_unshift($the_term_dom,'');
	   $html .= get_select_options_with_id($the_term_dom,$focus->support_term);
	   $html .= "</select>";
	   return $html;
    }  else if(preg_match('/SearchForm_(basic|advanced)_search/', $view, $matches)) {
	   $id = $field.'_'.$matches[1];
	   global $app_list_strings;
	   $the_term_dom = $app_list_strings['support_term_dom'];

       if(isset($_REQUEST[$id])) {
       	  return get_select_options_with_id($the_term_dom, $_REQUEST[$id]);
       }
	   return get_select_options_with_id($the_term_dom, $focus->support_term);
	}
    return $focus->support_term;
}




?>
