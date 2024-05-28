<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

/**
 *
 * HealthCheck Scanner Metadata
 *
 */
class HealthCheckScannerMeta
{
    // Minimum allowed upgrader version
    public const ALLOWED_UPGRADER_VERSION = '7.6.0.0';

    public const FLAG_GREEN = 1;
    public const FLAG_YELLOW = 2;
    public const FLAG_RED = 3;

    // default translation locale
    public const DEFAULT_LOCALE = 'en_us';

    // plain vanilla sugar
    public const VANILLA = 'A';
    // studio mods
    public const STUDIO = 'B';
    // studio and MB mods
    public const STUDIO_MB = 'C';
    // studio and MB mods that need to BWC some modules
    public const STUDIO_MB_BWC = 'D';
    // heavy customization, needs fixes
    public const CUSTOM = 'E';
    // manual customization required
    public const MANUAL = 'F';
    // already on 7
    public const UPGRADED = 'G';
    //unsupported database
    public const UNSUPPORTED_DB = 'H';

    /**
     *
     * Scan Meta Data
     * @var array
     */
    protected $meta = array(

        // BUCKET B
        101 => array(
            'report' => 'hasStudioHistory',
            'bucket' => self::STUDIO,
        ),
        102 => array(
            'report' => 'hasExtensions',
            'bucket' => self::STUDIO,
        ),
        103 => array(
            'report' => 'hasCustomVardefs',
            'bucket' => self::STUDIO,
        ),
        104 => array(
            'report' => 'hasCustomLayoutdefs',
            'bucket' => self::STUDIO,
        ),
        105 => array(
            'report' => 'hasCustomViewdefs',
            'bucket' => self::STUDIO,
        ),

        // BUCKET C
        201 => array(
            'report' => 'notStockModule',
            'bucket' => self::STUDIO_MB,
        ),

        // BUCKET D
        301 => array(
            'report' => 'toBeRunAsBWC',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        302 => array(
            'report' => 'unknownFileViews',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        303 => array(
            'report' => 'nonEmptyFormFile',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        304 => array(
            'report' => 'isNotMBModule',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        308 => array(
            'report' => 'vardefHtmlFunction',
            'bucket' => self::STUDIO_MB_BWC,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function/'
            //@codingStandardsIgnoreEnd
        ),
        309 => array(
            'report' => 'badMd5',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        310 => array(
            'report' => 'unknownFile',
            'bucket' => self::STUDIO_MB_BWC,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Is_Not_MB_Module/'
            //@codingStandardsIgnoreEnd
        ),
        311 => array(
            'report' => 'vardefHtmlFunctionName',
            'bucket' => self::STUDIO_MB_BWC,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function_Module_Field/'
            //@codingStandardsIgnoreEnd
        ),
        312 => array(
            'report' => 'badVardefsName',
            'bucket' => self::STUDIO_MB_BWC
        ),
        313 => array(
            'report' => 'extensionDirDetected',
            'bucket' => self::STUDIO_MB_BWC,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Extension_Dir/',
            //@codingStandardsIgnoreEnd
        ),
        // BUCKET E
        401 => array(
            'report' => 'vendorFilesInclusion',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vendor_Files_Inclusion/',
            //@codingStandardsIgnoreEnd
        ),
        403 => array(
            'report' => 'sugarSpecificFilesInclusion',
            'bucket' => self::CUSTOM,
        ),
        409 => array(
            'report' => 'badVardefsClassAutoloading',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Module_Has_Invalid_Vardefs_For_Field/',
            //@codingStandardsIgnoreEnd
        ),
        520 => array(
            'report' => 'logicHookAfterUIFrame',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Logic_Hook_After_UI_Frame_Detected/',
            //@codingStandardsIgnoreEnd
        ),
        521 => array(
            'report' => 'logicHookAfterUIFooter',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Logic_Hook_After_UI_Footer_Detected/',
            //@codingStandardsIgnoreEnd
        ),
        //Moved incompatIntegration to F bucket. Use this code for new reports
        406 => array(
            'report' => 'hasCustomViews',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Module_Has_Custom_Views/',
            //@codingStandardsIgnoreEnd
        ),
        407 => array(
            'report' => 'hasCustomViewsModDir',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Module_Has_Custom_Views_In_Module_Dir/',
            //@codingStandardsIgnoreEnd
        ),
        408 => array(
            'report' => 'hasCustomCreateActions',
            'bucket' => self::CUSTOM,
        ),
        519 => array(
            'report' => 'extensionDir',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Extension_Dir/',
            //@codingStandardsIgnoreEnd
        ),
        518 => array(
            'report' => 'foundCustomCode',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Custom_Code/',
            //@codingStandardsIgnoreEnd
        ),
        522 => array(
            'report' => 'subPanelWithFunction',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Get_Subpanel_Data_With_Function/'
            //@codingStandardsIgnoreEnd
        ),
        412 => array(
            'report' => 'badSubpanelLink',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Subpanel_Link/',
            //@codingStandardsIgnoreEnd
        ),
        413 => array(
            'report' => 'unknownWidgetClass',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Unknown_Widget_Class_Detected/',
            //@codingStandardsIgnoreEnd
        ),
        415 => array(
            'report' => 'badHookFile',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Hook_File/'
            //@codingStandardsIgnoreEnd
        ),
        417 => array(
            'report' => 'incompatModule',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Module/',
            //@codingStandardsIgnoreEnd
        ),
        418 => array(
            'report' => 'subpanelLinkNonExistModule',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Subpanel_With_Link_To_NonExisting_Module/',
            //@codingStandardsIgnoreEnd
        ),
        419 => array(
            'report' => 'badVardefsKey',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Key/',
            //@codingStandardsIgnoreEnd
        ),
        420 => array(
            'report' => 'badVardefsRelate',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Relate/',
            //@codingStandardsIgnoreEnd
        ),
        421 => array(
            'report' => 'badVardefsLink',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Link/',
            //@codingStandardsIgnoreEnd
        ),
        422 => array(
            'report' => 'foundOtherModuleVardefs',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Module_Has_Definition_Of_Another_Module',
            //@codingStandardsIgnoreEnd
        ),
        525 => array(
            'report' => 'vardefHtmlFunctionCustom',
            'bucket' => self::MANUAL,
        ),
        423 => array(
            'report' => 'badVardefsSubfieldsCustom',
            'bucket' => self::CUSTOM,
        ),
        424 => array(
            'report' => 'inlineHtmlSpacing',
            'bucket' => self::CUSTOM,
        ),
        425 => array(
            'report' => 'foundEcho',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Echo/',
            //@codingStandardsIgnoreEnd
        ),
        426 => array(
            'report' => 'foundPrint',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Print/',
            //@codingStandardsIgnoreEnd
        ),
        427 => array(
            'report' => 'foundDieExit',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_DieExit/',
            //@codingStandardsIgnoreEnd
        ),
        428 => array(
            'report' => 'foundPrintR',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Print_R/',
            //@codingStandardsIgnoreEnd
        ),
        429 => array(
            'report' => 'foundVarDump',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Var_Dump/',
            //@codingStandardsIgnoreEnd
        ),
        431 => array(
            'report' => 'smartyCustomization',
            'bucket' => self::CUSTOM,
        ),
        436 => array(
            'report' => 'smartyCustomPdf',
            'bucket' => self::CUSTOM,
        ),
        437 => array(
            'report' => 'smartyOutdatedCustomization',
            'bucket' => self::MANUAL,
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Smarty_Outdated_Customization/',
        ),
        438 => array(
            'report' => 'smartyOutdatedCustomPdf',
            'bucket' => self::CUSTOM,
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Smarty_Outdated_Custom_PDF/',
        ),
        439 => array(
            'report' => 'smartyUnsupportedSyntax',
            'bucket' => self::CUSTOM,
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Smarty_Unsupported_Syntax/',
        ),
        524 => array(
            'report' => 'vardefHtmlFunctionNameCustom',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function_Custom/',
            //@codingStandardsIgnoreEnd
        ),
        526 => array(
            'report' => 'badVardefsMultienum',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Multienum',
            //@codingStandardsIgnoreEnd
        ),
        527 => array(
            'report' => 'badVardefsTableName',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Table_Name/',
            //@codingStandardsIgnoreEnd
        ),
        433 => array(
            'report' => 'foundCustomElastic',
            'bucket' => self::CUSTOM,
        ),
        434 => array(
            'report' => 'arraySessionUsage',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Usage_of_Array_Functions_on__SESSION_in_Files/index.html',
            //@codingStandardsIgnoreEnd
        ),
        435 => array(
            'report' => 'deprecatedCodeSugarSession',
            'bucket' => self::MANUAL,
        ),
        451 => array(
            'report' => 'deprecatedAuthN',
            'bucket' => self::MANUAL,
        ),
        // 7.8 sidecar and backbone deprecations, E bucket
        550 => array(
            'report' => 'removedSidecarAPI_app_date',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Sidecar_app_date_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        551 => array(
            'report' => 'removedSidecarAPI_Bean_fixable',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Sidecar_Bean_APIs_Migration_Script/',
            //@codingStandardsIgnoreEnd
        ),

        //7.10 removed methods or signatures, F bucket
        547 => array(
            'report' => 'removedSidecarAPI_Context',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Sidecar_Context_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        549 => array(
            'report' => 'useOfMetadataGetFieldOldSignature',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Sidecar_Metadata_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        // Deprecated method, bucket E
        548 => array(
            'report' => 'useOfInitButtons',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Record_View_InitButtons_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        586 => [
            'report' => 'deprecatedFontAwesomeIcons',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Deprecated_use_of_FontAwesome_detected/',
            //@codingStandardsIgnoreEnd
        ],
        587 => [
            'report' => 'deprecatedLESSColorVariables',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Deprecated_LESS_Colour_Variables/',
            //@codingStandardsIgnoreEnd
        ],

        // BUCKET F
        501 => array(
            'report' => 'missingFile',
            'bucket' => self::MANUAL,
        ),
        502 => array(
            'report' => 'md5Mismatch',
            'bucket' => self::MANUAL,
        ),
        503 => array(
            'report' => 'sameModuleName',
            'bucket' => self::CUSTOM,
        ),
        504 => array(
            'report' => 'fieldTypeMissing',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Field_Type_Missing/'
            //@codingStandardsIgnoreEnd
        ),
        505 => array(
            'report' => 'typeChange',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Type_Change/',
            //@codingStandardsIgnoreEnd
        ),
        506 => array(
            'report' => 'thisUsage',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_$This_Usage/',
            //@codingStandardsIgnoreEnd
        ),
        507 => array(
            'report' => 'badVardefsSubfields',
            'bucket' => self::MANUAL,
        ),
        508 => array(
            'report' => 'inlineHtml',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Inline_HTML_Found/',
            //@codingStandardsIgnoreEnd
        ),
        529 => array(
            'report' => 'phpError',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_PHP_Error_in_File/'
            //@codingStandardsIgnoreEnd
        ),
        530 => array(
            'report' => 'missingCustomFile',
            'bucket' => self::MANUAL,
        ),
        534 => array(
            'report' => 'unsupportedDbDriver',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Unsupported_DB_Driver/',
            //@codingStandardsIgnoreEnd
        ),
        535 => array(
            'report' => 'unsupportedMethodCall',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Unsupported_Method_Call/',
            //@codingStandardsIgnoreEnd
        ),
        536 => array(
            'report' => 'unsupportedPropertyAccess',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Unsupported_Property_Access/',
            //@codingStandardsIgnoreEnd
        ),
        //Moved foundEcho,foundPrint,foundDieExit,foundPrintR,foundVarDump to E bucket. Use this code for new reports
        515 => array(
            'report' => 'scriptFailure',
            'bucket' => self::MANUAL,
        ),
        516 => array(
            'report' => 'deletedFilesReferenced',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Deleted_Files_Referenced/',
            //@codingStandardsIgnoreEnd
        ),
        517 => array(
            'report' => 'incompatIntegration',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Integration/',
            //@codingStandardsIgnoreEnd
        ),
        528 => array(
            'report' => 'vardefIncorrectDisplayDefault',
            'bucket' => self::MANUAL,
        ),
        540 => array(
            'report' => 'incompatIntegrationDataReset',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb'     => 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Integration_Data_Reset/',
            //@codingStandardsIgnoreEnd
        ),
        545 => array(
            'report' => 'invalidAWFLockedFieldGroup',
            'bucket' => self::MANUAL,
            //'kb'     => '',
        ),
        546 => array(
            'report' => 'customTinyMCEConfig',
            'bucket' => self::CUSTOM,
        ),
        // 7.8 sidecar and backbone deprecations, F bucket
        552 => array(
            'report' => 'useOfUnderscoreBindAll',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Underscore_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        553 => array(
            'report' => 'removedSidecarAPI_Bean',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Removed_Sidecar_Bean_APIs/',
            //@codingStandardsIgnoreEnd
        ),
        554 => array(
            'report' => 'extendsFromRemovedSidecarClass',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Sidecar_Controller_Extends_from_Removed_Sidecar/',
            //@codingStandardsIgnoreEnd
        ),
        562 => array(
            'report' => 'useOfAppViewInvokeParent',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'http://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_Of_App_View_InvokeParent/',
            //@codingStandardsIgnoreEnd
        ),
        563 => [
            'report' => 'incompatibleMonologCustomization',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Monolog_Customization/',
            //@codingStandardsIgnoreEnd
        ],
        564 => [
            'report' => 'outdatedDbalUsage',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Outdated_DBAL_Functionality/',
            //@codingStandardsIgnoreEnd
        ],
        565 => [
            'report' => 'deprecatedConfigParameterPasswordHash',
            'bucket' => self::CUSTOM,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Deprecated_Config_Parameter_Password_Hash/',
            //@codingStandardsIgnoreEnd
        ],
        566 => [
            'report' => 'unsupportedConfigParameterPasswordHash',
            'bucket' => self::MANUAL,
            //@codingStandardsIgnoreStart
            'kb' => 'https://support.sugarcrm.com/Knowledge_Base/Installation_Upgrade/Troubleshooting_Health_Check_Output/Health_Check_Error_Use_of_Unsupported_Config_Parameter_Password_Hash/',
            //@codingStandardsIgnoreEnd
        ],
        // Bucket G
        901 => array(
            'report' => 'alreadyUpgraded',
            'bucket' => self::UPGRADED,
        ),

        903 => array (
            'report' => 'unsupportedUpgrader',
            'bucket' => self::MANUAL,
        ),

        // Catch all meta
        999 => array(
            'report' => 'unknownFailure',
            'bucket' => self::MANUAL,
        ),
    );

    protected $flagLabelMap = array(
        self::FLAG_RED => 'red',
        self::FLAG_YELLOW => 'yellow',
        self::FLAG_GREEN => 'green'
    );

    protected $metaByReportId = array();

    /**
     *
     * Default flag --> bucket mapping
     * @var array
     */
    protected $defaultFlagMap = array(
        self::VANILLA => self::FLAG_GREEN,
        self::STUDIO => self::FLAG_GREEN,
        self::STUDIO_MB => self::FLAG_GREEN,
        self::STUDIO_MB_BWC => self::FLAG_YELLOW,
        self::CUSTOM => self::FLAG_YELLOW,
        self::MANUAL => self::FLAG_RED,
        self::UPGRADED => self::FLAG_GREEN,
        self::UNSUPPORTED_DB => self::FLAG_RED,
    );

    /**
     * Default link for "Learn more..."
     *
     * @var string
     */
    //@codingStandardsIgnoreStart
    protected $defaultKbUrl = 'http://support.sugarcrm.com/Knowledge_Base/Administration/Install/Troubleshooting_Health_Check_Output/';
    //@codingStandardsIgnoreEnd

    /**
     *
     * @var array $mod_strings
     */
    protected $modStrings;

    /**
     *
     * @var HealthCheckScannerMeta
     */
    protected static $instance;

    /**
     * @var string
     */
    protected $locale = self::DEFAULT_LOCALE;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setupLocale();
        $this->loadModStrings();
        $this->createMetaByReportId();
    }

    /**
     * Returns HealthCheckScannerMeta instance
     *
     * @return HealthCheckScannerMeta
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * remaps $meta array to $meta['report'] => $meta['id']
     */
    protected function createMetaByReportId()
    {
        foreach ($this->meta as $id => $meta) {
            if (isset($meta['report'])) {
                $reportId = $meta['report'];
                if (isset($this->metaByReportId[$reportId])) {
                    throw new RuntimeException("Non-unique report id {$reportId}");
                }
                $this->metaByReportId[$reportId] = $id;
            }
        }
    }

    /**
     *
     * @param string $id Scan id
     * @return array|boolean
     */
    public function getMeta($id, $params = array())
    {
        if (!isset($this->meta[$id])) {
            return false;
        }

        $meta = $this->meta[$id];

        // add scan id
        $meta['id'] = $id;

        $strings = array();
        foreach ($params as $key => $item) {
            if (is_array($item)) {
                $item =  implode("\r\n", $item);
            }
            $strings[$key] = $item;
        }

        // add labels from modStrings
        $meta['log'] = $this->getModString("LBL_SCAN_{$id}_LOG", $strings);
        $meta['title'] = $this->getModString("LBL_SCAN_{$id}_TITLE", $strings);
        $meta['descr'] = $this->getModString("LBL_SCAN_{$id}_DESCR", $strings);

        if(strpos($meta['title'], 'LBL_') === 0) {
            $meta['title'] = $meta['report'];
        }
        if(strpos($meta['descr'], 'LBL_') === 0) {
            $meta['descr'] = $meta['log'];
        }

        // set defaults
        if (!isset($meta['flag'])) {
            $meta['flag'] = $this->getDefaultFlag($meta['bucket']);
        }
        $meta['flag_label'] = $this->getFlagLabel($meta['flag']);
        if (!isset($meta['kb'])) {
            $meta['kb'] = $this->defaultKbUrl;
        }
        if (!isset($meta['tickets'])) {
            $meta['tickets'] = array();
        }
        if (!isset($meta['scripts'])) {
            $meta['scripts'] = array();
        }

        $meta['params'] = $params;

        return $meta;
    }

    /**
     * Returns flag's label
     *
     * @param $flag
     * @return string
     */
    protected function getFlagLabel($flag) {
        if(isset($this->flagLabelMap[$flag])) {
            return $this->flagLabelMap[$flag];
        }
        return $flag;
    }

    /**
     *
     * Return default flag for given bucket
     *
     * @param string $bucket Bucket
     * @return integer
     */
    public function getDefaultFlag($bucket)
    {
        return $this->defaultFlagMap[$bucket];
    }

    /**
     * Returns meta by report id
     *
     * @param string $reportId
     * @param array $params
     * @return array|boolean
     */
    public function getMetaFromReportId($reportId, $params = array())
    {
        if (isset($this->metaByReportId[$reportId])) {
            return $this->getMeta($this->metaByReportId[$reportId], $params);
        }
        return false;
    }

    /**
     * Translates $label
     *
     * @param string $label
     * @param array $params
     * @return string
     */
    public function getModString($label, $params = array())
    {
        if (!empty($this->modStrings[$label])) {
            $label = vsprintf($this->modStrings[$label], $params);
        }
        return $label;
    }

    /**
     *
     */
    protected function loadModStrings()
    {
        //From 7.6.1 and onwards HealthCheck language files are always bundled with HC.
        $mod_strings = array();
        include __DIR__ . '/../language/' . self::DEFAULT_LOCALE . '.lang.php';
        $this->modStrings = $mod_strings;
    }

    protected function setupLocale()
    {
        if(isset($GLOBALS['current_language'])) {
            $this->locale = $GLOBALS['current_language'];
        } else {
            $lang = explode('.', getenv("LANG"));
            if($lang) {
                $this->locale = $lang[0];
            }
        }

    }
}
