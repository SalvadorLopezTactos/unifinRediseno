<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 7/5/2016
 * Time: 5:20 PM
 */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#Home/layout/Backlog-layout',
    'label' =>'Backlog',
    'acl_module'=>'Home',
    /*
     *Modificación para habilitar íconos en versión 7.9.3
     * Salvador Lopez Balleza <salvador.lopez@tactos.com.mx
     * */
    'icon' => 'fa-user',
);