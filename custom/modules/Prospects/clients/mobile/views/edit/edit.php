<?php
$viewdefs['Prospects'] = 
array (
  'mobile' => 
  array (
    'view' => 
    array (
      'edit' => 
      array (
        'templateMeta' => 
        array (
          'maxColumns' => '1',
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
        ),
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'first_name',
                'customCode' => '{html_options name="salutation" options=$fields.salutation.options selected=$fields.salutation.value}&nbsp;<input name="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              1 => 
              array (
                'name' => 'last_name',
                'displayParams' => 
                array (
                  'wireless_edit_only' => true,
                ),
              ),
              2 => 
              array (
                'name' => 'phone_work',
              ),
              3 => 'email',
              4 => 'assigned_user_name',
              5 => 'team_name',
            ),
          ),
        ),
      ),
    ),
  ),
);
