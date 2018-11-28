 <?php
/**
 * Created by PhpStorm.
 * User: Adrian Arauz
 * Date: 26/10/18
 * Time: 09:28 AM
 */


$hook_array['after_save'][] = Array(
    5,
    'Obtiene Objetivos de la reunion para minuta',
    'custom/modules/minut_Minutas/minuta_objetivos.php',
    'Objetivos_minuta',          //Nombre de la Clase
    'obtenobjetivos'             //Nombre funcion
);


 $hook_array['after_save'][] = Array(
     20,
     'Actualiza la Relacion de la minuta y Reunion  correctamente',
     'custom/modules/minut_Minutas/actualizaRelacionMinutaReunion.php',
     'actualizaRelacionMinutaReunion',          //Nombre de la Clase
     'actualizaRelacion'             //Nombre funcion
 );