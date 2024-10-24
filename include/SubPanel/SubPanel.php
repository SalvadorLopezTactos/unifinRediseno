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
require_once 'include/SubPanel/registered_layout_defs.php';

/**
 * Subpanel
 * @api
 */
class SubPanel
{
    public $bean_list;
    /**
     * @var mixed|\ListView
     */
    public $listview;
    public $hideNewButton = false;
    public $subpanel_id;
    public $parent_record_id;
    public $parent_module;  // the name of the parent module
    public $parent_bean;  // the instantiated bean of the parent
    public $template_file;
    public $linked_fields;
    public $action = 'DetailView';
    public $show_select_button = true;
    public $subpanel_define = null;  // contains the layout_def.php
    public $subpanel_defs;
    public $subpanel_query = null;
    public $layout_def_key = '';

    public function __construct($module, $record_id, $subpanel_id, $subpanelDef, $layout_def_key = '')
    {
        global $theme, $focus, $app_strings;

        $this->subpanel_defs = $subpanelDef;
        $this->subpanel_id = $subpanel_id;
        $this->parent_record_id = $record_id;
        $this->parent_module = $module;
        $this->layout_def_key = $layout_def_key;

        $result = $this->parent_bean = $focus;
        if (empty($result)) {
            $result = $this->parent_bean = BeanFactory::getBean($module, $this->parent_record_id);
        }

        if ($record_id != 'fab4' && $result == null) {
            sugar_die($app_strings['ERROR_NO_RECORD']);
        }

        if (empty($subpanelDef)) {
            //load the subpanel by name.
            if (!class_exists('MyClass')) {
            }
            $panelsdef = new SubPanelDefinitions($result, $layout_def_key);
            $subpanelDef = $panelsdef->load_subpanel($subpanel_id);
            $this->subpanel_defs = $subpanelDef;
        }
    }

    public function setTemplateFile($template_file)
    {
        $this->template_file = $template_file;
    }

    public function setBeanList(&$value)
    {
        $this->bean_list = $value;
    }

    public function setHideNewButton($value)
    {
        $this->hideNewButton = $value;
    }


    public function getHeaderText($currentModule)
    {
    }

    public function get_buttons($panel_query = null)
    {

        $thisPanel =& $this->subpanel_defs;
        $subpanel_def = $thisPanel->get_buttons();

        if (!isset($this->listview)) {
            $this->listview = new ListView();
        }
        $layout_manager = $this->listview->getLayoutManager();
        $widget_contents = '<div><table cellpadding="0" cellspacing="0"><tr>';
        foreach ($subpanel_def as $widget_data) {
            $widget_data['action'] = $_REQUEST['action'];
            $widget_data['module'] = $thisPanel->get_inst_prop_value('module');
            $widget_data['focus'] = $this->parent_bean;
            $widget_data['subpanel_definition'] = $thisPanel;
            $widget_contents .= '<td style="padding-right: 2px; padding-bottom: 2px;">' . "\n";

            if (empty($widget_data['widget_class'])) {
                $widget_contents .= 'widget_class not defined for top subpanel buttons';
            } else {
                $widget_contents .= $layout_manager->widgetDisplay($widget_data);
            }

            $widget_contents .= '</td>';
        }

        $widget_contents .= '</tr></table></div>';
        return $widget_contents;
    }


