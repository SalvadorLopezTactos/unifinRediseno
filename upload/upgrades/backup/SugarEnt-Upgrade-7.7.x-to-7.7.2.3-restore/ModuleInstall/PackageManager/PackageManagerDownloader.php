<?php
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
define('PACKAGE_MANAGER_DOWNLOAD_SERVER', 'https://depot.sugarcrm.com/depot/');
define('PACKAGE_MANAGER_DOWNLOAD_PAGE', 'download.php');
class PackageManagerDownloader{

	/**
	 * Using curl we will download the file from the depot server
	 *
	 * @param session_id		the session_id this file is queued for
	 * @param file_name			the file_name to download
	 * @param save_dir			(optional) if specified it will direct where to save the file once downloaded
	 * @param download_sever	(optional) if specified it will direct the url for the download
	 *
	 * @return the full path of the saved file
	 */
	function download($session_id, $file_name, $save_dir = '', $download_server = ''){
		if(empty($save_dir)){
			$save_dir = "upload://";
		}
		if(empty($download_server)){
			$download_server = PACKAGE_MANAGER_DOWNLOAD_SERVER;
		}
		$download_server .= PACKAGE_MANAGER_DOWNLOAD_PAGE;
		$ch = curl_init($download_server . '?filename='. $file_name);
		$fp = sugar_fopen($save_dir . $file_name, 'w');
		curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID='.$session_id. ';');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		return $save_dir . $file_name;
	}
}
?>