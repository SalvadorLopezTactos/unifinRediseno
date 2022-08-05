<?php
// created: 2018-02-16 17:22:03
$viewdefs['Leads']['base']['view']['recordlist'] = array (
  'selection' => 
  array (
    'type' => 'multi',
    'actions' => 
    array (
      0 => 
      array (
        'name' => 'mass_email_button',
        'type' => 'mass-email-button',
        'label' => 'LBL_EMAIL_COMPOSE',
        'primary' => true,
        'events' => 
        array (
          'click' => 'list:massaction:hide',
        ),
        'acl_module' => 'Emails',
        'acl_action' => 'edit',
        'related_fields' => 
        array (
          0 => 'name',
          1 => 'email',
        ),
      ),
    ),
  ),
  'rowactions' => 
  array (
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'rowaction',
        'css_class' => 'btn',
        'tooltip' => 'LBL_PREVIEW',
        'event' => 'list:preview:fire',
        'icon' => 'fa-eye',
        'acl_action' => 'view',
      ),
    ),
  ),
);