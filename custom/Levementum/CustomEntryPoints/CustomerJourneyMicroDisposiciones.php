<?php
/**
 * Created by Salvador Lopez.
 * salvador.lopez@tactos.com.mx
 */

    global $current_user;
    $pos_operativa=$current_user->posicion_operativa_c;
    //$url_src="https://micro.unifin.com.mx:443/MicroStrategy/servlet/mstrWeb?evt=3140&src=mstrWeb.3140&documentID=2549A19F419AE596FB83D6BEB09EA416&Server=SRVCORPBI-1&Project=UNIFIN&Port=0&share=1&uid=AsesorLEasing&pwd=L34sAs3s0rUn12022";
    //$url_src="http://srvdevbi-pre/Embeber/app3.html";
    $url_src="https://micro.unifin.com.mx/EmbeddingAPI/app4.html?IdAsesor=c4198a42-4fcb-11e8-ad13-00155d967307";
    //CustomerJourneyMicroDisposiciones
?>
<!DOCTYPE html>
<html>
<body>
<script src="https://micro.unifin.com.mx/MicroStrategyLibrary/javascript/embeddinglib.js"></script>;

    <iframe src="https://micro.unifin.com.mx/EmbeddingAPI/app4.html?IdAsesor=16ff1b17-a063-6fff-970f-5628f6e851a4"  style="width:100%;height: 100%;position: absolute;"></iframe>
   
</body>

</html>

