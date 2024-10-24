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

require_once 'modules/ModuleBuilder/parsers/constants.php';

class PopupMetaDataParser extends ListLayoutMetaDataParser
{
    /**
     * @var bool|mixed
     */
    public $search;
    //@codingStandardsIgnoreStart
    public $_packageName;
    public $_view;
    //@codingStandardsIgnoreEnd

    // Columns is used by the view to construct the listview - each column is built by calling the named function
    public $columns = ['LBL_DEFAULT' => 'getDefaultFields', 'LBL_AVAILABLE' => 'getAdditionalFields', 'LBL_HIDDEN' => 'getAvailableFields'];

    public static $reserveProperties = ['moduleMain', 'varName', 'orderBy', 'whereClauses', 'searchInputs', 'create', 'addToReserve'];

    public static $defsMap = [MB_POPUPSEARCH => 'searchdefs', MB_POPUPLIST => 'listviewdefs'];

    /*
     * Constructor
     * Must set:
     * $this->columns   Array of 'Column LBL'=>function_to_retrieve_fields_for_this_column() - expected by the view
     *
     * @param string moduleName     The name of the module to which this listview belongs
     * @param string packageName    If not empty, the name of the package to which this listview belongs
     */
    public function __construct($view, $moduleName, $packageName = '')
    {
        $this->search = ($view == MB_POPUPSEARCH) ? true : false;
        $this->_moduleName = $moduleName;
        $this->_packageName = $packageName;
        $this->_view = $view;
        $this->columns = ['LBL_DEFAULT' => 'getDefaultFields', 'LBL_HIDDEN' => 'getAvailableFields'];

        if ($this->search) {
            $this->columns = ['LBL_DEFAULT' => 'getSearchFields', 'LBL_HIDDEN' => 'getAvailableFields'];
            parent::__construct(MB_POPUPSEARCH, $moduleName, $packageName);
        } else {
            parent::__construct(MB_POPUPLIST, $moduleName, $packageName);
        }

        $this->_viewdefs = $this->mergeFieldDefinitions($this->_viewdefs, $this->_fielddefs);
    }

    /**
     * Dashlets contain both a searchview and list view definition, therefore we need to merge only the relevant info
     */
    public function mergeFieldDefinitions($viewdefs, $fielddefs)
    {
        $viewdefs = $this->_viewdefs = array_change_key_case($viewdefs);
        $viewdefs = $this->_viewdefs = $this->convertSearchToListDefs($viewdefs);
        return $viewdefs;
    }

    public function convertSearchToListDefs($defs)
    {
        $temp = [];
        foreach ($defs as $key => $value) {
            if (!is_array($value)) {
                $temp[$value] = ['name' => $value];
            } else {
                $temp[$key] = $value;
                if (isset($value['name']) && $value['name'] != $key) {
                    $temp[$value['name']] = $value;
                    unset($temp[$key]);
                } elseif (!isset($value['name'])) {
                    $temp[$key]['name'] = $key;
                }
            }
        }
        return $temp;
    }

    public function getOriginalViewDefs()
    {
        $defs = parent::getOriginalViewDefs();
        return $this->convertSearchToListDefs($defs);
    }

    public function getSearchFields()
    {
        $searchFields = [];
        foreach ($this->_viewdefs as $key => $def) {
            if (isset($this->_fielddefs [$key])) {
                $searchFields [$key] = self::_trimFieldDefs($this->_fielddefs [$key]);
                if (!empty($def['label'])) {
                    $searchFields [$key]['label'] = $def['label'];
                }
            } else {
                $searchFields [$key] = $def;
            }
        }

        return $searchFields;
    }

