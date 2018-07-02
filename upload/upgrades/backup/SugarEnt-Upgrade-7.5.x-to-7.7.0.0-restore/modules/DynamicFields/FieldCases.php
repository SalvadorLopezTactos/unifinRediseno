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


require_once('modules/DynamicFields/templates/Fields/TemplateTextArea.php');
require_once('modules/DynamicFields/templates/Fields/TemplateFloat.php');
require_once('modules/DynamicFields/templates/Fields/TemplateInt.php');
require_once('modules/DynamicFields/templates/Fields/TemplateDate.php');
require_once('modules/DynamicFields/templates/Fields/TemplateDatetimecombo.php');
require_once('modules/DynamicFields/templates/Fields/TemplateBoolean.php');
require_once('modules/DynamicFields/templates/Fields/TemplateEnum.php');
require_once('modules/DynamicFields/templates/Fields/TemplateMultiEnum.php');
require_once('modules/DynamicFields/templates/Fields/TemplateRadioEnum.php');
require_once('modules/DynamicFields/templates/Fields/TemplateEmail.php');
require_once('modules/DynamicFields/templates/Fields/TemplateRelatedTextField.php');

require_once('modules/DynamicFields/templates/Fields/TemplateURL.php');
require_once('modules/DynamicFields/templates/Fields/TemplateIFrame.php');
require_once('modules/DynamicFields/templates/Fields/TemplateHTML.php');
require_once('modules/DynamicFields/templates/Fields/TemplatePhone.php');
require_once('modules/DynamicFields/templates/Fields/TemplateCurrency.php');
require_once('modules/DynamicFields/templates/Fields/TemplateParent.php');
require_once('modules/DynamicFields/templates/Fields/TemplateCurrencyId.php');
require_once('modules/DynamicFields/templates/Fields/TemplateAddress.php');
require_once('modules/DynamicFields/templates/Fields/TemplateParentType.php');
require_once('modules/DynamicFields/templates/Fields/TemplateEncrypt.php');
require_once('modules/DynamicFields/templates/Fields/TemplateId.php');
require_once('modules/DynamicFields/templates/Fields/TemplateImage.php');
require_once('modules/DynamicFields/templates/Fields/TemplateDecimal.php');
require_once('modules/DynamicFields/templates/Fields/TemplateLink.php');
function get_widget($type)
{

	$local_temp = null;
	switch(strtolower($type)){
			case 'char':
			case 'varchar':
			case 'varchar2':
						$local_temp = new TemplateText(); break;
			case 'text':
			case 'textarea':
						$local_temp = new TemplateTextArea(); break;
			case 'double':

			case 'float':
						$local_temp = new TemplateFloat(); break;
			case 'decimal':
						$local_temp = new TemplateDecimal(); break;
			case 'int':
						$local_temp = new TemplateInt(); break;
			case 'date':
						$local_temp = new TemplateDate(); break;
			case 'bool':
						$local_temp = new TemplateBoolean(); break;
			case 'relate':
						$local_temp = new TemplateRelatedTextField(); break;
			case 'enum':
						$local_temp = new TemplateEnum(); break;
			case 'multienum':
						$local_temp = new TemplateMultiEnum(); break;
			case 'radioenum':
						$local_temp = new TemplateRadioEnum(); break;
			case 'email':
						$local_temp = new TemplateEmail(); break;
		    case 'url':
						$local_temp = new TemplateURL(); break;
			case 'iframe':
						$local_temp = new TemplateIFrame(); break;
			case 'html':
						$local_temp = new TemplateHTML(); break;
			case 'phone':
						$local_temp = new TemplatePhone(); break;
			case 'currency':
						$local_temp = new TemplateCurrency(); break;
			case 'parent':
						$local_temp = new TemplateParent(); break;
			case 'parent_type':
						$local_temp = new TemplateParentType(); break;
			case 'currency_id':
						$local_temp = new TemplateCurrencyId(); break;
			case 'address':
						$local_temp = new TemplateAddress(); break;
			case 'encrypt':
						$local_temp = new TemplateEncrypt(); break;
			case 'id':
						$local_temp = new TemplateId(); break;
			case 'datetimecombo':
			case 'datetime':
						$local_temp = new TemplateDatetimecombo(); break;
            case 'image':
                        $local_temp = new TemplateImage(); break;
            case 'link':
                        $local_temp = new TemplateLink(); break;
			default:
						if(SugarAutoLoader::requireWithCustom('modules/DynamicFields/templates/Fields/Template'. ucfirst($type) . '.php')) {
							$class  = SugarAutoLoader::customClass('Template' . ucfirst($type));
							$local_temp = new $class();
							break;
						}else{
							$local_temp = new TemplateText(); break;
						}
	}

	return $local_temp;
}
