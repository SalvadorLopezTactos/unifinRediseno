<?php
$module_name = 'Lic_Licitaciones';
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
                'name' => 'leads_lic_licitaciones_1_name',
                'label' => 'LBL_LEADS_LIC_LICITACIONES_1_FROM_LEADS_TITLE',
                'enabled' => true,
                'id' => 'LEADS_LIC_LICITACIONES_1LEADS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'lic_licitaciones_accounts_name',
                'label' => 'LBL_LIC_LICITACIONES_ACCOUNTS_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'LIC_LICITACIONES_ACCOUNTSACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'institucion',
                'label' => 'LBL_INSTITUCION',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'monto_total',
                'label' => 'LBL_MONTO_TOTAL',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
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
