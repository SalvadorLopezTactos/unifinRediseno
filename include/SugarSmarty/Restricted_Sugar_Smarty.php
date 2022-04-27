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


use Sugarcrm\Sugarcrm\Security\ModuleScanner\CodeScanner;

/**
 * Smarty wrapper for Sugar
 * @api
 */
class Restricted_Sugar_Smarty extends Sugar_Smarty
{
    private $classBlackList = array(
        // Class names specified here must be in lowercase as the implementation
        // of the tokenizer converts all tokens to lowercase.
        'reflection',
        'reflectionclass',
        'reflectionzendextension',
        'reflectionextension',
        'reflectionfunction',
        'reflectionfunctionabstract',
        'reflectionmethod',
        'reflectionobject',
        'reflectionparameter',
        'reflectionproperty',
        'reflector',
        'reflectionexception',
        'lua',
        'ziparchive',
        'splfileinfo',
        'splfileobject',
        'sugarautoloader',

    );
    private $blackList = array(
        'popen',
        'proc_open',
        'error_log',
        'escapeshellarg',
        'escapeshellcmd',
        'proc_close',
        'proc_get_status',
        'proc_nice',
        'passthru',
        'clearstatcache',
        'disk_free_space',
        'disk_total_space',
        'diskfreespace',
        'dir',
        'fclose',
        'feof',
        'fflush',
        'fgetc',
        'fgetcsv',
        'fgets',
        'fgetss',
        'file_exists',
        'file_get_contents',
        'filesize',
        'filetype',
        'flock',
        'fnmatch',
        'fpassthru',
        'fputcsv',
        'fputs',
        'fread',
        'fscanf',
        'fseek',
        'fstat',
        'ftell',
        'ftruncate',
        'fwrite',
        'glob',
        'is_dir',
        'is_file',
        'is_link',
        'is_readable',
        'is_uploaded_file',
        'opendir',
        'parse_ini_string',
        'pathinfo',
        'pclose',
        'readfile',
        'readlink',
        'realpath_cache_get',
        'realpath_cache_size',
        'realpath',
        'rewind',
        'readdir',
        'set_file_buffer',
        'tmpfile',
        'umask',
        'ini_set',
        'set_time_limit',
        'eval',
        'exec',
        'system',
        'shell_exec',
        'passthru',
        'chgrp',
        'chmod',
        'chown',
        'file_put_contents',
        'file',
        'fileatime',
        'filectime',
        'filegroup',
        'fileinode',
        'filemtime',
        'fileowner',
        'fileperms',
        'fopen',
        'is_executable',
        'is_writable',
        'is_writeable',
        'lchgrp',
        'lchown',
        'linkinfo',
        'lstat',
        'mkdir',
        'mkdir_recursive',
        'parse_ini_file',
        'rmdir',
        'rmdir_recursive',
        'stat',
        'tempnam',
        'touch',
        'unlink',
        'getimagesize',
        'call_user_func',
        'call_user_func_array',
        'create_function',


        //mutliple files per function call
        'copy',
        'copy_recursive',
        'link',
        'rename',
        'symlink',
        'move_uploaded_file',
        'chdir',
        'chroot',
        'create_cache_directory',
        'mk_temp_dir',
        'write_array_to_file',
        'write_encoded_file',
        'write_array_to_file_as_key_value_pair',
        'create_custom_directory',
        'sugar_rename',
        'sugar_chown',
        'sugar_fopen',
        'sugar_mkdir',
        'sugar_file_put_contents',
        'sugar_file_put_contents_atomic',
        'sugar_chgrp',
        'sugar_chmod',
        'sugar_touch',

        // Functions that have callbacks can circumvent our security measures.
        // List retrieved through PHP's XML documentation, and running the
        // following script in the reference directory:

        // grep -R callable . | grep -v \.svn | grep methodparam | cut -d: -f1 | sort -u | cut -d"." -f2 | sed 's/\-/\_/g' | cut -d"/" -f4

        // AMQPQueue
        'consume',

        // PHP internal - arrays
        'array_diff_uassoc',
        'array_diff_ukey',
        'array_filter',
        'array_intersect_uassoc',
        'array_intersect_ukey',
        'array_map',
        'array_reduce',
        'array_udiff_assoc',
        'array_udiff_uassoc',
        'array_udiff',
        'array_uintersect_assoc',
        'array_uintersect_uassoc',
        'array_uintersect',
        'array_walk_recursive',
        'array_walk',
        'uasort',
        'uksort',
        'usort',

        // EIO functions that accept callbacks.
        'eio_busy',
        'eio_chmod',
        'eio_chown',
        'eio_close',
        'eio_custom',
        'eio_dup2',
        'eio_fallocate',
        'eio_fchmod',
        'eio_fchown',
        'eio_fdatasync',
        'eio_fstat',
        'eio_fstatvfs',
        'eio_fsync',
        'eio_ftruncate',
        'eio_futime',
        'eio_grp',
        'eio_link',
        'eio_lstat',
        'eio_mkdir',
        'eio_mknod',
        'eio_nop',
        'eio_open',
        'eio_read',
        'eio_readahead',
        'eio_readdir',
        'eio_readlink',
        'eio_realpath',
        'eio_rename',
        'eio_rmdir',
        'eio_sendfile',
        'eio_stat',
        'eio_statvfs',
        'eio_symlink',
        'eio_sync_file_range',
        'eio_sync',
        'eio_syncfs',
        'eio_truncate',
        'eio_unlink',
        'eio_utime',
        'eio_write',

        // PHP internal - error functions
        'set_error_handler',
        'set_exception_handler',

        // Forms Data Format functions
        'fdf_enum_values',

        // PHP internal - function handling
        'call_user_func_array',
        'call_user_func',
        'forward_static_call_array',
        'forward_static_call',
        'register_shutdown_function',
        'register_tick_function',

        // Gearman
        'setclientcallback',
        'setcompletecallback',
        'setdatacallback',
        'setexceptioncallback',
        'setfailcallback',
        'setstatuscallback',
        'setwarningcallback',
        'setworkloadcallback',
        'addfunction',

        // Firebird/InterBase
        'ibase_set_event_handler',

        // LDAP
        'ldap_set_rebind_proc',

        // LibXML
        'libxml_set_external_entity_loader',

        // Mailparse functions
        'mailparse_msg_extract_part_file',
        'mailparse_msg_extract_part',
        'mailparse_msg_extract_whole_part_file',

        // Memcache(d) functions
        'addserver',
        'setserverparams',
        'get',
        'getbykey',
        'getdelayed',
        'getdelayedbykey',

        // MySQLi
        'set_local_infile_handler',

        // PHP internal - network functions
        'header_register_callback',

        // Newt
        'newt_entry_set_filter',
        'newt_set_suspend_callback',

        // OAuth
        'consumerhandler',
        'timestampnoncehandler',
        'tokenhandler',

        // PHP internal - output control
        'ob_start',

        // PHP internal - PCNTL
        'pcntl_signal',

        // PHP internal - PCRE
        'preg_replace_callback',

        // SQLite
        'sqlitecreateaggregate',
        'sqlitecreatefunction',
        'sqlite_create_aggregate',
        'sqlite_create_function',

        // RarArchive
        'open',

        // Readline
        'readline_callback_handler_install',
        'readline_completion_function',

        // PHP internal - session handling
        'session_set_save_handler',

        // PHP internal - SPL
        'construct',
        'iterator_apply',
        'spl_autoload_register',

        // Sybase
        'sybase_set_message_handler',

        // PHP internal - variable handling
        'is_callable',

        // XML Parser
        'xml_set_character_data_handler',
        'xml_set_default_handler',
        'xml_set_element_handler',
        'xml_set_end_namespace_decl_handler',
        'xml_set_external_entity_ref_handler',
        'xml_set_notation_decl_handler',
        'xml_set_processing_instruction_handler',
        'xml_set_start_namespace_decl_handler',
        'xml_set_unparsed_entity_decl_handler',
        'simplexml_load_file',
        'simplexml_load_string',

        // unzip
        'unzip',
        'unzip_file',

        // sugar vulnerable functions, need to be lower case
        'getfunctionvalue',

        //smarty
        'smarty_function_fetch',
    );
    private $methodsBlackList = array(
        'setlevel',
        'put' => array('sugarautoloader'),
        'unlink' => array('sugarautoloader'),
    );

