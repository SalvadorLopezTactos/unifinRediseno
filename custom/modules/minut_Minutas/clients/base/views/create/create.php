<?php
$viewdefs['minut_Minutas']['base']['view']['create'] = array(
	 'template' => 'record',
	 'buttons' => array(
	 array(
		 'name' => 'cancel_button',
		 'type' => 'button',
		 'label' => 'LBL_CANCEL_BUTTON_LABEL',
		 'css_class' => 'btn-invisible btn-link',
		 'events' => array(
		 'click' => 'button:cancel_button:click',
		),
	 ),
	 array(
		 'name' => 'restore_button',
		 'type' => 'button',
		 'label' => 'LBL_RESTORE',
		 'css_class' => 'btn-invisible btn-link',
		 'showOn' => 'select',
		 'events' => array(
		 'click' => 'button:restore_button:click',
		 ),
	 ),
	 array(
		 'name' => 'save_button',
		 'type' => 'button',
		 'label' => 'LBL_SAVE_BUTTON_LABEL',
		 'primary' => true,
		 'showOn' => 'create',
		 'events' => array(
		 'click' => 'button:save_button:click',
		 ),
	 ),
	 array(
		 'name' => 'duplicate_button',
		 'type' => 'button',
		 'label' => 'LBL_IGNORE_DUPLICATE_AND_SAVE',
		 'primary' => true,
		 'showOn' => 'duplicate',
		 'events' => array(
		 'click' => 'button:save_button:click',
		 ),
	 ),
	 array(
		 'name' => 'select_button',
		 'type' => 'button',
		 'label' => 'LBL_SAVE_BUTTON_LABEL',
		 'primary' => true,
		 'showOn' => 'select',
		 'events' => array(
		 'click' => 'button:save_button:click',
		 ),
	 ),
	 array (
		 'type' => 'button',
		 'event' => 'button:view_document:click',
		 'name' => 'view_document',
		 'label' => 'Ver proceso UNIFIN',
		 'events' => array(
		 'click' => 'button:view_document:click',
		 ),
	 ),
	 array (
		 'type' => 'button',
		 'event' => 'button:survey_minuta:click',
		 'name' => 'survey_minuta',
		 'label' => 'Contestar Encuesta',
		 'events' => array(
		 	'click' => 'button:survey_minuta:click',
		 ),
	 ),
	 array(
		 'name' => 'sidebar_toggle',
		 'type' => 'sidebartoggle',
	 ),
 ),
);