    public function ProcessSubPanelListView($xTemplatePath, &$mod_strings)
    {
        global $app_strings;
        global $current_user;
        global $sugar_config;

        if (isset($this->listview)) {
            $ListView =& $this->listview;
        } else {
            $ListView = new ListView();
        }
        $ListView->initNewXTemplate($xTemplatePath, $this->subpanel_defs->mod_strings);
        $ListView->xTemplateAssign('RETURN_URL', '&return_module=' . $this->parent_module . '&return_action=DetailView&return_id=' . $this->parent_bean->id);
        $ListView->xTemplateAssign('RELATED_MODULE', $this->parent_module);  // TODO: what about unions?
        $ListView->xTemplateAssign('RECORD_ID', $this->parent_bean->id);
        $ListView->xTemplateAssign('EDIT_INLINE_PNG', SugarThemeRegistry::current()->getImage('edit_inline', 'align="absmiddle"  border="0"', null, null, '.gif', $app_strings['LNK_EDIT']));
        $ListView->xTemplateAssign('DELETE_INLINE_PNG', SugarThemeRegistry::current()->getImage('delete_inline', 'align="absmiddle" border="0"', null, null, '.gif', $app_strings['LBL_DELETE_INLINE']));
        $ListView->xTemplateAssign('REMOVE_INLINE_PNG', SugarThemeRegistry::current()->getImage('delete_inline', 'align="absmiddle" border="0"', null, null, '.gif', $app_strings['LBL_ID_FF_REMOVE']));
        $header_text = '';

        $ListView->setHeaderTitle('');
        $ListView->setHeaderText('');

        ob_start();

        $ListView->is_dynamic = true;
        $ListView->records_per_page = $sugar_config['list_max_entries_per_subpanel'] + 0;
        $ListView->start_link_wrapper = "javascript:showSubPanel('" . $this->subpanel_id . "','";
        $ListView->subpanel_id = $this->subpanel_id;
        $ListView->end_link_wrapper = "',true);";
        if (!empty($this->layout_def_key)) {
            $ListView->end_link_wrapper = '&layout_def_key=' . $this->layout_def_key . $ListView->end_link_wrapper;
        }

        $where = '';
        $ListView->setQuery($where, '', '', '');
        $ListView->show_export_button = false;

        //function returns the query that was used to populate sub-panel data.

        $query = $ListView->process_dynamic_listview($this->parent_module, $this->parent_bean, $this->subpanel_defs);
        $this->subpanel_query = $query;
        $ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
    }

    public function display()
    {
        global $timedate;
        global $mod_strings;
        global $app_strings;
        global $app_list_strings;
        global $beanList;
        global $beanFiles;
        global $current_language;

        $result_array = [];

        $return_string = $this->ProcessSubPanelListView($this->template_file, $result_array);

        print $return_string;
    }

    public function getModulesWithSubpanels()
    {
        $modules = [];
        foreach (SugarAutoLoader::getDirFiles('modules', true) as $dir) {
            if (file_exists("$dir/layout_defs.php")) {
                $entry = basename($dir);
                $modules[$entry] = $entry;
            }
        }
        return $modules;
    }

    public static function getModuleSubpanels($module)
    {
        $mod = BeanFactory::newBean($module);
        if (empty($mod)) {
            return [];
        }

        $spd = new SubPanelDefinitions($mod);
        $tabs = $spd->get_available_tabs(true);
        $ret_tabs = [];
        $reject_tabs = ['history' => 1, 'activities' => 1];
        foreach ($tabs as $key => $tab) {
            foreach ($tab as $k => $v) {
                if (!isset($reject_tabs [$k])) {
                    $ret_tabs [$k] = $v;
                }
            }
        }

        return $ret_tabs;
    }

