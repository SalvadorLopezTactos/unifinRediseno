<?php
global $current_user;
$userid=$current_user->id;
$dependencies['Meetings']['readOnly'] = array
(
            'hooks' => array("all"),
            'trigger' => 'true',
            'triggerFields' => array('created_by','description','status'),
            'onload' => true,
            'actions' => array
      	    (
                array
	            	(
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'edit_button',
                        'label' => 'LBL_EDIT_BUTTON_LABEL',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'name',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'date_start',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'date_end',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'repeat_type',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'location',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                                                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'reminder_time',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'email_reminder_time',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'description',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                            
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'invitees',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'assigned_user_name',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'referenciada_c',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'parent_type',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'check_in_address_c',
                        'value' => 'or(equal($status,"Held"),equal($status,"Not Held"),equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante."))',
                    ),
                ),                                                
            ),
            'notActions' => array(),


);
//Dependencia para ocultar en llamdas la cuenta y así asignar una única a la relación Adrian Arauz 20/707/18
/*$dependencies['Meetings']['ReunionesNO'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    //Optional, the trigger for the dependency. Defaults to 'true'.
    'triggerFields' => array('parent_name','id'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    // You could list multiple fields here each in their own array under 'actions'
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            //The parameters passed in will depend on the action type set in 'name'
            'params' => array(
                'target' => 'parent_name',
                'value' => 'true',
            ),
        ),

    ),
);*/

/*@Jesus Carrillo
  Se deshabilita con el fin de poder ajustar el tamaño del campo en el CreateView
$dependencies['Meetings']['status'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('id','paso_c','date_start','date_start_time','status'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'status',
                //'value' => 'or(equal($id,""),equal($status,"Held"),equal($status,"Not Held"),$paso_c)',
                'value' => 'equal($id,"")',
            ),
        ),
    ),
);
*/
$dependencies['Meetings']['invitees'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('status'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'invitees',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
    ),
);

$dependencies['Meetings']['objetivo_c'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('status'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'ReadOnly',
            'params' => array(
                'target' => 'objetivo_c',
                'value' => 'or(equal($status,"Held"),equal($status,"Not Held"))',
            ),
        ),
    ),
);