<?php
$viewdefs['Employees'] = 
array (
  'QuickCreate' => 
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
        'headerTpl' => 'modules/Users/tpls/EditViewHeader.tpl',
        'footerTpl' => 'modules/Users/tpls/EditViewFooter.tpl',
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'LBL_EMPLOYEE_INFORMATION' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_EMPLOYEE_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'employee_status',
            'customCode' => '{if $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$EMPLOYEE_STATUS_READONLY}{/if}',
          ),
          1 => 
          array (
            'name' => 'title',
            'customCode' => '{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$TITLE_READONLY}{/if}',
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
          0 => 
          array (
            'name' => 'department',
            'customCode' => '{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$DEPT_READONLY}{/if}',
          ),
          1 => 'phone_work',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'reports_to_name',
            'customCode' => '{if  $EDIT_REPORTS_TO || $IS_ADMIN}@@FIELD@@{else}{$REPORTS_TO_READONLY}{/if}',
          ),
          1 => 
          array (
            'name' => 'email1',
            'displayParams' => 
            array (
              'required' => false,
            ),
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'no_empleado_c',
            'label' => 'LBL_NO_EMPLEADO',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
