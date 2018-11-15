<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Creado por: Salvador Lopez salvador.lopez@tactos.com.mx
 *
 * Logichook que se ejecuta en los módulos bwc
 * Este archivo bloquea el campo de "Asignado a" en módulo de Documents
 * */
class application_hooks_class
{
    function after_ui_footer_method($event, $arguments)
    {
        if($_REQUEST['module']=='Documents' && ($_REQUEST['action']=='editview' ||  $_REQUEST['action']=='EditView')) {
            ?>
            <script type="text/javascript">
                $('input[name="assigned_user_name"]').parent().attr('style', 'pointer-events:none');
            </script>

            <?php
        }
    }
}




?>
