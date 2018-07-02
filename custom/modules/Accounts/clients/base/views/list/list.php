<?php
// created: 2018-01-10 13:44:21
$viewdefs['Accounts']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'name',
          'link' => true,
          'label' => 'LBL_LIST_ACCOUNT_NAME',
          'enabled' => true,
          'default' => true,
          'width' => 'xlarge',
        ),
        1 => 
        array (
          'name' => 'rfc_c',
          'label' => 'LBL_RFC',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'idcliente_c',
          'label' => 'LBL_IDCLIENTE',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'tipo_registro_c',
          'label' => 'LBL_TIPO_REGISTRO',
          'enabled' => true,
          'width' => '10%',
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'email',
          'label' => 'LBL_EMAIL_ADDRESS',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'promotorleasing_c',
          'label' => 'LBL_PROMOTORLEASING',
          'enabled' => true,
          'id' => 'USER_ID_C',
          'link' => true,
          'sortable' => false,
          'width' => '10%',
          'default' => true,
        ),
        6 => 
        array (
          'name' => 'promotorfactoraje_c',
          'label' => 'LBL_PROMOTORFACTORAJE',
          'enabled' => true,
          'id' => 'USER_ID1_C',
          'link' => true,
          'sortable' => false,
          'width' => '10%',
          'default' => true,
        ),
        7 => 
        array (
          'name' => 'promotorcredit_c',
          'label' => 'LBL_PROMOTORCREDIT',
          'enabled' => true,
          'id' => 'USER_ID2_C',
          'link' => true,
          'sortable' => false,
          'width' => '10%',
          'default' => true,
        ),
      ),
    ),
  ),
  /*Salvador Lopez <salvador.lopez@tactos.com.mx>
  Ordenar lista por fecha de modificación
  */
  'orderBy' =>
        array (
            'field' => 'date_modified',
            'direction' => 'desc',
        ),
);