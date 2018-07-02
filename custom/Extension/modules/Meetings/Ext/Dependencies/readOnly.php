<?php
global $current_user;
$userid=$current_user->id;
$dependencies['Meetings']['readOnly'] = array
(
            'hooks' => array("all"),
            'trigger' => 'true',
            'triggerFields' => array('created_by','description'),
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
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'name',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'date_start',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'date_end',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'repeat_type',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'location',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                                                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'reminder_time',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'email_reminder_time',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'description',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                            
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'invitees',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'assigned_user_name',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'referenciada_c',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'parent_name',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
                array
		            (
                    'name' => 'ReadOnly',
                    'params' => array
		                (
                        'target' => 'check_in_address_c',
                        'value' => 'equal($description,"Cita registrada automaticamente por CRM ya que ha sido asignado como acompaniante.")',
                    ),
                ),                                                
            ),
            'notActions' => array(),
);
