<?php
/**
 * Created by Adrián Arauz.
 * Date: 15/10/20
 * Time: 12:00
 * Modificando la URL
 */
global $current_user,$sugar_config;
    //Variables para puerto
    $Host=$sugar_config['url_Refinanciamientos'];

?>
<script type="text/javascript">
    window.onload = function () {
        //Obtencion de Token
        var TOKEN=localStorage.getItem('prod:SugarCRM:AuthAccessToken');
        //Setea valor de la url con atributos como puerto, el id del user y el token.
        const url= `<?php echo $Host?>?user=<?php echo $current_user->user_name;?>&token=${TOKEN.replace(/['"]+/g, '')}`;

        //Setea el valor de la url al scr del iframe con id Theme
        document.getElementById("theme").setAttribute("src",url);
    };

</script>
<!DOCTYPE html>
<html>
<body>

<iframe id="theme" style="width:100%;height: 100%;position: absolute;"></iframe>


</body>
</html>