    /**
     * @inheritDoc
     */
    public function handleSave($populate = true, $clearCache = true)
    {
        if (empty($this->_packageName)) {
            foreach ([MB_CUSTOMMETADATALOCATION, MB_BASEMETADATALOCATION] as $value) {
                $file = $this->implementation->getFileName(MB_POPUPLIST, $this->_moduleName, $value);
                if (file_exists($file)) {
                    break;
                }
            }
            $writeFile = $this->implementation->getFileName(MB_POPUPLIST, $this->_moduleName);
            if (!file_exists($writeFile)) {
                mkdir_recursive(dirname($writeFile));
            }
        } else {
            $writeFile = $file = $this->implementation->getFileName(MB_POPUPLIST, $this->_moduleName, $this->_packageName);
        }
        $this->implementation->_history->append($file);
        if ($populate) {
            $this->_populateFromRequest();
        }
        $out = "<?php\n";

        //Load current module languages
        global $mod_strings, $current_language;
        $oldModStrings = $mod_strings;
        $GLOBALS['mod_strings'] = return_module_language($current_language, $this->_moduleName);
        require $file;
        if (!isset($popupMeta)) {
            sugar_die('unable to load Module Popup Definition');
        }

        if ($this->_view == MB_POPUPSEARCH) {
            foreach ($this->_viewdefs as $k => $v) {
                if (isset($this->_viewdefs[$k]) && isset($this->_viewdefs[$k]['default'])) {
                    unset($this->_viewdefs[$k]['default']);
                }
            }
            $this->_viewdefs = $this->convertSearchToListDefs($this->_viewdefs);
            $popupMeta['searchdefs'] = $this->_viewdefs;
            $this->addNewSearchDef($this->_viewdefs, $popupMeta);
        } else {
            $popupMeta['listviewdefs'] = array_change_key_case($this->_viewdefs, CASE_UPPER);
        }

        //provide a way for users to add to the reserve properties list via the 'addToReserve' element
        $totalReserveProps = self::$reserveProperties;
        if (!empty($popupMeta['addToReserve'])) {
            $totalReserveProps = array_merge(self::$reserveProperties, $popupMeta['addToReserve']);
        }
        $allProperties = array_merge($totalReserveProps, ['searchdefs', 'listviewdefs']);

        $out .= "\$popupMeta = array (\n";
        foreach ($allProperties as $p) {
            if (isset($popupMeta[$p])) {
                $out .= "    '$p' => " . var_export_helper($popupMeta[$p]) . ",\n";
            }
        }
        $out .= ");\n";
        file_put_contents($writeFile, $out);
        //return back mod strings
        $GLOBALS['mod_strings'] = $oldModStrings;
    }

    public function addNewSearchDef($searchDefs, &$popupMeta)
    {
        if (!empty($searchDefs)) {
            $this->__diffAndUpdate($searchDefs, $popupMeta['whereClauses'], true);
            $this->__diffAndUpdate($searchDefs, $popupMeta['searchInputs']);
        }
    }

    private function __diffAndUpdate($newDefs, &$targetDefs, $forWhere = false)
    {
        if (!is_array($targetDefs)) {
            $targetDefs = [];
        }
        foreach ($newDefs as $key => $def) {
            if (!isset($targetDefs[$key]) && $forWhere) {
                $targetDefs[$key] = $this->__getTargetModuleName($def) . '.' . $key;
            } elseif (!in_array($key, $targetDefs) && !$forWhere) {
                array_push($targetDefs, $key);
            }
        }

        if ($forWhere) {
            foreach (array_diff(array_keys($targetDefs), array_keys($newDefs)) as $key) {
                unset($targetDefs[$key]);
            }
        } else {
            foreach ($targetDefs as $key => $value) {
                if (!isset($newDefs[$value])) {
                    unset($targetDefs[$key]);
                }
            }
        }
    }

    private function __getTargetModuleName($def)
    {
        $dir = strtolower($this->implementation->getModuleDir());
        if (isset($this->_fielddefs[$def['name']]) && isset($this->_fielddefs[$def['name']]['source']) && $this->_fielddefs[$def['name']]['source'] == 'custom_fields') {
            return $dir . '_cstm';
        }

        return $dir;
    }

    /**
     * Helper method to determine whether a field is allowed on a list view on
     * populateFromRequest.
     *
     * @param string $field The name of the field to check
     * @return boolean
     */
    protected function isAllowedField($field)
    {
        // Popup list view needs to validate fields even on populate from request.
        return $this->isValidField($field, $this->_fielddefs[$field]);
    }
}
