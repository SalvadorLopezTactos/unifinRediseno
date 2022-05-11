<?php
/**
 * User: Adrian Arauz
 * Date: 3/05/2022
 * Time: 11:35 AM
 */

$dependencies['Propects']['hide_panel_3_dep']=array(
    'hooks' => array("all"),
       'trigger' => 'true',
       'triggerFields' => array('assigned_user_id','date_entered','estatus_po_c'),  // what field should this be triggered on
       'onload' => true,
       'actions' => array(
           array(
               'name' => 'SetPanelVisibility',  // the action you want to run
               'params' => array(
                   'target' => 'LBL_RECORDVIEW_PANEL3',  // name of the panel, can be found in the vardefs.
                   'value' => 'false',  // the formula to run to determine if the panel should be hidden or not.
               ),
           ),
       ),
   );
