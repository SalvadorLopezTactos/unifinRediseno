<?php
$viewdefs['Prospects'] = 
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
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'type' => 'fullname',
                'fields' => 
                array (
                  0 => 'salutation',
                  1 => 'first_name',
                  2 => 'last_name',
                ),
                'link' => true,
                'css_class' => 'full-name',
                'label' => 'LBL_LIST_NAME',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'regimen_fiscal_c',
                'label' => 'LBL_REGIMEN_FISCAL_C',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'estatus_po_c',
                'label' => 'LBL_ESTATUS_PO',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'subestatus_po_c',
                'label' => 'LBL_SUBESTATUS_PO',
                'enabled' => true,
                'readonly' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_LIST_PHONE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'email',
                'label' => 'LBL_LIST_EMAIL_ADDRESS',
                'sortable' => false,
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'assigned_user_id',
                ),
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
