<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 7/29/2015
 * Time: 4:24 PM
 */
//Loop through the groupings to find include/javascript/sugar_grp7.min.js
foreach ($js_groupings as $key => $groupings)
{
    foreach  ($groupings as $file => $target)
    {
        if ($target == 'include/javascript/sugar_grp7.min.js')
        {
            //append the custom helper file
            $js_groupings[$key]['custom/JavaScript/formatNumber-handlebar-helpers.js'] = 'include/javascript/sugar_grp7.min.js';
        }

        break;
    }
}