<?php
$module_name = 'QPRO_Encuestas';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'related_module',
                'label' => 'LBL_RELATED_MODULE',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'cuenta',
                'label' => 'LBL_CUENTA',
                'enabled' => true,
                'readonly' => false,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'lead',
                'label' => 'LBL_LEAD',
                'enabled' => true,
                'readonly' => false,
                'id' => 'LEAD_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'usuario',
                'label' => 'LBL_USUARIO',
                'enabled' => true,
                'readonly' => false,
                'id' => 'USER_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'qpro_gestion_encuestas_qpro_encuestas_name',
                'label' => 'LBL_QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTAS_FROM_QPRO_GESTION_ENCUESTAS_TITLE',
                'enabled' => true,
                'id' => 'QPRO_GESTION_ENCUESTAS_QPRO_ENCUESTASQPRO_GESTION_ENCUESTAS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'fecha_envio',
                'label' => 'LBL_FECHA_ENVIO',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'fecha_respuesta',
                'label' => 'LBL_FECHA_RESPUESTA',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              9 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