    /**
     * executes & returns or displays the template results
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        static $_cache_info = array();

        $_smarty_old_error_level = $this->debugging ? error_reporting() : error_reporting(isset($this->error_reporting)
            ? $this->error_reporting : error_reporting() & ~E_NOTICE);

        if (!$this->debugging && $this->debugging_ctrl == 'URL') {
            $_query_string = $this->request_use_auto_globals ? $_SERVER['QUERY_STRING'] : $GLOBALS['HTTP_SERVER_VARS']['QUERY_STRING'];
            if (@strstr($_query_string, $this->_smarty_debug_id)) {
                if (@strstr($_query_string, $this->_smarty_debug_id . '=on')) {
                    // enable debugging for this browser session
                    @setcookie('SMARTY_DEBUG', true);
                    $this->debugging = true;
                } elseif (@strstr($_query_string, $this->_smarty_debug_id . '=off')) {
                    // disable debugging for this browser session
                    @setcookie('SMARTY_DEBUG', false);
                    $this->debugging = false;
                } else {
                    // enable debugging for this page
                    $this->debugging = true;
                }
            } else {
                $this->debugging = (bool)($this->request_use_auto_globals ? @$_COOKIE['SMARTY_DEBUG'] : @$GLOBALS['HTTP_COOKIE_VARS']['SMARTY_DEBUG']);
            }
        }

        if ($this->debugging) {
            // capture time for debugging info
            $_params = array();
            require_once SMARTY_CORE_DIR . 'core.get_microtime.php';
            $_debug_start_time = smarty_core_get_microtime($_params, $this);
            $this->_smarty_debug_info[] = array(
                'type' => 'template',
                'filename' => $resource_name,
                'depth' => 0,
            );
            $_included_tpls_idx = count($this->_smarty_debug_info) - 1;
        }

        if (!isset($compile_id)) {
            $compile_id = $this->compile_id;
        }

        $this->_compile_id = $compile_id;
        $this->_inclusion_depth = 0;

        if ($this->caching) {
            // save old cache_info, initialize cache_info
            array_push($_cache_info, $this->_cache_info);
            $this->_cache_info = array();
            $_params = array(
                'tpl_file' => $resource_name,
                'cache_id' => $cache_id,
                'compile_id' => $compile_id,
                'results' => null,
            );
            require_once SMARTY_CORE_DIR . 'core.read_cache_file.php';
            if (smarty_core_read_cache_file($_params, $this)) {
                $_smarty_results = $_params['results'];
                if (!empty($this->_cache_info['insert_tags'])) {
                    $_params = array('plugins' => $this->_cache_info['insert_tags']);
                    require_once SMARTY_CORE_DIR . 'core.load_plugins.php';
                    smarty_core_load_plugins($_params, $this);
                    $_params = array('results' => $_smarty_results);
                    require_once SMARTY_CORE_DIR . 'core.process_cached_inserts.php';
                    $_smarty_results = smarty_core_process_cached_inserts($_params, $this);
                }
                if (!empty($this->_cache_info['cache_serials'])) {
                    $_params = array('results' => $_smarty_results);
                    require_once SMARTY_CORE_DIR . 'core.process_compiled_include.php';
                    $_smarty_results = smarty_core_process_compiled_include($_params, $this);
                }


                if ($display) {
                    if ($this->debugging) {
                        // capture time for debugging info
                        $_params = array();
                        require_once SMARTY_CORE_DIR . 'core.get_microtime.php';
                        $this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = smarty_core_get_microtime($_params, $this) - $_debug_start_time;
                        require_once SMARTY_CORE_DIR . 'core.display_debug_console.php';
                        $_smarty_results .= smarty_core_display_debug_console($_params, $this);
                    }
                    if ($this->cache_modified_check) {
                        $_server_vars = ($this->request_use_auto_globals) ? $_SERVER : $GLOBALS['HTTP_SERVER_VARS'];
                        $_last_modified_date = @substr($_server_vars['HTTP_IF_MODIFIED_SINCE'], 0, strpos($_server_vars['HTTP_IF_MODIFIED_SINCE'], 'GMT') + 3);
                        $_gmt_mtime = gmdate('D, d M Y H:i:s', $this->_cache_info['timestamp']) . ' GMT';
                        if (@count($this->_cache_info['insert_tags']) == 0
                            && !$this->_cache_serials
                            && $_gmt_mtime == $_last_modified_date) {
                            if (php_sapi_name() == 'cgi') {
                                header('Status: 304 Not Modified');
                            } else {
                                header('HTTP/1.1 304 Not Modified');
                            }
                        } else {
                            header('Last-Modified: ' . $_gmt_mtime);
                            echo $_smarty_results;
                        }
                    } else {
                        echo $_smarty_results;
                    }
                    error_reporting($_smarty_old_error_level);
                    // restore initial cache_info
                    $this->_cache_info = array_pop($_cache_info);
                    return true;
                } else {
                    error_reporting($_smarty_old_error_level);
                    // restore initial cache_info
                    $this->_cache_info = array_pop($_cache_info);
                    return $_smarty_results;
                }
            } else {
                $this->_cache_info['template'][$resource_name] = true;
                if ($this->cache_modified_check && $display) {
                    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
                }
            }
        }

        // load filters that are marked as autoload
        if (count($this->autoload_filters)) {
            foreach ($this->autoload_filters as $_filter_type => $_filters) {
                foreach ($_filters as $_filter) {
                    $this->load_filter($_filter_type, $_filter);
                }
            }
        }

        $_smarty_compile_path = $this->_get_compile_path($resource_name);


        // if we just need to display the results, don't perform output
        // buffering - for speed
        $_cache_including = $this->_cache_including;
        $this->_cache_including = false;
        if ($display && !$this->caching && count($this->_plugins['outputfilter']) == 0) {
            if ($this->_is_compiled($resource_name, $_smarty_compile_path)
                || $this->_compile_resource($resource_name, $_smarty_compile_path)) {
                $codeScanner = new CodeScanner($this->classBlackList, $this->blackList, $this->methodsBlackList);
                $issues = $codeScanner->scan(file_get_contents($_smarty_compile_path));
                if (count($issues)) {
                    $messages = array_map(function (\Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\Issue $issue) {
                        return $issue->getMessage();
                    }, $issues);
                    throw new Exception(implode(', ', $messages));
                }

                include $_smarty_compile_path;
            }
        } else {
            ob_start();
            if ($this->_is_compiled($resource_name, $_smarty_compile_path)
                || $this->_compile_resource($resource_name, $_smarty_compile_path)) {
                $codeScanner = new CodeScanner($this->classBlackList, $this->blackList, $this->methodsBlackList);
                $issues = $codeScanner->scan(file_get_contents($_smarty_compile_path));
                if (count($issues)) {
                    $messages = array_map(function (\Sugarcrm\Sugarcrm\Security\ModuleScanner\Issues\Issue $issue) {
                        return $issue->getMessage();
                    }, $issues);
                    throw new Exception(implode(', ', $messages));
                }

                include $_smarty_compile_path;
            }
            $_smarty_results = ob_get_contents();
            ob_end_clean();

            foreach ((array)$this->_plugins['outputfilter'] as $_output_filter) {
                $_smarty_results = call_user_func_array($_output_filter[0], array($_smarty_results, &$this));
            }
        }

        if ($this->caching) {
            $_params = array(
                'tpl_file' => $resource_name,
                'cache_id' => $cache_id,
                'compile_id' => $compile_id,
                'results' => $_smarty_results,
            );
            require_once SMARTY_CORE_DIR . 'core.write_cache_file.php';
            smarty_core_write_cache_file($_params, $this);
            require_once SMARTY_CORE_DIR . 'core.process_cached_inserts.php';
            $_smarty_results = smarty_core_process_cached_inserts($_params, $this);

            if ($this->_cache_serials) {
                // strip nocache-tags from output
                $_smarty_results = preg_replace('!(\{/?nocache\:[0-9a-f]{32}#\d+\})!s', '', $_smarty_results);
            }
            // restore initial cache_info
            $this->_cache_info = array_pop($_cache_info);
        }
        $this->_cache_including = $_cache_including;

        if ($display) {
            if (isset($_smarty_results)) {
                echo $_smarty_results;
            }
            if ($this->debugging) {
                // capture time for debugging info
                $_params = array();
                require_once SMARTY_CORE_DIR . 'core.get_microtime.php';
                $this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = (smarty_core_get_microtime($_params, $this) - $_debug_start_time);
                require_once SMARTY_CORE_DIR . 'core.display_debug_console.php';
                echo smarty_core_display_debug_console($_params, $this);
            }
            error_reporting($_smarty_old_error_level);
            return;
        } else {
            error_reporting($_smarty_old_error_level);
            if (isset($_smarty_results)) {
                return $_smarty_results;
            }
        }
    }
}
