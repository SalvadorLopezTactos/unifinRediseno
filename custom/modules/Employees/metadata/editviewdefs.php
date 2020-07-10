<?php
$viewdefs['Employees'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'form' => 
      array (
        'headerTpl' => 'modules/Employees/tpls/EditViewHeader.tpl',
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 'employee_status',
          1 => 
          array (
            'name' => 'picture',
            'label' => 'LBL_PICTURE_FILE',
          ),
        ),
        1 => 
        array (
          0 => 'first_name',
          1 => 
          array (
            'name' => 'last_name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
        ),
        2 => 
        array (
          0 => 'title',
          1 => 
          array (
            'name' => 'phone_work',
            'label' => 'LBL_OFFICE_PHONE',
          ),
        ),
        3 => 
        array (
          0 => 'department',
          1 => 'phone_mobile',
        ),
        4 => 
        array (
          0 => 'reports_to_name',
          1 => 'phone_other',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'no_empleado_c',
            'label' => 'LBL_NO_EMPLEADO',
          ),
          1 => '',
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'phone_fax',
            'label' => 'LBL_FAX',
          ),
          1 => 'phone_home',
        ),
        7 => 
        array (
          0 => 'messenger_type',
        ),
        8 => 
        array (
          0 => 'messenger_id',
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_NOTES',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'address_street',
            'type' => 'text',
            'label' => 'LBL_PRIMARY_ADDRESS',
            'displayParams' => 
            array (
              'rows' => 2,
              'cols' => 30,
            ),
          ),
          1 => 
          array (
            'name' => 'address_city',
            'label' => 'LBL_CITY',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'address_state',
            'label' => 'LBL_STATE',
          ),
          1 => 
          array (
            'name' => 'address_postalcode',
            'label' => 'LBL_POSTAL_CODE',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'address_country',
            'label' => 'LBL_COUNTRY',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'email',
            'label' => 'LBL_EMAIL',
          ),
        ),
      ),
    ),
  ),
);
