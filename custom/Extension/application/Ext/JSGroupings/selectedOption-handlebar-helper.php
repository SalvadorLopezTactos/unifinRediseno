<?php
/**
 * Created by Levementum.
 * User: jgarcia@levementum.com
 * Date: 9/16/2016
 * Time: 4:17 PM
 */

//Loop through the groupings to find include/javascript/sugar_grp7.min.js
foreach ($js_groupings as $key => $groupings)
{
    foreach  ($groupings as $file => $target)
    {
        if ($target == 'include/javascript/sugar_grp7.min.js')
        {
            //append the custom helper file
            $js_groupings[$key]['custom/JavaScript/selectedOption-handlebar-helpers.js'] = 'include/javascript/sugar_grp7.min.js';
        }

        break;
    }
}