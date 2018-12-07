<?php
// created: 2018-12-06 16:15:49
$viewdefs['Leads']['base']['view']['record'] = array (
  'buttons' => 
  array (
    0 => 
    array (
      'type' => 'button',
      'name' => 'cancel_button',
      'label' => 'LBL_CANCEL_BUTTON_LABEL',
      'css_class' => 'btn-invisible btn-link',
      'showOn' => 'edit',
    ),
    1 => 
    array (
      'type' => 'rowaction',
      'event' => 'button:save_button:click',
      'name' => 'save_button',
      'label' => 'LBL_SAVE_BUTTON_LABEL',
      'css_class' => 'btn btn-primary',
      'showOn' => 'edit',
      'acl_action' => 'edit',
    ),
    2 => 
    array (
      'type' => 'actiondropdown',
      'name' => 'main_dropdown',
      'primary' => true,
      'showOn' => 'view',
      'buttons' => 
      array (
        0 => 
        array (
          'type' => 'rowaction',
          'event' => 'button:edit_button:click',
          'name' => 'edit_button',
          'label' => 'LBL_EDIT_BUTTON_LABEL',
          'acl_action' => 'edit',
        ),
      ),
    ),
    3 => 
    array (
      'name' => 'sidebar_toggle',
      'type' => 'sidebartoggle',
    ),
  ),
  'panels' => 
  array (
    0 => 
    array (
      'name' => 'panel_header',
      'header' => true,
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'picture',
          'type' => 'avatar',
          'size' => 'large',
          'dismiss_label' => true,
        ),
        1 => 
        array (
          'type' => 'favorite',
        ),
        2 => 
        array (
          'type' => 'follow',
          'readonly' => true,
        ),
        3 => 
        array (
          'name' => 'badge',
          'type' => 'badge',
          'readonly' => true,
          'related_fields' => 
          array (
            0 => 'converted',
            1 => 'account_id',
            2 => 'contact_id',
            3 => 'contact_name',
            4 => 'opportunity_id',
            5 => 'opportunity_name',
          ),
        ),
        4 => 
        array (
          'name' => 'name',
          'type' => 'fullname',
          'label' => 'LBL_NAME',
          'dismiss_label' => true,
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'salutation',
              'type' => 'enum',
              'enum_width' => 'auto',
              'searchBarThreshold' => 7,
            ),
            1 => 'first_name',
            2 => 'last_name',
          ),
        ),
      ),
    ),
    1 => 
    array (
      'name' => 'panel_body',
      'label' => 'LBL_RECORD_BODY',
      'columns' => 2,
      'labels' => true,
      'labelsOnTop' => true,
      'placeholders' => true,
      'newTab' => false,
      'panelDefault' => 'expanded',
      'fields' => 
      array (
        0 => 
        array (
          'name' => 'status',
        ),
        1 => 
        array (
          'name' => 'regimen_fiscal_c',
          'studio' => 'visible',
          'label' => 'LBL_REGIMEN_FISCAL',
        ),
        2 => 
        array (
          'name' => 'primernombre_c',
          'label' => 'LBL_PRIMERNOMBRE',
        ),
        3 => 
        array (
          'name' => 'segundonombre_c',
          'label' => 'LBL_SEGUNDONOMBRE',
        ),
        4 => 
        array (
          'name' => 'apellidopaterno_c',
          'label' => 'LBL_APELLIDOPATERNO',
        ),
        5 => 
        array (
          'name' => 'apellidomaterno_c',
          'label' => 'LBL_APELLIDOMATERNO',
        ),
        6 => 
        array (
          'name' => 'razonsocial_c',
          'label' => 'LBL_RAZONSOCIAL',
        ),
        7 => 
        array (
        ),
        8 => 
        array (
          'name' => 'email',
          'span' => 12,
        ),
        9 => 
        array (
          'name' => 'phone_home',
          'comment' => 'Home phone number of the contact',
          'label' => 'LBL_HOME_PHONE',
        ),
        10 => 'phone_work',
        11 => 
        array (
          'name' => 'phone_mobile',
        ),
        12 => 
        array (
        ),
        13 => 
        array (
          'name' => 'tag',
          'span' => 12,
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'useTabs' => false,
  ),
);