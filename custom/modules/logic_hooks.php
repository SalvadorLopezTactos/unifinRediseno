<?php

$hook_version = 1;
$hook_array = Array();

$hook_array['after_ui_footer'] = Array();
$hook_array['after_ui_footer'][] = Array(
    //Processing index. For sorting the array.
    1,

    //Label. A string value to identify the hook.
    'after_ui_footer example',

    //The PHP file where your class is located.
    'custom/modules/application_hooks_class.php',

    //The class the method is in.
    'application_hooks_class',

    //The method to call.
    'after_ui_footer_method'
);

?>