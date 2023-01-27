<?php
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
$user_name ='';
$user_password = '';
foreach($_POST as $name=>$value){
		$$name = $value;
}
echo <<<EOQ
<form name='test' method='POST'>
<table width ='800'><tr>
<tr><th colspan='6'>Enter  SugarCRM  User Information - this is the same info entered when logging into sugarcrm</th></tr>
<td >USER NAME:</td><td><input type='text' name='user_name' value='$user_name'></td><td>USER PASSWORD:</td><td><input type='password' name='user_password' value='$user_password'></td>
</tr>

<tr><td><input type='submit' value='Submit'></td></tr>
</table>
</form>


EOQ;
if(!empty($user_name)){
$offset = 0;
if(isset($_REQUEST['offset'])){
	$offset = $_REQUEST['offset'] + 20;
	echo $offset;
}
    $soapURL = $GLOBALS['sugar_config']['site_url'].'/soap.php';
    $params = array(
        'soap_version' => SOAP_1_1,
        'exceptions' => 0,
        'uri' => $soapURL,
        'location' => $soapURL,
    );
    $soapclient = new \SoapClient(null, $params);  //define the SOAP Client an

echo '<b>LOGIN:</b><BR>';
    $result = $soapclient->login(array('user_name'=>$user_name, 'password'=>md5($user_password), 'version'=>'.01'), 'SoapTest');
echo '<b>HERE IS ERRORS:</b><BR>';
    if (is_soap_fault($result)) {
        echo $result->__toString();
    }

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    echo $soapclient->__getLastResponse();

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);
$session = $result['id'];

echo '<br><br><b>GET Case fields:</b><BR>';
    $result = $soapclient->get_module_fields($session, 'Cases');
echo '<b>HERE IS ERRORS:</b><BR>';
    if (is_soap_fault($result)) {
        echo $result->__toString();
    }

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    echo $soapclient->__getLastResponse();

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);

echo '<br><br><b>Get list of contacts:</b><BR>';
    $result = $soapclient->get_entry_list($session, 'Contacts', '', 'contacts.last_name asc', $offset, [], '5');
echo '<b>HERE IS ERRORS:</b><BR>';
    if (is_soap_fault($result)) {
        echo $result->__toString();
    }

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    echo $soapclient->__getLastResponse();

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);

echo '<br><br><b>LOGOUT:</b><BR>';
    $result = $soapclient->logout($session);
echo '<b>HERE IS ERRORS:</b><BR>';
    if (is_soap_fault($result)) {
        echo $result->__toString();
    }

echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    echo $soapclient->__getLastResponse();

echo '<BR><BR><b>HERE IS RESULT:</b><BR>';
echo print_r($result);

}
