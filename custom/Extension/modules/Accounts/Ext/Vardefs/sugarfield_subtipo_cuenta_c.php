<?php
 // created: 2019-10-10 13:58:59
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
      0 => 'Venta Activo',
      1 => 'Linea',
      2 => 'Nuevo',
      3 => 'Unifin',
      4 => 'Inactivo',
      5 => 'Dormido',
      6 => 'Perdido',
      7 => 'Credito Simple',
      8 => 'Con Linea Vigente',
      9 => 'Con Linea Vencida',
      10 => 'Con mas de un ano sin Operar',
    ),
    'Lead' => 
    array (
      0 => 'En Calificacion',
      1 => 'No Viable',
    ),
    'Persona' => 
    array (
    ),
    'Proveedor' => 
    array (
    ),
  ),
);

 ?>