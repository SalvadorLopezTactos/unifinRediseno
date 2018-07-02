<?php
/*
 * @author Carlos Zaragoza
 * @task Crea menu de lista de tareas en el menu Sugar Cube
 * @date 18-11-2015
 * @mail czaragoza@legosoft.com.mx
 * */
$viewdefs['Home']['base']['menu']['header'][] = array(
    'route'=>'#bwc/index.php?entryPoint=dashlet_home',
    'label' =>'Lista de tareas',
    'acl_module'=>'Home',
    /*
     *Modificación para habilitar íconos en versión 7.9.3
     * Salvador Lopez Balleza <salvador.lopez@tactos.com.mx
     * */
    'icon' => 'fa-bars',
);