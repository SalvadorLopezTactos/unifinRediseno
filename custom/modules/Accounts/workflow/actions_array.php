<?php
//Workflow Action Meta Data Arrays 
$action_meta_array = array ( 

'Accounts0_action0' => 

array ( 

		 'action_type' => 'new', 
		 'action_module' => 'Tasks', 
		 'rel_module' => '', 
		 'rel_module_type' => 'all', 
	 'basic' => array ( 

		 'name' => stripslashes('Prospecto no interesado'),
		 'status' => stripslashes('Not Started'),
		 'priority' => stripslashes('High'),
	 ), 

	 'basic_ext' => array ( 

	 ), 

	 'advanced' => array ( 

	 'assigned_user_id' => array ( 

			 'value' => stripslashes('assigned_user_id'),
			 'ext1' => 'Self', 
			 'ext2' => '', 
			 'ext3' => '', 
			 'adv_type' => 'exist_user', 
	 ), 

	 ), 

), 

'Accounts0_action1' => 

array ( 

		 'action_type' => 'new', 
		 'action_module' => 'Tasks', 
		 'rel_module' => '', 
		 'rel_module_type' => 'all', 
	 'basic' => array ( 

		 'status' => stripslashes('Not Started'),
		 'priority' => stripslashes('High'),
		 'name' => stripslashes('Prospecto no interesado'),
	 ), 

	 'basic_ext' => array ( 

	 ), 

	 'advanced' => array ( 

	 'assigned_user_id' => array ( 

			 'value' => stripslashes('assigned_user_id'),
			 'ext1' => 'Manager', 
			 'ext2' => '', 
			 'ext3' => '', 
			 'adv_type' => 'exist_user', 
	 ), 

	 ), 

), 

); 

 

?>