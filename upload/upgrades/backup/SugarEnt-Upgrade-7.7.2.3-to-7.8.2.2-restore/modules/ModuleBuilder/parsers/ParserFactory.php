<?php
if (! defined ( 'sugarEntry' ) || ! sugarEntry)
    die ( 'Not A Valid Entry Point' ) ;

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

require_once 'modules/ModuleBuilder/parsers/constants.php';

class ParserFactory
{
    /**
     * @param $view
     * @return mixed
     * hack for portal to use its own constants
     */
    protected static function _helperConvertToViewConstant($view)
    {
        $map = array(
            'edit' => MB_PORTALEDITVIEW,
            'detail' => MB_PORTALDETAILVIEW,
            'record'=> MB_PORTALRECORDVIEW,
            'search' => MB_PORTALSEARCHVIEW,
            'list' => MB_PORTALLISTVIEW
        );

        // view variable sent to the factory has changed: remove 'view' suffix
        // in case of further change
        $view = strtolower($view);
        if (substr_compare($view,'view',-4) === 0) {
            $view = substr($view,0,-4);
        }

        return $map[$view];
    }

    /**
     * Create a new parser
     *
     * @param string $view          The view, for example EditView or ListView. For search views, use advanced_search or basic_search
     * @param string $moduleName    Module name
     * @param string $packageName   Package name. If present implies that we are being called from ModuleBuilder
     * @param string $client        The view client (e.g. portal, wireless, etc.)
     * @param array  $params        Additional parser parameters
     * @return AbstractMetaDataParser
     */
    public static function getParser(
        $view,
        $moduleName,
        $packageName = null,
        $subpanelName = null,
        $client = '',
        array $params = array()
    ) {
        $GLOBALS [ 'log' ]->info ( "ParserFactory->getParser($view,$moduleName,$packageName,$subpanelName,$client )" ) ;
        $sm = null;
        $lView = strtolower ( $view );
        if ( empty ( $packageName ) || ( $packageName == 'studio' ) ) {
            $packageName = null ;
            //For studio modules, check for view parser overrides
            $parser = self::checkForStudioParserOverride($view, $moduleName, $packageName);
            if ($parser) return $parser;
            $sm = StudioModuleFactory::getStudioModule($moduleName);
            //If we didn't find a specofic parser, see if there is a view to type mapping
            foreach ($sm->sources as $file => $def) {
                if (!empty($def['view']) && $def['view'] == $view && !empty($def['type'])) {
                    $lView = strtolower($def['type']);
                    break;
                }
            }
        }

        switch ( $lView) {
            case MB_RECORDVIEW:
                require_once 'modules/ModuleBuilder/parsers/views/SidecarGridLayoutMetaDataParser.php' ;
                return new SidecarGridLayoutMetaDataParser($view, $moduleName, $packageName, 'base', $params);
            case MB_EDITVIEW :
            case MB_DETAILVIEW :
            case MB_QUICKCREATE :
                require_once 'modules/ModuleBuilder/parsers/views/GridLayoutMetaDataParser.php';

                return new GridLayoutMetaDataParser ( $view, $moduleName, $packageName ) ;
            case MB_WIRELESSEDITVIEW :
            case MB_WIRELESSDETAILVIEW :
            case MB_PORTALRECORDVIEW:
            case MB_PORTALDETAILVIEW:
            case MB_PORTALEDITVIEW:
                if (empty($client)) {
                    $client = MB_WIRELESS;
                    if ($lView == MB_PORTALRECORDVIEW || $lView == MB_PORTALDETAILVIEW || $lView == MB_PORTALEDITVIEW) {
                        $client = MB_PORTAL;
                }
                }
                require_once 'modules/ModuleBuilder/parsers/views/SidecarGridLayoutMetaDataParser.php';

                return new SidecarGridLayoutMetaDataParser($view, $moduleName, $packageName, $client, $params);
            case MB_WIRELESSLISTVIEW:
                // Handle client settings if we can
                if (empty($client)) {
                    $client = MB_WIRELESS;
                }
                require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';
                return new SidecarListLayoutMetaDataParser($view, $moduleName, $packageName, $client);
            case MB_PORTALLISTVIEW:
                // Handle client settings if we can
                if (empty($client)) {
                    $client = MB_PORTAL;
                }
                require_once 'modules/ModuleBuilder/parsers/views/SidecarPortalListLayoutMetaDataParser.php';
                return new SidecarPortalListLayoutMetaDataParser($view, $moduleName, $packageName, $client);
            case MB_BASICSEARCH :
            case MB_ADVANCEDSEARCH :
            case MB_WIRELESSBASICSEARCH :
            case MB_WIRELESSADVANCEDSEARCH :
                // Make sure we have the right client
                if ($lView == MB_WIRELESSBASICSEARCH || $lView == MB_WIRELESSADVANCEDSEARCH) {
                    $client = MB_WIRELESS;
                }
                // When it comes to search, mobile is like BWC
                if (isModuleBWC($moduleName) || $client == MB_WIRELESS) {
                    require_once 'modules/ModuleBuilder/parsers/views/SearchViewMetaDataParser.php';
                    return new SearchViewMetaDataParser($view, $moduleName, $packageName, $client) ;
                }

                require_once 'modules/ModuleBuilder/parsers/views/SidecarFilterLayoutMetaDataParser.php';
                $client = empty($client) ? 'base' : $client;
                return new SidecarFilterLayoutMetaDataParser($moduleName, $packageName, $client);

            case MB_LISTVIEW :
                if ($subpanelName == null) {
                    if (isModuleBWC($moduleName)) {
                        require_once 'modules/ModuleBuilder/parsers/views/ListLayoutMetaDataParser.php';

                        return new ListLayoutMetaDataParser ( MB_LISTVIEW, $moduleName, $packageName ) ;
                    } else {
                        require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';

                        return new SidecarListLayoutMetaDataParser (MB_SIDECARLISTVIEW, $moduleName, $packageName, 'base' ) ;
                    }
                } else {
                    if (isModuleBWC($moduleName)) {
                        require_once 'modules/ModuleBuilder/parsers/views/SubpanelMetaDataParser.php' ;
                        return new SubpanelMetaDataParser($subpanelName, $moduleName, $packageName);
                    } else {
                        // $client can be empty for all other Parsers, however SidecarSubpanelLayout needs it set, therefore if its blank its base
                        $client = empty($client) ? 'base' : $client;
                        require_once 'modules/ModuleBuilder/parsers/views/SidecarSubpanelLayoutMetaDataParser.php' ;
                        return new SidecarSubpanelLayoutMetaDataParser($subpanelName, $moduleName, $packageName, $client);
                    }
                }
            case MB_DASHLET :
            case MB_DASHLETSEARCH :
                require_once 'modules/ModuleBuilder/parsers/views/DashletMetaDataParser.php';

                return new DashletMetaDataParser($view, $moduleName, $packageName  );
            case MB_SIDECARPOPUPVIEW:
            case MB_SIDECARDUPECHECKVIEW:
                require_once 'modules/ModuleBuilder/parsers/views/SidecarListLayoutMetaDataParser.php';
                return new SidecarListLayoutMetaDataParser($view, $moduleName, $packageName, 'base');
            case MB_POPUPLIST :
            case MB_POPUPSEARCH :
                require_once 'modules/ModuleBuilder/parsers/views/PopupMetaDataParser.php';

                $parser = new PopupMetaDataParser($view, $moduleName, $packageName);
                // The popup parser needs the client and needs it to be set to
                // something in order to validate fields
                $parser->client = empty($client) ? 'base' : $client;
                return $parser;
            case MB_LABEL :
                require_once 'modules/ModuleBuilder/parsers/parser.label.php';

                return new ParserLabel ( $moduleName, $packageName ) ;
            case MB_VISIBILITY :
                require_once 'modules/ModuleBuilder/parsers/parser.visibility.php';

                return new ParserVisibility ( $moduleName, $packageName ) ;
            default :
                $parser = self::checkForParserClass($view, $moduleName, $packageName);
                if ($parser)
                    return $parser;

        }

        $GLOBALS [ 'log' ]->fatal ("ParserFactory: cannot create ModuleBuilder Parser $view" ) ;

    }

