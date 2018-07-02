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
	

$object_name = strtolower($object_name);
$app_list_strings = array (
  $object_name.'_category_dom' => 
  array (
    '' => '[-blank-]',
    'Knowledege Base' => '날리지베이스',
    'Marketing' => '마케팅',
    'Sales' => '영업',
  ),
  $object_name.'_status_dom' => 
  array (
    'Active' => '활성중',
    'Draft' => '초안',
    'Expired' => '기간 만료됨',
    'FAQ' => '자주묻는질문',
    'Pending' => '보류중',
    'Under Review' => '검토중',
  ),
  $object_name.'_subcategory_dom' => 
  array (
    '' => '[-blank-]',
    'FAQ' => '자주묻는질문',
    'Marketing Collateral' => '홍보 자료',
    'Product Brochures' => '브로슈어',
  ),
);

