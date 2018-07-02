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

$viewdefs['base']['view']['dnb-lite-company-info'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DNB_LITE_COMPANY_INFO',
            'description' => 'LBL_DNB_LITE_COMPANY_INFO_DESC',
            'filter' => array(
                'module' => array(
                    'Accounts',
                ),
                'view' => 'record'
            ),
            'config' => array(
                'compname' => '1',
                'tradename' => '1',
                'locationtype' => '1',
                'primaddrstreet' => '1',
                'primaddrcity' => '1',
                'primaddrstateabbr' => '1',
                'primaddrstate' => '1',
                'primaddrctrycd' => '1',
                'primaddrctrygrp' => '1',
                'primaddrzip' => '1',
                'uscensuscd' => '1',
                'mailingaddrstreet' => '1',
                'mailingaddrcity' => '1',
                'mailingaddrstateabbr' => '1',
                'mailingaddrzip' => '1',
                'mailingaddrctrycd' => '1',
                'long' => '1',
                'lat' => '1',
                'phone' => '1',
                'fax' => '1',
                'webpage' => '1',
                'indempcnt' => '1',
                'conempcnt' => '1',
                'lob' => '1',
                'lastupddate' => '1',
                'marketind' => '1',
                'indcodes' => '1',
            ),
            'preview' => array(
                'compname' => '1',
                'tradename' => '1',
                'locationtype' => '1',
                'primaddrstreet' => '1',
                'primaddrcity' => '1',
                'primaddrstateabbr' => '1',
                'primaddrstate' => '1',
                'primaddrctrycd' => '1',
                'primaddrctrygrp' => '1',
                'primaddrzip' => '1',
                'uscensuscd' => '1',
                'mailingaddrstreet' => '1',
                'mailingaddrcity' => '1',
                'mailingaddrstateabbr' => '1',
                'mailingaddrzip' => '1',
                'mailingaddrctrycd' => '1',
                'long' => '1',
                'lat' => '1',
                'phone' => '1',
                'fax' => '1',
                'webpage' => '1',
                'indempcnt' => '1',
                'conempcnt' => '1',
                'lob' => '1',
                'lastupddate' => '1',
                'marketind' => '1',
                'indcodes' => '1',
            ),
        ),
    ),
    'custom_toolbar' => array(
        'buttons' => array(
            array(
                'dropdown_buttons' => array(
                    array(
                        'type' => 'dashletaction',
                        'action' => 'editClicked',
                        'label' => 'LBL_DASHLET_CONFIG_EDIT_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'refreshClicked',
                        'label' => 'LBL_DASHLET_REFRESH_LABEL',
                    ),
                    array(
                        'type' => 'dashletaction',
                        'action' => 'removeClicked',
                        'label' => 'LBL_DASHLET_REMOVE_LABEL',
                    ),
                )
            ),
            array(
                "type" => "dashletaction",
                "css_class" => "dashlet-toggle btn btn-invisible minify",
                "icon" => "icon-chevron-down",
                "action" => "toggleMinify",
                "tooltip" => "LBL_DASHLET_MAXIMIZE",
            )
        )
    ),
    'config' => array(
        'fields' => array(
            array(
                'name' => 'compname',
                'label' => 'LBL_DNB_PRIM_NAME',
                'desc' => 'LBL_DNB_PRIM_NAME_DESC',
                'header' => 'LBL_DNB_ORG_NAME',
                'header_desc' => 'LBL_DNB_ORG_NAME_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'tradename',
                'label' => 'LBL_DNB_TRD_NAME',
                'desc' => 'LBL_DNB_TRD_NAME_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'locationtype',
                'label' => 'LBL_DNB_LOCATION_TYPE',
                'desc' => 'LBL_DNB_LOCATION_TYPE_DESC',
                'header' => 'LBL_DNB_ORG_DET',
                'header_desc' => 'LBL_DNB_ORG_DET_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrstreet',
                'label' => 'LBL_DNB_PRIM_STREET',
                'desc' => 'LBL_DNB_PRIM_STREET_DESC',
                'header' => 'LBL_DNB_LOC',
                'header_desc' => 'LBL_DNB_LOC_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrcity',
                'label' => 'LBL_DNB_PRIM_CITY',
                'desc' => 'LBL_DNB_PRIM_CITY_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrstateabbr',
                'label' => 'LBL_DNB_PRIM_STATE_ABBR',
                'desc' => 'LBL_DNB_PRIM_STATE_ABBR_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrstate',
                'label' => 'LBL_DNB_PRIM_STATE',
                'desc' => 'LBL_DNB_PRIM_STATE_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrctrycd',
                'label' => 'LBL_DNB_PRIM_CTRY_CD',
                'desc' => 'LBL_DNB_PRIM_CTRY_CD_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrctrygrp',
                'label' => 'LBL_DNB_PRIM_CTRY_GRP',
                'desc' => 'LBL_DNB_PRIM_CTRY_GRP_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'primaddrzip',
                'label' => 'LBL_DNB_PRIM_ZIP',
                'desc' => 'LBL_DNB_PRIM_ZIP_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'uscensuscd',
                'label' => 'LBL_DNB_PRIM_CEN_CD',
                'desc' => 'LBL_DNB_PRIM_CEN_CD_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'mailingaddrstreet',
                'label' => 'LBL_DNB_MAIL_STREET',
                'desc' => 'LBL_DNB_PRIM_STREET_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'mailingaddrcity',
                'label' => 'LBL_DNB_MAIL_CITY',
                'desc' => 'LBL_DNB_PRIM_CITY_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'mailingaddrstateabbr',
                'label' => 'LBL_DNB_MAIL_STATE_ABBR',
                'desc' => 'LBL_DNB_PRIM_STATE_ABBR_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'mailingaddrzip',
                'label' => 'LBL_DNB_MAIL_ZIP',
                'desc' => 'LBL_DNB_PRIM_ZIP_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'mailingaddrctrycd',
                'label' => 'LBL_DNB_MAIL_CTRY_CD',
                'desc' => 'LBL_DNB_PRIM_CTRY_CD_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'long',
                'label' => 'LBL_DNB_LAT',
                'desc' => 'LBL_DNB_LAT_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'lat',
                'label' => 'LBL_DNB_LONG',
                'desc' => 'LBL_DNB_LONG_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'phone',
                'label' => 'LBL_DNB_PHONE',
                'desc' => 'LBL_DNB_PHONE_DESC',
                'header' => 'LBL_DNB_TELECOMM',
                'header_desc' => 'LBL_DNB_TELECOMM_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'fax',
                'label' => 'LBL_DNB_FAX',
                'desc' => 'LBL_DNB_FAX_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'webpage',
                'label' => 'LBL_DNB_WEBPAGE',
                'desc' => 'LBL_DNB_WEBPAGE_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'indempcnt',
                'label' => 'LBL_DNB_IND_EMP_CNT',
                'desc' => 'LBL_DNB_IND_EMP_CNT_DESC',
                'header' => 'LBL_DNB_EMP_INF',
                'header_desc' => 'LBL_DNB_EMP_INF_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'conempcnt',
                'label' => 'LBL_DNB_CON_EMP_CNT',
                'desc' => 'LBL_DNB_CON_EMP_CNT_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'lob',
                'label' => 'LBL_DNB_LOB',
                'desc' => 'LBL_DNB_LOB_DESC',
                'header' => 'LBL_DNB_ACT_OPER',
                'header_desc' => 'LBL_DNB_ACT_OPER_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'lastupddate',
                'label' => 'LBL_DNB_LAST_UPD_DATE',
                'desc' => 'LBL_DNB_LAST_UPD_DATE_DESC',
                'header' => 'LBL_DNB_SUBJ_HEADER',
                'header_desc' => 'LBL_DNB_SUBJ_HEADER_DESC',
                'type' => 'bool'
            ),
            array(
                'name' => 'marketind',
                'label' => 'LBL_DNB_MARKET_IND',
                'desc' => 'LBL_DNB_MARKET_IND_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
            array(
                'name' => 'indcodes',
                'label' => 'LBL_DNB_IND_CD',
                'desc' => 'LBL_DNB_IND_CD_DESC',
                'header' => 'LBL_DNB_IND_CD_HED',
                'header_desc' => 'LBL_DNB_IND_CD_HED_DESC',
                'last' => '1',
                'type' => 'bool'
            ),
        ),
    ),
);