<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 20/07/2018
 * Time: 02:46 PM
 */

  $hook_array['before_save'][] = array( //Evento en que se disparará
      20,  //Orden de ejecución
      'Logichook de prueba',  //Descripción de logichook
      'custom/modules/Opportunities/solcitud_c_cue.php',  //Ruta del archivo a ejecutar
      'Cuenta_c',  //Clase a invocar
      'change'  //Método a invocar
  );

?>