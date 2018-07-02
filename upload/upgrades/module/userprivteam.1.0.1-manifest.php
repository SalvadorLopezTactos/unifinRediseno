<?php

	global $sugar_config;

	$upload_dir = $sugar_config['upload_dir'];
	
	$manifest = array(
	 	'acceptable_sugar_versions' => array(
	  		'regex_matches' => array(
	   			0 => '7\.*'
	  		),
	 	),
	 	'acceptable_sugar_flavors' => array(
	  		0 => 'ENT',
	  		1 => 'ULT',
	 	), 
	 	'name'	=> 'Default User Team Hook',
	 	'description'	=> 'Logic Hook for automatically setting new User team to private team.',
	 	'is_uninstallable' => true,
	 	'author'	=> 'amagana@sugarcrm.com',
	 	'published_date'	=> 'September 22, 2014',
	 	'version'	=> '1.0.1',
	 	'type'	=> 'module',
	 );
	  
	$installdefs = array(
	 'id'  => 'UserPrivTeam',
	 'mkdir' => array(
	 	array('custom/modules/Users/'),
	 ), 
	 'copy' => array(
		 array(
		  'from' => '<basepath>/NewFiles/DefaultTeam.php',
		  'to'   => 'custom/modules/Users/DefaultTeam.php',
		 ),
	),
    'logic_hooks' => array(
		  array(
		   'module'  => 'Users',
		   'hook'    => 'before_save',
		   'order'   => 96,
		   'description' => 'User Private Team',
		   'file'   => 'custom/modules/Users/DefaultTeam.php',
		   'class'   => 'DefaultTeam',
		   'function'  => 'new_user_created',
      	),
    ),    
);
   
?>