<?php
/**
 * Created by Salvador Lopez.
 * Date: 30/03/20
 */

global $current_user;
global $sugar_config;
$url_credito_simple=$sugar_config['url_credito_simple'];
?>
<!DOCTYPE html>
<html>
<body>


<iframe src="<?php echo $url_credito_simple; ?>" style="width:100%;height: 100%;position: absolute;"></iframe>

</body>
</html>

