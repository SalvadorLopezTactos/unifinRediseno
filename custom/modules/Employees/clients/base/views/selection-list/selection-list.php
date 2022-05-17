<?php
$viewdefs['Employees'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'selection-list' => 
      array (
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
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              1 => 
              array (
                'name' => 'department',
                'label' => 'LBL_DEPARTMENT',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              2 => 
              array (
                'name' => 'puestousuario_c',
                'label' => 'LBL_PUESTOUSUARIO',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'title',
                'label' => 'LBL_TITLE',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              4 => 
              array (
                'name' => 'reports_to_name',
                'label' => 'LBL_REPORTS_TO_NAME',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              5 => 
              array (
                'name' => 'email',
                'label' => 'LBL_EMAIL',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              6 => 
              array (
                'name' => 'phone_work',
                'label' => 'LBL_OFFICE_PHONE',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'default' => true,
                'sortable' => true,
              ),
              8 => 
              array (
                'name' => 'employee_status',
                'label' => 'LBL_EMPLOYEE_STATUS',
                'enabled' => true,
                'default' => false,
                'sortable' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
