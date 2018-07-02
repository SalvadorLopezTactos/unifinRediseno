<?php
/**
 * Created by Salvador Lopez.
 * salvador.lopez@tactos.com.mx
 * Date: 15/05/18
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class SetPlatform
{
    function setUserPlatform($bean, $event, $arguments)
    {
        //Obteniendo plataforma, session_id y id de usuario
        $plataforma=$GLOBALS['service']->platform;
        $id_user=$bean->id;
        $sesion_str= session_id();

        $beanSesion = BeanFactory::newBean("TCT_UsersPlatform");
        $beanSesion->tct_session_id_txf = $sesion_str;
        $beanSesion->tct_user_id_txf = $id_user;
        $beanSesion->tct_platform_txf = $plataforma;
        $beanSesion->save();
    }
}

?>