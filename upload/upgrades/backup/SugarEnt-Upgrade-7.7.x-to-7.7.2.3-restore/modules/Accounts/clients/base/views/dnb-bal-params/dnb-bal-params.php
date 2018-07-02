<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['Accounts']['base']['view']['dnb-bal-params'] = array(
    'action' => 'edit',
    "panels" => array(
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_PARAM_COMP',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'paramGrp' => 'companyLocation',
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_COUNTRY',
                            'name' => 'dnb_bal_ctry_lbl',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_ctry',
                            'type' => 'dnbenum',
                            'isMultiSelect' => true,
                            'options' => 'dnb_countries_iso',
                            'cell_css_class' => 'span3'
                        )
                    )
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_PARAM_STATES',
                            'tooltip' => 'LBL_TT_DNB_BAL_STATES',
                            'css' => 'dnb-bal-param-label',
                            'name' => 'dnb_bal_state_lbl'
                        ),
                        array(
                            'name' => 'dnb_bal_state',
                            'cell_css_class' => 'span2',
                            'placeholder' => "LBL_DNB_BAL_PARAM_STATES",
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 64
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-state-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-state-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_CI_CITY',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_city',
                            'cell_css_class' => 'span2',
                            'placeholder' => 'LBL_DNB_CI_CITY',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 240
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-city-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-city-tags'
                        ),
                    )
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_AREA_CODE',
                            'tooltip' => 'LBL_TT_DNB_BAL_AREA_CODE',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_area_code', //upper limit
                            'cell_css_class' => 'span2',
                            'placeholder' => 'LBL_DNB_BAL_AREA_CODE',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 16
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-area-code-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-area-code-tags'
                        ),
                    )
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_POSTAL_CODE',
                            'tooltip' => 'LBL_TT_DNB_BAL_POSTAL_CODE',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_postal_code',
                            'cell_css_class' => 'span2',
                            'placeholder' => 'LBL_DNB_BAL_POSTAL_CODE',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 16
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-postal-code-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-postal-code-tags'
                        ),
                    )
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_RADIUS_SRCH',
                            'tooltip' => 'LBL_TT_DNB_BAL_RADIUS_SRCH',
                            'css' => 'dnb-bal-param-label',
                            'name' => 'dnb_bal_rad_srch_lbl'
                        ),
                        array(
                            'name' => 'dnb_bal_dist_ctry',
                            'type' => 'enum',
                            'options' => 'dnb_countries_radius_iso',
                            'placeholder' => 'LBL_DNB_SLCT_CTRY',
                            'cell_css_class' => 'span2'
                        ),
                        array(
                            'name' => 'dnb_bal_distance',
                            'type' => 'float',
                            'placeholder' => 'LBL_DNB_BAL_DISTANCE',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 5
                        ),
                        array(
                            'name' => 'dnb_bal_distance_units',
                            'type' => 'enum',
                            'cell_css_class' => 'span2',
                            'options' => 'dnb_bal_miles_km'
                        ),
                        array(
                            'name' => 'dnb_bal_distance_zip',
                            'placeholder' => 'LBL_DNB_BAL_ZIP',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 16
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-rad-srch-btn'
                        ),
                    )
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer offset2 span3',
                            'id' => 'dnb-rad-srch-tags'
                        ),
                    )
                )
            ),
        ),
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_INDUSTRY',
            'paramGrp' => 'industry',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'name' => 'dnb_bal_ind_code_type',
                            'label' => 'LBL_DNB_BAL_IND_CODE_TYPE',
                            'tooltip' => 'LBL_TT_DNB_BAL_CODE_TYPE',
                            'type' => 'enum',
                            'cell_css_class' => 'span2',
                            'placeholder' => "LBL_DNB_BAL_IND_CODE_TYPE",
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_sic_naics_code'
                        ),
                        array(
                            'name' => 'dnb_bal_ind_filter',
                            'label' => 'LBL_DNB_BAL_IND_CODE_TYPE_PRI_SEC',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'placeholder' => "LBL_DNB_BAL_IND_CODE_TYPE_PRI_SEC",
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_primary_secondary'
                        ),
                        array(
                            'name' => 'dnb_bal_ind_code_val',
                            'tooltip' => 'LBL_TT_DNB_BAL_IND_CODE',
                            'type' => 'int',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 16
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-ind-code-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-ind-code-tags'
                        ),
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span10',
                            'default_value' => 'LBL_DNB_BAL_SIC_NAICS_EXAMPLE',
                            'css' => 'dnb-bal-param-label'
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_PARAM_COMP_SZ',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 5,
            'paramGrp' => 'companySize',
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'default_value' => 'LBL_DNB_BAL_PARAM_ANNL_SALES',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_sale',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_sales_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_annl_sale_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_sales_high', //upper limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-sales-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-annlsales-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_PARAM_EMP_CNT',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_cnt_cat',
                            'type' => 'enum',
                            'cell_css_class' => 'span2',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_single_all'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_cnt',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_cnt_low', //lower limit
                            'type' => 'int',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_annl_sale_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_cnt_high', //upper limit
                            'type' => 'int',
                            'cell_css_class' => 'span1',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-empcnt-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-empcnt-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_PARAM_EMP_GRWTH',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_grwth',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_grwth_low', //lower limit
                            'type' => 'float',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_annl_sale_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_emp_grwth_high', //upper limit
                            'type' => 'float',
                            'cell_css_class' => 'span1',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-empgrwth-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-bal-empgrwth-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_PARAM_MKT_CAP',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_mkt_cap',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_mkt_cap_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_annl_sale_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_mkt_cap_high', //upper limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-mktcap-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-mktcap-tags'
                        )
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_PARAM_COMP_INFORMATION',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'paramGrp' => 'companyInfo',
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_ORG_NAME',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_org_name',
                            'tooltip' => 'LBL_TT_DNB_BAL_ORG_NAME',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 240
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-org-name-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-org-name-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_YEAR_OF_FOUNDING',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_founding',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_year_of_founding_low', //lower limit
                            'type' => 'int',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'tooltip' => 'LBL_TT_DNB_BAL_YEAR_OF_FOUNDING',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 4
                        ),
                        array(
                            'name' => 'dnb_bal_year_of_founding_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_year_of_founding_high',
                            'tooltip' => 'LBL_TT_DNB_BAL_YEAR_OF_FOUNDING',
                            'type' => 'int',
                            'cell_css_class' => 'span1',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 4
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-year-founding-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-year-of-founding-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_PRESCREEN_SCORE',
                            'css' => 'dnb-bal-param-label',
                            'name' => 'dnb_bal_presc_lbl'
                        ),
                        array(
                            'name' => 'dnb_bal_prescreen_score',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'isMultiSelect' => true,
                            'tooltip' => 'LBL_TT_DNB_BAL_PRESCREEN_SCORE',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_prescreen_options'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_DUNS',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_duns',
                            'tooltip' => 'LBL_TT_DNB_BAL_DUNS',
                            'type' => 'int',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 15
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-duns-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-duns-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_GU_DUNS',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_gu_duns',
                            'tooltip' => 'LBL_TT_DNB_BAL_DUNS',
                            'type' => 'int',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 15
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-gu-duns-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-gu-duns-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_ORG_ID',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_org_id',
                            'tooltip' => 'LBL_TT_DNB_BAL_ORGID',
                            'type' => 'int',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 40
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-org-id-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-bal-org-id-tags'
                        )
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_FINANCIAL_INFO',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'paramGrp' => 'financialInfo',
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_NET_INCOME',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_high',
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-net-income-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-net-income-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_NET_INCOME_GROWTH',
                            'tooltip' => 'LBL_TT_DNB_BAL_NET_INCOME_GROWTH',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_growth',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_growth_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_NET_INCOME_GROWTH',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_growth_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_net_income_growth_high',
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_NET_INCOME_GROWTH',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-net-income-growth-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-net-income-growth-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_ASSETS',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_assets',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_assets_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_assets_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_assets_high',
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS_EX',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-assets-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-net-assets-tags'
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name' => 'panel_body',
            'title' => 'LBL_DNB_BAL_IPO_DATA',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'paramGrp' => 'ipoData',
            'labelsOnTop' => true,
            'placeholders' => true,
            'rows' => array(
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_IPO_OFFER_AMT',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_offer_amt',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_offer_amt_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_offer_amt_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_offer_amt_high',
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_MILLIONS',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-offer-amt-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-offer-amt-tags'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_BAL_IPO_PRICE_RANGE',
                            'tooltip' => 'LBL_TT_DNB_BAL_IPO_PRICE_RANGE',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_price_range',
                            'type' => 'enum',
                            'cell_css_class' => 'span3',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_gte_lte_btw'
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_price_range_low', //lower limit
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_IPO_PRICE_RANGE',
                            'cell_css_class' => 'hide toggleCandidate span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_price_range_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_price_range_high',
                            'type' => 'float',
                            'tooltip' => 'LBL_TT_DNB_BAL_IPO_PRICE_RANGE',
                            'cell_css_class' => 'span2',
                            'no_required_placeholder' => true,
                            'required' => true,
                            'len' => 7
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-ipo-price-range-btn'
                        ),
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3',
                            'id' => 'dnb-ipo-price-range-tags'
                        )
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'label',
                            'cell_css_class' => 'span2',
                            'default_value' => 'LBL_DNB_IPO_DATE',
                            'css' => 'dnb-bal-param-label'
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_date_cat',
                            'type' => 'enum',
                            'cell_css_class' => 'span2',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_filing_trading_option'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'name' => 'dnb_bal_ipo_date',
                            'type' => 'enum',
                            'cell_css_class' => 'span2 offset2',
                            'searchBarThreshold' => -1,
                            'options' => 'dnb_bal_after_before_btw',
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_date_low', //lower limit
                            'type' => 'date',
                            'format' => 'Y-m-d',
                            'cell_css_class' => 'hide toggleCandidate span2',
                        ),
                        array(
                            'name' => 'dnb_bal_annl_sale_and_str',
                            'type' => 'label',
                            'cell_css_class' => 'hide toggleCandidate span1',
                            'css' => 'dnb-bal-param-label',
                            'default_value' => 'LBL_DNB_AND'
                        ),
                        array(
                            'name' => 'dnb_bal_ipo_date_high', //upper limit
                            'type' => 'date',
                            'format' => 'Y-m-d',
                            'cell_css_class' => 'span2',
                        ),
                        array(
                            'type' => 'rowaction',
                            'cell_css_class' => 'span1',
                            'icon' => 'fa-plus',
                            'css_class' => 'dnb-bal-add-btn btn',
                            'event' => 'dnb-bal-ipo-date-btn'
                        ),
                    ),
                ),
                array(
                    'fields' => array(
                        array(
                            'type' => 'tagcontainer',
                            'cell_css_class' => 'tagcontainer span3 offset2',
                            'id' => 'dnb-ipo-date-tags'
                        ),
                    ),
                ),
            ),
        ),
    ),
    'balSelector' => array(
        'dnb-bal-sales-btn' => array(
            'operator' => 'dnb_bal_sale',
            'lowerLimit' => 'dnb_bal_sales_low',
            'upperLimit' => 'dnb_bal_sales_high',
            'addBtn' => '.dnb-bal-sales-btn',
            'container' => '#dnb-annlsales-tags',
            'tagLimit' => 1,
            'modelKey' => 'annualSales', //keys to be used in model
            'lowKey' => 'SalesLowRangeAmount', //keys to be used in model
            'highKey' => 'SalesHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-year-founding-btn' => array(
            'operator' => 'dnb_bal_founding',
            'lowerLimit' => 'dnb_bal_year_of_founding_low',
            'upperLimit' => 'dnb_bal_year_of_founding_high',
            'addBtn' => '.dnb-bal-year-founding-btn',
            'container' => '#dnb-year-of-founding-tags',
            'tagLimit' => 1,
            'modelKey' => 'foundingYear', //keys to be used in model
            'lowKey' => 'ControlOwnershipFromYear', //keys to be used in model
            'highKey' => 'ControlOwnershipToYear'//keys to be used in model
        ),
        'dnb-bal-offer-amt-btn' => array(
            'operator' => 'dnb_bal_offer_amt',
            'lowerLimit' => 'dnb_bal_offer_amt_low',
            'upperLimit' => 'dnb_bal_offer_amt_high',
            'addBtn' => '.dnb-bal-offer-amt-btn',
            'container' => '#dnb-offer-amt-tags',
            'tagLimit' => 1,
            'modelKey' => 'ipoOfferAmt', //keys to be used in model
            'lowKey' => 'InitialPublicOfferingLowRangeAmount', //keys to be used in model
            'highKey' => 'InitialPublicOfferingHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-ipo-price-range-btn' => array(
            'operator' => 'dnb_bal_ipo_price_range',
            'lowerLimit' => 'dnb_bal_ipo_price_range_low',
            'upperLimit' => 'dnb_bal_ipo_price_range_high',
            'addBtn' => '.dnb-bal-ipo-price-range-btn',
            'container' => '#dnb-ipo-price-range-tags',
            'tagLimit' => 1,
            'modelKey' => 'ipoPriceRange', //keys to be used in model
            'lowKey' => 'InitialPublicOfferingShareValueLowRangeAmount', //keys to be used in model
            'highKey' => 'InitialPublicOfferingShareValueHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-net-income-btn' => array(
            'operator' => 'dnb_bal_net_income',
            'lowerLimit' => 'dnb_bal_net_income_low',
            'upperLimit' => 'dnb_bal_net_income_high',
            'addBtn' => '.dnb-bal-net-income-btn',
            'container' => '#dnb-net-income-tags',
            'tagLimit' => 1,
            'modelKey' => 'netIncome', //keys to be used in model
            'lowKey' => 'NetIncomeLowRangeAmount', //keys to be used in model
            'highKey' => 'NetIncomeHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-net-income-growth-btn' => array(
            'operator' => 'dnb_bal_net_income_growth',
            'lowerLimit' => 'dnb_bal_net_income_growth_low',
            'upperLimit' => 'dnb_bal_net_income_growth_high',
            'addBtn' => '.dnb-bal-net-income-growth-btn',
            'container' => '#dnb-net-income-growth-tags',
            'tagLimit' => 1,
            'modelKey' => 'netIncomeGrowth', //keys to be used in model
            'lowKey' => 'NetIncomeGrowthLowRangePercentage', //keys to be used in model
            'highKey' => 'NetIncomeGrowthHighRangePercentage'//keys to be used in model
        ),
        'dnb-bal-assets-btn' => array(
            'operator' => 'dnb_bal_assets',
            'lowerLimit' => 'dnb_bal_assets_low',
            'upperLimit' => 'dnb_bal_assets_high',
            'addBtn' => '.dnb-bal-assets-btn',
            'container' => '#dnb-net-assets-tags',
            'tagLimit' => 1,
            'modelKey' => 'assets', //keys to be used in model
            'lowKey' => 'TotalAssetLowRangeAmount', //keys to be used in model
            'highKey' => 'TotalAssetHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-empcnt-btn' => array(
            'operator' => 'dnb_bal_emp_cnt',
            'lowerLimit' => 'dnb_bal_emp_cnt_low',
            'upperLimit' => 'dnb_bal_emp_cnt_high',
            'addBtn' => '.dnb-bal-empcnt-btn',
            'container' => '#dnb-empcnt-tags',
            'tagLimit' => 1,
            'keyType' => 'dnb_bal_emp_cnt_cat',
            'modelKey' => 'employeeCount', //keys to be used in model
            'singlesite' => array(
                'lowKey' => 'IndividualEntityEmployeeLowRangeQuantity', //keys to be used in model
                'highKey' => 'IndividualEntityEmployeeHighRangeQuantity'//keys to be used in model
            ),
            'allsites' => array(
                'lowKey' => 'ConsolidatedEmployeeLowRangeQuantity', //keys to be used in model
                'highKey' => 'ConsolidatedEmployeeHighRangeQuantity'//keys to be used in model
            )
        ),
        'dnb-bal-ipo-date-btn' => array(
            'operator' => 'dnb_bal_ipo_date',
            'lowerLimit' => 'dnb_bal_ipo_date_low',
            'upperLimit' => 'dnb_bal_ipo_date_high',
            'addBtn' => '.dnb-bal-ipo-date-btn',
            'container' => '#dnb-ipo-date-tags',
            'tagLimit' => 1,
            'keyType' => 'dnb_bal_ipo_date_cat',
            'modelKey' => 'ipoDate', //keys to be used in model
            'filingdate' => array(
                'lowKey' => 'InitialPublicOfferingFilingFromDate', //keys to be used in model
                'highKey' => 'InitialPublicOfferingFilingToDate'//keys to be used in model
            ),
            'tradingdate' => array(
                'lowKey' => 'InitialPublicOfferingTradingFromDate', //keys to be used in model
                'highKey' => 'InitialPublicOfferingTradingToDate'//keys to be used in model
            )
        ),
        'dnb-bal-empgrwth-btn' => array(
            'operator' => 'dnb_bal_emp_grwth',
            'lowerLimit' => 'dnb_bal_emp_grwth_low',
            'upperLimit' => 'dnb_bal_emp_grwth_high',
            'addBtn' => '.dnb-bal-empgrwth-btn',
            'container' => '#dnb-bal-empgrwth-tags',
            'tagLimit' => 1,
            'modelKey' => 'employeeGrowth', //keys to be used in model
            'lowKey' => 'ConsolidatedEmployeesGrowthLowRangePercentage', //keys to be used in model
            'highKey' => 'ConsolidatedEmployeesGrowthHighRangePercentage'//keys to be used in model
        ),
        'dnb-bal-mktcap-btn' => array(
            'operator' => 'dnb_bal_mkt_cap',
            'lowerLimit' => 'dnb_bal_mkt_cap_low',
            'upperLimit' => 'dnb_bal_mkt_cap_high',
            'addBtn' => '.dnb-bal-mktcap-btn',
            'container' => '#dnb-mktcap-tags',
            'tagLimit' => 1,
            'modelKey' => 'marketCap', //keys to be used in model
            'lowKey' => 'MarketCapitalizationLowRangeAmount', //keys to be used in model
            'highKey' => 'MarketCapitalizationHighRangeAmount'//keys to be used in model
        ),
        'dnb-bal-area-code-btn' => array(
            'addBtn' => '.dnb-bal-area-code-btn',
            'container' => '#dnb-area-code-tags',
            'tagLimit' => 100,
            'inputKey' => 'dnb_bal_area_code',
            'modelKey' => 'phoneAreaCode', //keys to be used in model
            'modelSubKey' => 'TelephoneNumberAreaCode-'
        ),
        'dnb-bal-duns-btn' => array(
            'addBtn' => '.dnb-bal-duns-btn',
            'container' => '#dnb-duns-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_duns',
            'modelKey' => 'dunsNum', //keys to be used in model
            'modelSubKey' => 'DUNSNumber-'
        ),
        'dnb-bal-gu-duns-btn' => array(
            'addBtn' => '.dnb-bal-gu-duns-btn',
            'container' => '#dnb-gu-duns-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_gu_duns',
            'modelKey' => 'guDunsNum', //keys to be used in model
            'modelSubKey' => 'GlobalUltimateDUNSNumber-'
        ),
        'dnb-bal-org-name-btn' => array(
            'addBtn' => '.dnb-bal-org-name-btn',
            'container' => '#dnb-org-name-tags',
            'tagLimit' => 1,
            'inputKey' => 'dnb_bal_org_name',
            'modelKey' => 'orgName', //keys to be used in model
            'modelSubKey' => 'OrganizationName'
        ),
        'dnb-bal-postal-code-btn' => array(
            'addBtn' => '.dnb-bal-postal-code-btn',
            'container' => '#dnb-postal-code-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_postal_code',
            'modelKey' => 'postalCode', //keys to be used in model
            'modelSubKey' => 'PostalCode-'
        ),
        'dnb-bal-city-btn' => array(
            'addBtn' => '.dnb-bal-city-btn',
            'container' => '#dnb-city-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_city',
            'modelKey' => 'city', //keys to be used in model
            'modelSubKey' => 'PrimaryTownName-'
        ),
        'dnb-bal-state-btn' => array(
            'addBtn' => '.dnb-bal-state-btn',
            'container' => '#dnb-state-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_state',
            'modelKey' => 'state', //keys to be used in model
            'modelSubKey' => 'TerritoryName-'
        ),
        'dnb_bal_ctry' => array(
            'modelSubKey' => 'CountryISOAlpha2Code-',
            'modelKey' => 'country',
            'multiple' => true
        ),
        'dnb_bal_prescreen_score' => array(
            'modelSubKey' => 'MarketingRiskClassCode-',
            'modelKey' => 'prescreenScore',
            'multiple' => true
        ),
        'dnb-bal-ind-code-btn' => array(
            'addBtn' => '.dnb-bal-ind-code-btn',
            'container' => '#dnb-ind-code-tags',
            'operator' => array('dnb_bal_ind_code_type', 'dnb_bal_ind_filter'),
            'tagLimit' => 10,
            'modelKey' => 'industryCode', //keys to be used in model
            'modelSubKey' => array('IndustryCodeTypeCode', 'PrimaryIndustryCodeOnlyIndicator'),
            'tagSource' => 'dnb_bal_ind_code_val',
            'tagDest' => 'IndustryCode-'
        ),
        'dnb-bal-rad-srch-btn' => array(
            'addBtn' => '.dnb-bal-rad-srch-btn',
            'container' => '#dnb-rad-srch-tags',
            'operator' => array('dnb_bal_dist_ctry', 'dnb_bal_distance_units', 'dnb_bal_distance', 'dnb_bal_distance_zip'),
            'tagLimit' => 1,
            'modelKey' => 'radiusSearch', //keys to be used in model
            'modelSubKey' => array('RadiusSearchCountryISOAlpha2Code', 'RadiusMeasurementUnitCode', 'RadiusMeasurement', 'RadiusSearchPostalCode')
        ),
        'dnb-bal-org-id-btn' => array(
            'addBtn' => '.dnb-bal-org-id-btn',
            'container' => '#dnb-bal-org-id-tags',
            'tagLimit' => 10,
            'inputKey' => 'dnb_bal_org_id',
            'modelKey' => 'orgid', //keys to be used in model
            'modelSubKey' => 'OrganizationIdentificationNumber-'
        )
    ),
    'balParamGroups' => array(
        'companySize' => array(
            'annualSales' => array(
                'label' => 'LBL_DNB_BAL_PARAM_ANNL_SALES',
                'id' => 'dnb-annlsales-tags'
            ),
            'employeeCount' => array(
                'label' => 'LBL_DNB_BAL_PARAM_EMP_CNT',
                'id' => 'dnb-empcnt-tags'
            ),
            'employeeGrowth' => array(
                'label' => 'LBL_DNB_BAL_PARAM_EMP_GRWTH',
                'id' => 'dnb-bal-empgrwth-tags'
            ),
            'marketCap' => array(
                'label' => 'LBL_DNB_BAL_PARAM_MKT_CAP',
                'id' => 'dnb-mktcap-tags'
            )
        ),
        'companyLocation' => array(
            'phoneAreaCode' => array(
                'label' => 'LBL_DNB_BAL_AREA_CODE',
                'id' => 'dnb-area-code-tags'
            ),
            'postalCode' => array(
                'label' => 'LBL_DNB_BAL_POSTAL_CODE',
                'id' => 'dnb-postal-code-tags'
            ),
            'city' => array(
                'label' => 'LBL_DNB_CI_CITY',
                'id' => 'dnb-city-tags'
            ),
            'state' => array(
                'label' => 'LBL_DNB_BAL_PARAM_STATES',
                'id' => 'dnb-state-tags'
            ),
            'country' => array(
                'label' => 'LBL_DNB_COUNTRY',
                'select2' => 'dnb_bal_ctry'
            ),
            'radiusSearch' => array(
                'label' => 'LBL_DNB_BAL_RADIUS_SRCH',
                'id' => 'dnb-rad-srch-tags'
            )
        ),
        'financialInfo' => array(
            'netIncome' => array(
                'label' => 'LBL_DNB_BAL_NET_INCOME',
                'id' => 'dnb-net-income-tags'
            ),
            'netIncomeGrowth' => array(
                'label' => 'LBL_DNB_BAL_NET_INCOME_GROWTH',
                'id' => 'dnb-net-income-growth-tags'
            ),
            'assets' => array(
                'label' => 'LBL_DNB_BAL_ASSETS',
                'id' => 'dnb-net-assets-tags'
            )
        ),
        'ipoData' => array(
            'ipoOfferAmt' => array(
                'label' => 'LBL_DNB_BAL_IPO_OFFER_AMT',
                'id' => 'dnb-offer-amt-tags'
            ),
            'ipoPriceRange' => array(
                'label' => 'LBL_DNB_BAL_IPO_PRICE_RANGE',
                'id' => 'dnb-ipo-price-range-tags'
            ),
            'ipoDate' => array(
                'label' => 'LBL_DNB_IPO_DATE',
                'id' => 'dnb-ipo-date-tags'
            )
        ),
        'companyInfo' => array(
            'orgName' => array(
                'label' => 'LBL_DNB_BAL_ORG_NAME',
                'id' => 'dnb-org-name-tags'
            ),
            'foundingYear' => array(
                'label' => 'LBL_DNB_BAL_YEAR_OF_FOUNDING',
                'id' => 'dnb-year-of-founding-tags'
            ),
            'prescreenScore' => array(
                'label' => 'LBL_DNB_BAL_PRESCREEN_SCORE',
                'select2' => 'dnb_bal_prescreen_score'
            ),
            'dunsNum' => array(
                'label' => 'LBL_DNB_BAL_DUNS',
                'id' => 'dnb-duns-tags'
            ),
            'guDunsNum' => array(
                'label' => 'LBL_DNB_BAL_GU_DUNS',
                'id' => 'dnb-gu-duns-tags'
            ),
            'orgid' => array(
                'label' => 'LBL_DNB_BAL_ORG_ID',
                'id' => 'dnb-bal-org-id-tags'
            )
        ),
        'industry' => array(
            'industryCode' => array(
                'id' => 'dnb-ind-code-tags'
            )
        )
    )
);
