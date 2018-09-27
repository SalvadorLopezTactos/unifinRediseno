<?php
/**
 * User: AF
 * Date: 03/09/2018
 * Time: 10:10
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $current_user;

if (empty($current_user) || empty($current_user->id)) {
    $current_user = new User();
    $current_user->getSystemUser(); // or any other user bean
}

$forma = '
<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

<form target="_blank" method="POST" action="http://192.168.226.222:8888/unifin/rediseno/custom/Levementum/CustomEntryPoints/SaveSurvey.php">
  First name:<br>
  <input type="text" name="firstname" value="Mickey">
  <br>
  Last name:<br>
  <input type="text" name="lastname" value="Mouse">
  <br><br>
  <input type="submit" value="Submit">
</form>

<p>If you click the "Submit" button, the form-data will be sent to a page called "/custom/Levementum/CustomEntryPoints/SaveSurvey.php".</p>

</body>
</html>
';


echo $forma;
