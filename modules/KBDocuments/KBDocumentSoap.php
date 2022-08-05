<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once('include/upload_file.php');

class KBDocumentSoap {
var $upload_file;

function KBDocumentSoap(){
	$this->upload_file = new UploadFile('uploadfile');
}

function retrieveFile($id){
	$filepath = $this->upload_file->get_upload_path($id);
	$s = '';
	if(file_exists($filepath)){
		
		$s = file_get_contents($filepath);
		return base64_encode($s);
	}
	return -1;
}

/**
 * retrieveFileName
 * This is a function to return the true file name value as listed
 * in the document_revisions table for the given id.
 * @param The id field of the row in document_revisions table to fetch file name for
 * @return The String file name or id if not found
 */
function retrieveFileName($id) {	
    
    $query = "select filename from document_revisions where id = '$id'";
    $bean = BeanFactory::getBean('KBDocuments');
    $result = $bean->db->query($query);
    if(isset($result)) {
       $row = $bean->db->fetchByAssoc($result);
       return isset($row) ? $row['filename'] : $id;	
    }
    return $id;
}

}

?>