<?php
/**
 * Created by Salvador Lopez.
 * salvador.lopez@tactos.com.mx
 * Date: 24/01/19
 */

global $current_user;
$env = $_SERVER['HTTP_REFERER'];
$server_prod = "https://crm.unifin.com.mx/unifin/";
$url_prod = "https://micro.unifin.com.mx/MicroStrategy/asp/Main.aspx?Server=SRVCORPBI-1&Project=UNIFIN&Port=0&evt=2048001&src=Main.aspx.2048001&documentID=9708DED046AEC768DE49468DBC5BA5C1&uid=MicroStrategy&pwd=*m1cr0str4t3gy.&hiddensections=path";
$url_env = "http://srvdevbi-1/MicroStrategy/asp/Main.aspx?Server=SRVDEVBI-1&Project=UNIFIN&Port=0&evt=2048001&src=Main.aspx.2048001&documentID=9708DED046AEC768DE49468DBC5BA5C1&uid=MicroStrategy&pwd=*m1cr0str4t3gy.&hiddensections=path";

?>
<!DOCTYPE html>
<html>
<body>
<?php
if($env==$server_prod){
//if ($env == "http://localhost/unifinRediseno/unifinUpgrade/") {
echo '<iframe src="'.$url_prod.'" style="width:100%;height: 100%;position: absolute;"></iframe>';
//    echo '<iframe src="https://micro.unifin.com.mx" style="width:100%;height: 100%;position: absolute;"></iframe>';
} else {
    echo '<iframe src="' . $url_env . '" style="width:100%;height: 100%;position: absolute;"></iframe>';
}
?>
<!-- <iframe src="https://micro.unifin.com.mx" style="width:100%;height: 100%;position: absolute;"></iframe> -->

</body>
</html>

