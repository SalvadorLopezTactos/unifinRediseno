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

require_once("include/SugarCharts/JsChart.php");

class nvd3 extends JsChart
{

    var $supports_image_export = true;
    var $print_html_legend_pdf = false;

    function __construct()
    {
        parent::__construct();
    }

    function getChartResources()
    {
        return '
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/javascript/nvd3/lib/d3.min.js').'"></script>
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/javascript/nvd3/nv.d3.min.js').'"></script>
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/javascript/rgbcolor.js').'"></script>
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/javascript/StackBlur.js').'"></script>
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/javascript/canvg.js').'"></script>
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/SugarCharts/nvd3/js/sugarCharts.js').'"></script>
        ';
    }

    function getMySugarChartResources()
    {
        return '
        <script language="javascript" type="text/javascript" src="'.getJSPath('include/SugarCharts/nvd3/js/mySugarCharts.js').'"></script>
        ';
    }

    function display($name, $xmlFile, $width = '320', $height = '480', $resize = false)
    {
        parent::display($name, $xmlFile, $width, $height, $resize);

        return $this->ss->fetch('include/SugarCharts/nvd3/tpls/chart.tpl');
    }

    function getDashletScript($id, $xmlFile = "")
    {
        parent::getDashletScript($id, $xmlFile);
        return $this->ss->fetch('include/SugarCharts/nvd3/tpls/DashletGenericChartScript.tpl');
    }
}