    protected static function checkForParserClass($view, $moduleName, $packageName, $nameOverride = false)
    {
        $prefix = '';
        if (!is_null ( $packageName )) {
            $prefix = empty($packageName) ? 'build' :'modify';
        }
        $fileNames = array(
            "custom/modules/$moduleName/parsers/parser." . strtolower ( $prefix . $view ) . ".php",
            "modules/$moduleName/parsers/parser." . strtolower ( $prefix . $view ) . ".php",
            "custom/modules/ModuleBuilder/parsers/parser." . strtolower ( $prefix . $view ) . ".php",
            "modules/ModuleBuilder/parsers/parser." . strtolower ( $prefix . $view ) . ".php",
        );
        foreach ($fileNames as $fileName) {
            if (file_exists ( $fileName )) {
                require_once $fileName ;
                $class = 'Parser' . $prefix . ucfirst ( $view ) ;
                if (class_exists ( $class )) {
                    $GLOBALS [ 'log' ]->debug ( 'Using ModuleBuilder Parser ' . $fileName ) ;
                    $parser = new $class ( ) ;

                    return $parser ;
                }
            }
        }

        return false;
    }

    protected static function checkForStudioParserOverride($view, $moduleName, $packageName)
    {
        require_once 'modules/ModuleBuilder/Module/StudioModuleFactory.php';
        $sm = StudioModuleFactory::getStudioModule($moduleName);
        foreach ($sm->sources as $file => $def) {
            if (!empty($def['view']) && $def['view'] == strtolower($view) && !empty($def['parser'])) {
                $pName = $def['parser'];
                $path = "modules/ModuleBuilder/parsers/views/{$pName}.php";
                if (file_exists("custom/$path"))
                    require_once("custom/$path");
                else if (file_exists($path))
                    require_once($path);
                if (class_exists ( $pName ))
                    return new $pName($view, $moduleName, $packageName);
                //If it wasn't defined directly, check for a generic parser name for the view
                $parser = self::checkForParserClass($view, $moduleName, $packageName);
                if ($parser)
                    return $parser;
            }
        }

        return false;
    }

}
?>
