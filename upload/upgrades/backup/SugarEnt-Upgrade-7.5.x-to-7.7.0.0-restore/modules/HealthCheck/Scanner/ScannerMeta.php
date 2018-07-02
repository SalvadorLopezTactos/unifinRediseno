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

/**
 *
 * HealthCheck Scanner Metadata
 *
 */
class HealthCheckScannerMeta
{
    const FLAG_GREEN = 1;
    const FLAG_YELLOW = 2;
    const FLAG_RED = 3;

    // default translation locale
    const DEFAULT_LOCALE = 'en_us';

    // plain vanilla sugar
    const VANILLA = 'A';
    // studio mods
    const STUDIO = 'B';
    // studio and MB mods
    const STUDIO_MB = 'C';
    // studio and MB mods that need to BWC some modules
    const STUDIO_MB_BWC = 'D';
    // heavy customization, needs fixes
    const CUSTOM = 'E';
    // manual customization required
    const MANUAL = 'F';
    // already on 7
    const UPGRADED = 'G';

    /**
     *
     * Scan Meta Data
     * @var array
     */
    protected $meta = array(

        // skeleton
        // '100' => array(
        //    'report' => '', // report id
        //    'bucket' => self::STUDIO_MB,
        //    'flag' => self::FLAG_YELLOW, // optional, default will be added
        //    'kb' => false, // optional, default will be added
        //    'tickets' => array(), // optional, default will be added
        //    'scripts' => array(), // optional, default will be added
        //),

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
//        305 => array(
//            'report' => 'badVardefsKey',
//            'bucket' => self::STUDIO_MB_BWC,
//        ),
//        306 => array(
//            'report' => 'badVardefsRelate',
//            'bucket' => self::STUDIO_MB_BWC,
//        ),
//        307 => array(
//            'report' => 'badVardefsLink',
//            'bucket' => self::STUDIO_MB_BWC,
//        ),
        308 => array(
            'report' => 'vardefHtmlFunction',
            'bucket' => self::STUDIO_MB_BWC,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function/'
        ),
        309 => array(
            'report' => 'badMd5',
            'bucket' => self::STUDIO_MB_BWC,
        ),
        310 => array(
            'report' => 'unknownFile',
            'bucket' => self::STUDIO_MB_BWC,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Is_Not_MB_Module/'
        ),
        311 => array(
            'report' => 'vardefHtmlFunctionName',
            'bucket' => self::STUDIO_MB_BWC,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function_Module_Field/'
        ),
        312 => array(
            'report' => 'badVardefsName',
            'bucket' => self::STUDIO_MB_BWC
        ),
        313 => array(
            'report' => 'extensionDirDetected',
            'bucket' => self::STUDIO_MB_BWC,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Extension_Dir/',
        ),
//        314 => array(
//            'report' => 'badVardefsMultienum',
//            'bucket' => self::STUDIO_MB_BWC
//        ),

        // BUCKET E
        401 => array(
            'report' => 'vendorFilesInclusion',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vendor_Files_Inclusion/',
        ),
//        402 => array(
//            'report' => 'badModule',
//            'bucket' => self::CUSTOM,
//        ),
        403 => array(
            'report' => 'sugarSpecificFilesInclusion',
            'bucket' => self::CUSTOM,
        ),
        520 => array(
            'report' => 'logicHookAfterUIFrame',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Logic_Hook_After_UI_Frame_Detected/',
        ),
        521 => array(
            'report' => 'logicHookAfterUIFooter',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Logic_Hook_After_UI_Footer_Detected/',
        ),
        //Moved incompatIntegration to F bucket. Use this code for new reports
//        405 => array(
//            'report' => 'incompatIntegration',
//            'bucket' => self::CUSTOM,
//        ),
        406 => array(
            'report' => 'hasCustomViews',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Module_Has_Custom_Views/',
        ),
        407 => array(
            'report' => 'hasCustomViewsModDir',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Module_Has_Custom_Views_In_Module_Dir/',
        ),
        519 => array(
            'report' => 'extensionDir',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Extension_Dir/',
        ),
        518 => array(
            'report' => 'foundCustomCode',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Custom_Code/',
        ),
//        410 => array(
//           'report' => 'maxFieldsView',
//            'bucket' => self::CUSTOM,
//        ),
        522 => array(
            'report' => 'subPanelWithFunction',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Get_Subpanel_Data_With_Function/'
        ),
        412 => array(
            'report' => 'badSubpanelLink',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Subpanel_Link/',
        ),
        413 => array(
            'report' => 'unknownWidgetClass',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Unknown_Widget_Class_Detected/',
        ),
//        414 => array(
//            'report' => 'unknownField',
//            'bucket' => self::CUSTOM,
//        ),
        415 => array(
            'report' => 'badHookFile',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Hook_File/'
        ),
//         523 => array(
//             'report' => 'byRefInHookFile',
//             'bucket' => self::MANUAL,
//         ),
        417 => array(
            'report' => 'incompatModule',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Module/',
        ),
        418 => array(
            'report' => 'subpanelLinkNonExistModule',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Subpanel_With_Link_To_NonExisting_Module/',
        ),
        419 => array(
            'report' => 'badVardefsKey',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Key/',
        ),
        420 => array(
            'report' => 'badVardefsRelate',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Relate/',
        ),
        421 => array(
            'report' => 'badVardefsLink',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Link/',
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
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Echo/',
        ),
        426 => array(
            'report' => 'foundPrint',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Print/',
        ),
        427 => array(
            'report' => 'foundDieExit',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_DieExit/',
        ),
        428 => array(
            'report' => 'foundPrintR',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Print_R/',
        ),
        429 => array(
            'report' => 'foundVarDump',
            'bucket' => self::CUSTOM,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Found_Var_Dump/',
        ),
//        430 => array(
//            'report' => 'foundOutputBufferingCustom',
//            'bucket' => self::CUSTOM,
//        ),
        524 => array(
            'report' => 'vardefHtmlFunctionNameCustom',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Vardef_HTML_Function_Custom/',
        ),
//        432 => array(
//            'report' => 'badVardefsName',
//            'bucket' => self::CUSTOM
//        ),
        526 => array(
            'report' => 'badVardefsMultienum',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Multienum',
        ),
        527 => array(
            'report' => 'badVardefsTableName',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Bad_Vardefs_Table_Name/',
        ),

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
            'bucket' => self::MANUAL,
        ),
        504 => array(
            'report' => 'fieldTypeMissing',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Field_Type_Missing/'
        ),
        505 => array(
            'report' => 'typeChange',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Type_Change/',
        ),
        506 => array(
            'report' => 'thisUsage',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_$This_Usage/',
        ),
        507 => array(
            'report' => 'badVardefsSubfields',
            'bucket' => self::MANUAL,
        ),
        508 => array(
            'report' => 'inlineHtml',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Inline_HTML_Found/',
        ),
        529 => array(
            'report' => 'phpError',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_PHP_Error_in_File/'
        ),
        530 => array(
            'report' => 'missingCustomFile',
            'bucket' => self::MANUAL,
        ),

