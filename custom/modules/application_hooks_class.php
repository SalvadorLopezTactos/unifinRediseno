<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class application_hooks_class
{
    function after_ui_footer_method($event, $arguments)
    {
        ?>
        <script type="text/javascript">
            $('input[name="assigned_user_name"]').parent().attr('style','pointer-events:none');
        </script>

        <?php

    }
}




?>
