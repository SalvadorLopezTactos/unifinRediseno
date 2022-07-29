<?php
/**
 * Created by Tactos.
 * User: AF
 * Date: 2019-17-01
 */

/*
Definición de LH para agregar equipos a registro
*/

$hook_array['before_save'][] = Array(
   20,
   'evey time a new team is added to the record, All related records get the new team',
   'custom/modules/Notes/teamSet.php',
   'teamSetClass', // name of the class
   'teamSetMethod'
);