        //Moved foundEcho,foundPrint,foundDieExit,foundPrintR,foundVarDump to E bucket. Use this code for new reports
//        509 => array(
//            'report' => 'foundEcho',
//            'bucket' => self::MANUAL,
//        ),
//        510 => array(
//            'report' => 'foundPrint',
//            'bucket' => self::MANUAL,
//        ),
//        511 => array(
//            'report' => 'foundDieExit',
//            'bucket' => self::MANUAL,
//        ),
//        512 => array(
//            'report' => 'foundPrintR',
//            'bucket' => self::MANUAL,
//        ),
//        513 => array(
//            'report' => 'foundVarDump',
//            'bucket' => self::MANUAL,
//        ),
//        514 => array(
//            'report' => 'foundOutputBuffering',
//            'bucket' => self::MANUAL,
//        ),
        515 => array(
            'report' => 'scriptFailure',
            'bucket' => self::MANUAL,
        ),
        516 => array(
            'report' => 'deletedFilesReferenced',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Deleted_Files_Referenced/',
        ),
        517 => array(
            'report' => 'incompatIntegration',
            'bucket' => self::MANUAL,
            'kb'     => 'http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Troubleshooting_Health_Check_Output/Health_Check_Error_Incompatible_Integration/',
        ),
        528 => array(
            'report' => 'vardefIncorrectDisplayDefault',
            'bucket' => self::MANUAL,
        ),


        // Bucket G
        901 => array(
            'report' => 'alreadyUpgraded',
            'bucket' => self::UPGRADED,
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
    );

    /**
     * Default link for "Learn more..."
     *
     * @var string
     */
    protected $defaultKbUrl = 'http://support.sugarcrm.com/04_Find_Answers/02KB/02Administration/100Install/Troubleshooting_Health_Check_Output/';

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

        $strings = array_map(
            function ($item) {
                if (is_array($item)) {
                    return implode("\r\n", $item);
                }
                return $item;
            },
            $params
        );

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
    protected function getModString($label, $params = array())
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
        if (is_callable('return_module_language')) {
            $this->modStrings = return_module_language($this->locale, 'HealthCheck');
        } else {
            $mod_strings = array();
            include __DIR__ . '/../language/' . self::DEFAULT_LOCALE . '.lang.php';
            $this->modStrings = $mod_strings;
        }
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
