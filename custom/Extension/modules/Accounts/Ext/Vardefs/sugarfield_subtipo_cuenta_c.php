<?php
 // created: 2018-08-28 20:58:06
$dictionary['Account']['fields']['subtipo_cuenta_c']['labelValue']='Subtipo de Cuenta';
$dictionary['Account']['fields']['subtipo_cuenta_c']['dependency']='';
$dictionary['Account']['fields']['subtipo_cuenta_c']['visibility_grid']=array (
  'trigger' => 'tipo_registro_c',
  'values' => 
  array (
    'Prospecto' => 
    array (
      0 => 'Contactado',
      1 => 'Interesado',
      2 => 'Integracion de Expediente',
      3 => 'Credito',
      4 => 'Rechazado',
    ),
    'Cliente' => 
    array (
      0 => 'Linea',
      1 => 'Nuevo',
      2 => 'Unifin',
      3 => 'Inactivo',
      4 => 'Dormido',
      5 => 'Perdido',
      6 => 'Venta Activo',
    ),
    'Persona' => 
    array (
    ),
    'Proveedor' => 
    array (
    ),
    'Lead' => 
    array (
      0 => 'En Calificacion',
      1 => 'No Viable',
    ),
  ),
);

 ?>