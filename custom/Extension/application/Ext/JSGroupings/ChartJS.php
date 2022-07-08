<?php

//Loop through the groupings to find grouping file you want to append to

foreach ($js_groupings as $key => $groupings)
{
    foreach  ($groupings as $file => $target)
    {
    	//if the target grouping is found
        if ($target == 'include/javascript/sugar_grp7.min.js')
        {
            //append the custom JavaScript file
            $js_groupings[$key]['custom/ChartJS/dist/chart.js'] = 'include/javascript/sugar_grp7.min.js';
        }
        break;
    }
}