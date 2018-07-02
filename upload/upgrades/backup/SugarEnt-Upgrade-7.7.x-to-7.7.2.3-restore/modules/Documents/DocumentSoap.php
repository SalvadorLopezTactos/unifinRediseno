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


require_once('include/upload_file.php');

class DocumentSoap{
var $upload_file;
	public function DocumentSoap(){
        self::__construct();
    }

    public function __construct() {
		$this->upload_file = new UploadFile('filename_file');
	}

	function saveFile($document, $portal = false){
        global $sugar_config;

        $focus = BeanFactory::getBean('Documents');

                if($portal){
                        $focus->disable_row_level_security = true;
                }


        if(!empty($document['id'])){
                $focus->retrieve($document['id']);
                if(empty($focus->id)) {
                    return '-1';
                }
        }else{
                return '-1';
        }

        if(!empty($document['file'])){
                $decodedFile = base64_decode($document['file']);
                $this->upload_file->set_for_soap($document['filename'], $decodedFile);

                $ext_pos = strrpos($this->upload_file->stored_file_name, ".");
                $this->upload_file->file_ext = substr($this->upload_file->stored_file_name, $ext_pos + 1);
                if (in_array($this->upload_file->file_ext, $sugar_config['upload_badext'])) {
                        $this->upload_file->stored_file_name .= ".txt";
                        $this->upload_file->file_ext = "txt";
                }

                $revision = BeanFactory::getBean('DocumentRevisions');
				$revision->filename = $this->upload_file->get_stored_file_name();
          		$revision->file_mime_type = $this->upload_file->getMimeSoap($revision->filename);
				$revision->file_ext = $this->upload_file->file_ext;
				//$revision->document_name = ;
				$revision->revision = $document['revision'];
				$revision->document_id = $document['id'];
				$revision->save();

               	$focus->document_revision_id = $revision->id;
               	$focus->save();
                $return_id = $revision->id;
                $this->upload_file->final_move($revision->id);
        }else{
                return '-1';
        }
        return $return_id;
	}
}
?>