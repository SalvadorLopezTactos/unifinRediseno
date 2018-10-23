<?php
/**
 * Created by Salvador Lopez.
 * Date: 04/10/18
 * Time: 12:20
 * Modificando la URL
 */

global $current_user;
?>
<!DOCTYPE html>
<html>
<body>


<iframe src="http://apolo.unifin.com.mx:1024/vendors.html?<?php echo $current_user->id; ?>" style="width:100%;height: 100%;position: absolute;"></iframe>

</body>
</html>

