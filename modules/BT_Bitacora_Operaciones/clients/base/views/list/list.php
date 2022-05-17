<?php
$module_name = 'BT_Bitacora_Operaciones';
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
                'name' => 'secuencia',
                'label' => 'LBL_SECUENCIA',
                'enabled' => true,
                'width' => '5%',
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'guid_operacion',
                'label' => 'LBL_GUID_OPERACION',
                'enabled' => true,
                'width' => '21%',
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'sortable' => false,
                'width' => '10%',
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'width' => '10%',
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'idsolicitud',
                'label' => 'LBL_IDSOLICITUD',
                'enabled' => true,
                'width' => '7%',
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'id_process',
                'label' => 'LBL_ID_PROCESS',
                'enabled' => true,
                'width' => '7%',
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'estatus',
                'label' => 'LBL_ESTATUS',
                'enabled' => true,
                'width' => '10%',
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'width' => '9%',
                'default' => false,
                'enabled' => true,
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