    /**
     * This method saves a subpanels override defintion
     *
     * @param object $panel the subpanel
     * @param var $subsection
     * @param string $override the override string
     */
    public function saveSubPanelDefOverride($panel, $subsection, $override)
    {
        $layoutPath = "custom/Extension/modules/{$panel->parent_bean->module_dir}/Ext/Layoutdefs/";
        $layoutDefsName = "layout_defs['{$panel->parent_bean->module_dir}']['subpanel_setup']['"
            . strtolower($panel->name) . "']";
        $layoutDefsExtName = 'layoutdefs';
        $moduleInstallerMethod = 'rebuild_layoutdefs';
        //bug 42262 (filename with $panel->_instance_properties['get_subpanel_data'] can create problem if had word "function" in it)
        $overrideValue = $filename = $panel->parent_bean->object_name . '_subpanel_' . $panel->name;
        $overrideName = 'override_subpanel_name';

        //save the new subpanel
        $name = "subpanel_layout['list_fields']";

        //bugfix: load looks for moduleName/metadata/subpanels, not moduleName/subpanels
        $path = 'custom/modules/' . $panel->_instance_properties['module'] . '/metadata/subpanels';

        //bug# 40171: "Custom subpanels not working as expected"
        //each custom subpanel needs to have a unique custom def file
        $oldName1 = '_override' . $panel->parent_bean->object_name . $panel->_instance_properties['module'] . $panel->_instance_properties['subpanel_name'];
        $oldName2 = '_override' . $panel->parent_bean->object_name . $panel->_instance_properties['get_subpanel_data'];
        if (file_exists("{$layoutPath}/$oldName1.php")) {
            @unlink("{$layoutPath}/$oldName1.php");
        }
        if (file_exists("{$layoutPath}/$oldName2.php")) {
            @unlink("{$layoutPath}/$oldName2.php");
        }
        $extname = '_override' . $filename;
        //end of bug# 40171

        mkdir_recursive($path, true);
        write_array_to_file($name, $override, $path . '/' . $filename . '.php');

        //save the override for the layoutdef
        //tyoung 10.12.07 pushed panel->name to lowercase to match case in subpaneldefs.php files -
        //gave error on bad index 'module' as this override key didn't match the key in the subpaneldefs

        $newValue = override_value_to_string($layoutDefsName, $overrideName, $overrideValue);
        mkdir_recursive($layoutPath, true);

        $fp = sugar_fopen("{$layoutPath}/{$extname}.php", 'w');
        fwrite($fp, "<?php\n//auto-generated file DO NOT EDIT\n$newValue\n?>");
        fclose($fp);
        SugarAutoLoader::requireWithCustom('ModuleInstall/ModuleInstaller.php');
        $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
        $moduleInstaller = new $moduleInstallerClass();
        $moduleInstaller->silent = true; // make sure that the ModuleInstaller->log() function doesn't echo while rebuilding the layoutdefs
        $moduleInstaller->$moduleInstallerMethod();
        SugarAutoLoader::buildCache();
        foreach (SugarAutoLoader::existing(
            'modules/' . $panel->parent_bean->module_dir . '/layout_defs.php',
            SugarAutoLoader::loadExtension($layoutDefsExtName, $panel->parent_bean->module_dir)
        ) as $file) {
            include $file;
        }
    }

    public function get_subpanel_setup($module)
    {
        $subpanel_setup = '';
        $layout_defs = get_layout_defs();

        if (!empty($layout_defs) && !empty($layout_defs[$module]['subpanel_setup'])) {
            $subpanel_setup = $layout_defs[$module]['subpanel_setup'];
        }

        return $subpanel_setup;
    }

    /**
     * Retrieve the subpanel definition from the registered layout_defs arrays.
     */
    public function getSubPanelDefine($module, $subpanel_id)
    {
        $default_subpanel_define = self::getDefaultSubpanelDefine($module, $subpanel_id);
        $custom_subpanel_define = self::getCustomSubpanelDefine($module, $subpanel_id);

        $subpanel_define = array_merge($default_subpanel_define, $custom_subpanel_define);

        if (empty($subpanel_define)) {
            print('Could not load subpanel definition for: ' . $subpanel_id);
        }

        return $subpanel_define;
    }

    public static function getCustomSubpanelDefine($module, $subpanel_id)
    {
        $ret_val = [];

        if ($subpanel_id != '') {
            $layout_defs = get_layout_defs();

            if (!empty($layout_defs[$module]['custom_subpanel_defines'][$subpanel_id])) {
                $ret_val = $layout_defs[$module]['custom_subpanel_defines'][$subpanel_id];
            }
        }

        return $ret_val;
    }

    public static function getDefaultSubpanelDefine($module, $subpanel_id)
    {
        $ret_val = [];

        if ($subpanel_id != '') {
            $layout_defs = get_layout_defs();

            if (!empty($layout_defs[$subpanel_id]['default_subpanel_define'])) {
                $ret_val = $layout_defs[$subpanel_id]['default_subpanel_define'];
            }
        }

        return $ret_val;
    }
}
