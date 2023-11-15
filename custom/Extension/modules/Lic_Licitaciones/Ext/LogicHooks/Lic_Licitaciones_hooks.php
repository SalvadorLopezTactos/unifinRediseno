<?php

$hook_array['before_save'][] = Array(
   1,
   'Evita guardado de registro en caso de que se relacione una cuenta bloqueada',
   //Hsace referencia a archivo dentro de Opportunities para no generar uno nuevo ya que se reutiliza la funcionalidad para Leads
   'custom/modules/Opportunities/Check_Bloqueo_Cuenta_Opp.php',
   'Check_Bloqueo_Cuenta_Opp',
   'verifica_cuenta_bloqueada_opp'
);

