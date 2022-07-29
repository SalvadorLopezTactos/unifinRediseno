<?php
// created: 2018-02-16 18:51:04
$viewdefs['Meetings']['QuickCreate'] = array (
  'templateMeta' => 
  array (
    'maxColumns' => '2',
    'form' => 
    array (
      'hidden' => 
      array (
        0 => '<input type="hidden" name="isSaveAndNew" value="false">',
      ),
      'buttons' => 
      array (
        0 => 
        array (
          'customCode' => '<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button" onclick="SUGAR.meetings.fill_invitees();this.form.action.value=\'Save\'; this.form.return_action.value=\'DetailView\'; {if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}this.form.return_id.value=\'\'; {/if}return check_form(\'EditView\');" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">',
        ),
        1 => 'CANCEL',
        2 => 
        array (
          'customCode' => '<input title="{$MOD.LBL_SEND_BUTTON_TITLE}" class="button" onclick="this.form.send_invites.value=\'1\';SUGAR.meetings.fill_invitees();this.form.action.value=\'Save\';this.form.return_action.value=\'EditView\';this.form.return_module.value=\'{$smarty.request.return_module}\';return check_form(\'EditView\');" type="submit" name="button" value="{$MOD.LBL_SEND_BUTTON_LABEL}">',
        ),
        3 => 
        array (
          'customCode' => '{if $fields.status.value != "Held"}<input title="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}" accessKey="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_KEY}" class="button" onclick="SUGAR.meetings.fill_invitees(); this.form.status.value=\'Held\'; this.form.action.value=\'Save\'; this.form.return_module.value=\'Meetings\'; this.form.isDuplicate.value=true; this.form.isSaveAndNew.value=true; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$fields.id.value}\'; return check_form(\'EditView\');" type="submit" name="button" value="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_LABEL}">{/if}',
        ),
      ),
    ),
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'javascript' => '<script type="text/javascript">{$JSON_CONFIG_JAVASCRIPT}</script>
{sugar_getscript file="cache/include/javascript/sugar_grp_jsolait.js"}
<script>toggle_portal_flag();function toggle_portal_flag()  {literal} { {/literal} {$TOGGLE_JS} {literal} } {/literal} </script>',
    'useTabs' => false,
    'tabDefs' => 
    array (
      'DEFAULT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'name',
          'displayParams' => 
          array (
            'required' => true,
          ),
        ),
        1 => 
        array (
          'name' => 'status',
          'fields' => 
          array (
            0 => 
            array (
              'name' => 'status',
            ),
          ),
        ),
      ),
      1 => 
      array (
        0 => 
        array (
          'name' => 'objetivo_c',
          'studio' => 'visible',
          'label' => 'LBL_OBJETIVO_C',
        ),
        1 => 
        array (
          'name' => 'resultado_c',
          'studio' => 'visible',
          'label' => 'LBL_RESULTADO_C',
        ),
      ),
      2 => 
      array (
        0 => 
        array (
          'name' => 'date_start',
          'type' => 'datetimecombo',
          'displayParams' => 
          array (
            'required' => true,
            'updateCallback' => 'SugarWidgetScheduler.update_time();',
          ),
        ),
        1 => 
        array (
          'name' => 'parent_name',
          'label' => 'LBL_LIST_RELATED_TO',
        ),
      ),
      3 => 
      array (
        0 => 
        array (
          'name' => 'date_end',
          'type' => 'datetimecombo',
          'displayParams' => 
          array (
            'required' => true,
            'updateCallback' => 'SugarWidgetScheduler.update_time();',
          ),
        ),
        1 => 
        array (
          'name' => 'location',
          'comment' => 'Meeting location',
          'label' => 'LBL_LOCATION',
        ),
      ),
      4 => 
      array (
        0 => 
        array (
          'name' => 'duration',
          'customCode' => '
                @@FIELD@@
                <input id="duration_hours" name="duration_hours" type="hidden" value="{$fields.duration_hours.value}">
                <input id="duration_minutes" name="duration_minutes" type="hidden" value="{$fields.duration_minutes.value}">
                {sugar_getscript file="modules/Meetings/duration_dependency.js"}
                <script type="text/javascript">
                    var date_time_format = "{$CALENDAR_FORMAT}";
                    {literal}
                    SUGAR.util.doWhen(function(){return typeof DurationDependency != "undefined" && typeof document.getElementById("duration") != "undefined"}, function(){
                        var duration_dependency = new DurationDependency("date_start","date_end","duration",date_time_format);
                        //initEditView(YAHOO.util.Selector.query(\'select#duration\')[0].form);
                    });
                    {/literal}
                </script>            
            ',
        ),
        1 => 
        array (
          'name' => 'acompaniante_c',
          'studio' => 'visible',
          'label' => 'LBL_ACOMPANIANTE_C',
        ),
      ),
      5 => 
      array (
        0 => 
        array (
          'name' => 'referenciada_c',
          'label' => 'LBL_REFERENCIADA_C',
        ),
        1 => '',
      ),
      6 => 
      array (
        0 => 
        array (
          'name' => 'description',
          'comment' => 'Full text of the note',
          'label' => 'LBL_DESCRIPTION',
        ),
      ),
      7 => 
      array (
        0 => 
        array (
          'name' => 'assigned_user_name',
          'label' => 'LBL_ASSIGNED_TO_NAME',
        ),
      ),
      8 => 
      array (
        0 => '',
        1 => 
        array (
          'name' => 'reminder_time',
          'customCode' => '{include file="modules/Meetings/tpls/reminders.tpl"}',
          'label' => 'LBL_REMINDER',
        ),
      ),
    ),
  ),
);