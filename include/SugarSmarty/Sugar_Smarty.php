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


if(!defined('SUGAR_SMARTY_DIR'))
{
	define('SUGAR_SMARTY_DIR', sugar_cached('smarty/'));
}

/**
 * Smarty wrapper for Sugar
 * @api
 */
class Sugar_Smarty extends SmartyBC
{
    protected static $_plugins_dir;
    /**
     * Allows {$foo} where foo is unset.
     * @var bool
     */
    public $allowUndefinedVars = true;

    /**
     * Allows {$foo.bar} where bar is unset and {$foo.bar1.bar2} where either bar1 or bar2 is unset.
     * @var bool
     */
    public $allowUndefinedArrayKeys = true;

    private $previousErrorHandler = null;

    public function __construct()
    {
        parent::__construct();
        $this->error_reporting = error_reporting() & ~E_NOTICE;
        if (!file_exists(SUGAR_SMARTY_DIR)) {
            mkdir_recursive(SUGAR_SMARTY_DIR, true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'templates_c')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'templates_c', true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'configs')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'configs', true);
        }
        if (!file_exists(SUGAR_SMARTY_DIR . 'cache')) {
            mkdir_recursive(SUGAR_SMARTY_DIR . 'cache', true);
        }

        $this->addTemplateDirectories();
        $this->setCompileDir(SUGAR_SMARTY_DIR . 'templates_c');
        $this->setCacheDir(SUGAR_SMARTY_DIR . 'cache');
        $this->setConfigDir(SUGAR_SMARTY_DIR . 'configs');

        // Smarty will create subdirectories under the compiled templates and cache directories
        $this->use_sub_dirs = true;

        if (empty(self::$_plugins_dir)) {
            self::$_plugins_dir = array();
            if (file_exists('custom/include/SugarSmarty/plugins')) {
                self::$_plugins_dir[] = 'custom/include/SugarSmarty/plugins';
            }
            if (file_exists('custom/vendor/smarty/smarty/libs/plugins')) {
                self::$_plugins_dir[] = 'custom/vendor/smarty/smarty/libs/plugins';
            }
            if (file_exists('custom/vendor/Smarty/plugins')) {
                self::$_plugins_dir[] = 'custom/vendor/Smarty/plugins';
            }
            self::$_plugins_dir[] = 'include/SugarSmarty/plugins';
            self::$_plugins_dir[] = 'vendor/smarty/smarty/libs/plugins';
        }
        $this->plugins_dir = self::$_plugins_dir;

        $this->assign("VERSION_MARK", getVersionedPath(''));
    }

    public function mutingErrorHandler($errno, $errstr, $errfile, $errline, $errcontext = [])
    {
        $smartyDirs = [
            realpath(SUGAR_PATH . DIRECTORY_SEPARATOR . SUGAR_SMARTY_DIR),
            realpath(SMARTY_DIR),
        ];
        foreach (self::$_plugins_dir as $pluginsDir) {
            $smartyDir = realpath($pluginsDir);
            if (!empty($smartyDir)) {
                $smartyDirs[] = $smartyDir;
            }
        }
        $isSmartyRelated = false;
        foreach ($smartyDirs as $smartyDir) {
            if (!strncmp($errfile, $smartyDir, strlen($smartyDir))
            ) {
                $isSmartyRelated = true;
            }
        }

        if ($isSmartyRelated && $this->allowUndefinedVars && $errstr === 'Attempt to read property "value" on null') {
            return; // suppresses this error
        }
        if ($isSmartyRelated && $this->allowUndefinedArrayKeys && preg_match(
            '/^(Undefined array key|Trying to access array offset on value of type null)/',
            $errstr
        )) {
            return;// suppresses this error
        }
        // pass to next error handler if this error did not occur inside SMARTY related dir
        // or the error was within smarty but masked to be ignored
        if ($errno && $errno & error_reporting()) {
            if ($this->previousErrorHandler) {
                return call_user_func(
                    $this->previousErrorHandler,
                    $errno,
                    $errstr,
                    $errfile,
                    $errline,
                    $errcontext
                );
            } else {
                return false;
            }
        }
    }

    /**
     * Adds the list of directories where templates could be stored
     */
    public function addTemplateDirectories()
    {
        // Add the base directory
        $this->addTemplateDir('.');

        // Get the current theme, and add its template directory
        $currentTheme = SugarThemeRegistry::current();
        $this->addTemplateDir($currentTheme->getTemplatePath(), 'theme');

        // Themes can define parent themes, so climb up the parent tree and add the theme's ancestors' template
        // directories as well. This way, if a theme doesn't define a template, it will inherit the template from an
        // ancestor theme
        while (isset($currentTheme->parentTheme)) {
            $parentTheme = SugarThemeRegistry::get($currentTheme->parentTheme);
            if ($parentTheme instanceof SugarTheme) {
                $this->addTemplateDir($parentTheme->getTemplatePath());
                $currentTheme = $parentTheme;
            } else {
                break;
            }
        }
    }

	/**
	 * Fetch template or custom double
	 * @see Smarty::fetch()
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
	 */
	public function fetchCustom($resource_name, $cache_id = null, $compile_id = null, $display = false)
	{
	    return $this->fetch(SugarAutoLoader::existingCustomOne($resource_name), $cache_id, $compile_id, $display);
	}

	/**
	 * Display template or custom double
	 * @see Smarty::display()
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
	 */
	function displayCustom($resource_name, $cache_id = null, $compile_id = null)
	{
	    return $this->display(SugarAutoLoader::existingCustomOne($resource_name), $cache_id, $compile_id);
	}

	/**
	 * Override default _unlink method call to fix Bug 53010
	 *
	 * @param string $resource
     * @param integer $exp_time
     */
    function _unlink($resource, $exp_time = null)
    {
        if(file_exists($resource)) {
            return parent::_unlink($resource, $exp_time);
        }

        // file wasn't found, so it must be gone.
        return true;
    }

    /**
     * assigns a Smarty variable and also assign to a new smarty object
     *
     * @param Smarty       $smartyTpl
     * @param array|string $tpl_var the template variable name(s)
     * @param mixed        $value   the value to assign
     * @param boolean      $nocache if true any output of this variable will be not cached
     *
     * @return Smarty_Internal_Data current Smarty_Internal_Data (or Smarty or Smarty_Internal_Template) instance for
     *                              chaining
     */
    public function assignAndCopy($smartyTpl, $tpl_var, $value = null, $nocache = false)
    {
        $this->assign($tpl_var, $value, $nocache);
        if (!empty($smartyTpl)) {
            $smartyTpl->assign($tpl_var, $value, $nocache);
        }
    }

    /**
     * fetches a rendered Smarty template
     *
     * @param string $template the resource handle of the template file or template object
     * @param mixed $cache_id cache id to be used with this template
     * @param mixed $compile_id compile id to be used with this template
     * @param object $parent next higher level of Smarty variables
     *
     * @return string rendered template output
     * @throws SmartyException
     * @throws Exception
     */
    public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $savedPrevious = $this->previousErrorHandler;
        $this->previousErrorHandler = set_error_handler([$this, 'mutingErrorHandler']);
        try {
            return parent::fetch($template, $cache_id, $compile_id, $parent);
        } finally {
            restore_error_handler();
            $this->previousErrorHandler = $savedPrevious;
        }
    }

    /**
     * displays a Smarty template
     *
     * @param string $template the resource handle of the template file or template object
     * @param mixed $cache_id cache id to be used with this template
     * @param mixed $compile_id compile id to be used with this template
     * @param object $parent next higher level of Smarty variables
     *
     * @throws \Exception
     * @throws \SmartyException
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $savedPrevious = $this->previousErrorHandler;
        $this->previousErrorHandler = set_error_handler([$this, 'mutingErrorHandler']);
        try {
            parent::display($template, $cache_id, $compile_id, $parent);
        } finally {
            restore_error_handler();
            $this->previousErrorHandler = $savedPrevious;
        }
    }
}
