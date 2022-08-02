<?php
/**
 * Created by Salvador Lopez.
 * salvador.lopez@tactos.com.mx
 */

    global $current_user;
    $pos_operativa=$current_user->posicion_operativa_c;
    $url_src="https://micro.unifin.com.mx:443/MicroStrategy/servlet/mstrWeb?evt=3140&src=mstrWeb.3140&documentID=2549A19F419AE596FB83D6BEB09EA416&Server=SRVCORPBI-1&Project=UNIFIN&Port=0&share=1&uid=AsesorLEasing&pwd=L34sAs3s0rUn12022";

?>
<!DOCTYPE html>
<html>
<body>
<?php

echo '<iframe src="'.$url_src.'" style="width:100%;height: 100%;position: absolute;"></iframe>';

?>

</body>
</html>

