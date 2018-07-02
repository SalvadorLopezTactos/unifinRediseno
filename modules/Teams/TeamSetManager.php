<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

define('TEAM_SET_CACHE_KEY', 'TeamSetsCache');
define('TEAM_SET_MD5_CACHE_KEY', 'TeamSetsMD5Cache');

class TeamSetManager {

	private static $instance;
	private static $_setHash = array();

	/**
	 * Constructor for TrackerManager.  Declared private for singleton pattern.
	 *
	 */
	private function __construct() {}

	/**
	 * getInstance
	 * Singleton method to return static instance of TrackerManager
	 * @returns static TrackerManager instance
	 */
	static function getInstance(){
	    if (!isset(self::$instance)) {
	        self::$instance = new TeamSetManager();
			//Set global variable for tracker monitor instances that are disabled
	        self::$instance->setup();
	    } // if
	    return self::$instance;
	}

	/**
	 * Add a team_set_id and module combination to the hash for later flushing to the db.
	 *
	 * @param $team_set_id - GUID of the team_set_id
	 * @param $module      - string
	 */
	public static function add($team_set_id, $table_name){
		if(empty(self::$_setHash[$team_set_id]) || empty(self::$_setHash[$team_set_id][$table_name])){
			self::$_setHash[$team_set_id][] = $table_name;
		}
	}

	/**
	 * Go through each of the team_sets_modules and find sets that are no longer in use
	 *
	 */
	public static function cleanUp(){
		$teamSetModule = BeanFactory::newBean('TeamSetModules');
		//maintain a list of the team set ids we would like to remove
		$setsToRemove = array();
		$setsToKeep = array();

        $conn = DBManagerFactory::getConnection();

        $query = 'SELECT team_set_id, module_table_name FROM team_sets_modules WHERE team_sets_modules.deleted = 0';
        $stmt = $conn->executeQuery($query);

        while (($tsmRow = $stmt->fetch())) {
			//pull off the team_set_id and module and run a query to see if we find if the module is still using this team_set
			//of course we have to be careful not to remove a set before we have gone through all of the modules containing that
			//set otherwise.
			$module_table_name = $tsmRow['module_table_name'];
			$team_set_id = $tsmRow['team_set_id'];
			//if we have a user_preferences table then we do not need to check the db.
			$pos = strpos($module_table_name, 'user_preferences');
			if ($pos !== false) {
				$tokens = explode('-', $module_table_name);
				if(count($tokens) >= 3){
					//we did find that this team_set was going to be removed from user_preferences
                    $query = 'SELECT contents FROM user_preferences WHERE category = ? AND deleted = 0';
                    $prefStmt = $conn->executeQuery($query, array($tokens[1]));

                    while (($userPrefRow = $prefStmt->fetch())) {
						$prefs = unserialize(base64_decode($userPrefRow['contents']));
						$team_set_id = SugarArray::staticGet($prefs, implode('.', array_slice($tokens, 2)));
						if(!empty($team_set_id)){
							//this is the team set id that is being used in user preferences we have to be sure to not remove it.
							$setsToKeep[$team_set_id] = true;
						}
					}//end while
				}//fi
			}else{
                $moduleRecordsExist = self::doesRecordWithTeamSetExist($module_table_name, $team_set_id);
                
                if ($moduleRecordsExist) {
                    $setsToKeep[$team_set_id] = true;
                } else {
                    $setsToRemove[$team_set_id] = true;
                }
			}
		}

		//compute the difference between the sets that have been designated to remain and those set to remove
		$arrayDiff = array_diff_key($setsToRemove, $setsToKeep);

		//now we have our list of team_set_ids we would like to remove, let's go ahead and do it and remember
		//to update the TeamSetModule table.
		foreach($arrayDiff as $team_set_id => $key){
            //1) remove from team_sets_teams
            $conn->delete('team_sets_teams', array(
                'team_set_id' => $team_set_id,
            ));

            //2) remove from team_sets
            $conn->delete('team_sets', array(
                'id' => $team_set_id,
            ));

            //3) remove from team_sets_modules
            $conn->delete($teamSetModule->table_name, array(
                'team_set_id' => $team_set_id,
            ));
		}

		//clear out the cache
		self::flushBackendCache();
	}

	/**
	 * Save the data in the hash to the database using TeamSetModule object
	 *
	 */
	public static function save(){
		//if this entry is set in the config file, then store the set
		//and modules in the team_set_modules table
        if (!isset($GLOBALS['sugar_config']['enable_team_module_save'])
            || !empty($GLOBALS['sugar_config']['enable_team_module_save'])) {
			foreach(self::$_setHash as $team_set_id => $table_names){
				$teamSetModule = BeanFactory::newBean('TeamSetModules');
				$teamSetModule->team_set_id = $team_set_id;

				foreach($table_names as $table_name){
					$teamSetModule->module_table_name = $table_name;
					//remove the id so we do not think this is an update
					$teamSetModule->id = '';
					$teamSetModule->save();
				}
			}
		}
	}

    /**
     * Check if one or more records attached to a team still exist in the database
     *
     * @param string $moduleTableName Module table name
     * @param string $teamSetId       TeamSet id
     * @param string $beanId          Record to exclude from search
     * @return boolean
     */
    public static function doesRecordWithTeamSetExist($moduleTableName, $teamSetId, $beanId = null)
    {
        $whereStmt = 'team_set_id = ? AND deleted = 0';
        $params = array($teamSetId);

        if ($beanId) {
            $whereStmt .= ' AND id != ?';
            $params[] = $beanId;
        }
        $connection = DBManagerFActory::getConnection();
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->select('id')
            ->from($moduleTableName)
            ->where($whereStmt);

        // set the maximum number of records to be 1 to avoid scanning extra records in database
        $query = $queryBuilder->setMaxResults(1)->getSQL();
        $numRows = $connection->executeQuery($query, $params)->rowCount();
        return ($numRows == 1);
    }

    /**
     * Removes TeamSet module if no records exist
     *
     * @param SugarBean $focus
     * @param String    $teamSetid Team set to remove
     */
    public static function removeTeamSetModule($focus, $teamSetId)
    {
        if (empty($teamSetId)) {
            return;
        }
        
        if (self::doesRecordWithTeamSetExist($focus->table_name, $teamSetId, $focus->id)) {
            return;
        }

        $query = 'DELETE FROM team_sets_modules WHERE team_set_id = ? AND module_table_name = ?';
        DBManagerFactory::getConnection()
            ->executeQuery($query, array($teamSetId, $focus->table_name));

        self::flushBackendCache();
    }

	/**
	 * The above method "save" will flush the entire cache, saveTeamSetModule will just save one entry.
	 *
	 * @param guid $teamSetId	the GUID of the team set id we wish to save
	 * @param string $tableName	the corresponding table name
	 */
	public static function saveTeamSetModule($teamSetId, $tableName){
		//if this entry is set in the config file, then store the set
		//and modules in the team_set_modules table
        if (!isset($GLOBALS['sugar_config']['enable_team_module_save'])
            || !empty($GLOBALS['sugar_config']['enable_team_module_save'])) {
			$teamSetModule = BeanFactory::newBean('TeamSetModules');
			$teamSetModule->team_set_id = $teamSetId;
			$teamSetModule->module_table_name = $tableName;
			$teamSetModule->save();
		}
	}

	public static function getFormattedTeamNames($teams_arr=array()) {
		//Add a safety check (in the event that team_set_id is not set (maybe perhaps from manual SQL or failed unit tests)
		if(!is_array($teams_arr)) {
		   return array();
		}

		//now format the returned values relative to how the user has their locale
    	$teams = array();
	    foreach($teams_arr as $team){
	    	$display_name = Team::getDisplayName($team['name'], $team['name_2']);
            $teams[] = array(
                'id' => (string)$team['id'],
                'display_name' => $display_name,
                'name' => $team['name'],
                'name_2' => $team['name_2'],
            );
		}
		return $teams;
	}

	/**
	 * Check if we have an md5 relationship to a team set id
	 *
	 * @param unknown_type $md5
	 * @return unknown
	 */
	public static function getTeamSetIdFromMD5($md5){
		$teamSetsMD5 = sugar_cache_retrieve(TEAM_SET_MD5_CACHE_KEY);
        if ( $teamSetsMD5 != null && !empty($teamSetsMD5[$md5])) {
            return $teamSetsMD5[$md5];
        }

	 	if ( file_exists($cachefile = sugar_cached('modules/Teams/TeamSetMD5Cache.php') )) {
            require_once($cachefile);
            sugar_cache_put(TEAM_SET_MD5_CACHE_KEY,$teamSetsMD5);
            if(!empty($teamSetsMD5[$md5])){
            	return $teamSetsMD5[$md5];
            }
        }
        return null;
	}

	public static function addTeamSetMD5($team_set_id, $md5){
		$teamSetsMD5 = sugar_cache_retrieve(TEAM_SET_MD5_CACHE_KEY);
		if(empty($teamSetsMD5) || !is_array($teamSetsMD5)){
			$teamSetsMD5 = array();
		}
        if ( $teamSetsMD5 != null && !empty($teamSetsMD5[$md5])) {
            return;
        }

	 	if ( file_exists($cachefile = sugar_cached('modules/Teams/TeamSetMD5Cache.php')) ) {
            require_once($cachefile);
            sugar_cache_put(TEAM_SET_MD5_CACHE_KEY,$teamSetsMD5);
            if(!empty($teamSetsMD5[$md5])){
            	return;
            }
        }

        $teamSetsMD5[$md5] = $team_set_id;
        sugar_cache_put(TEAM_SET_MD5_CACHE_KEY,$teamSetsMD5);

        if ( ! file_exists($cachefile) ) {
            mkdir_recursive(dirname($cachefile));
        }

        if(sugar_file_put_contents_atomic($cachefile, "<?php\n\n".'$teamSetsMD5 = '.var_export($teamSetsMD5,true).";\n ?>") === false)
        {
            $GLOBALS['log']->error("File $cachefile could not be written");
        }
	}

	/**
	 * Retrieve a list of team associated with a set
	 *
	 * @param $team_set_id string
	 * @return array of teams array('id', 'name');
	 */
	public static function getUnformattedTeamsFromSet($team_set_id){
		if(empty($team_set_id)) return array();
		// Stored in a cache somewhere
        $teamSets = sugar_cache_retrieve(TEAM_SET_CACHE_KEY);
        if ( $teamSets != null && !empty($teamSets[$team_set_id])) {
            return $teamSets[$team_set_id];
        }

        // Already stored in a file
        if ( file_exists($cachefile = sugar_cached('modules/Teams/TeamSetCache.php')) ) {
            require_once($cachefile);

            if(!empty($teamSets[$team_set_id])){
            	sugar_cache_put(TEAM_SET_CACHE_KEY,$teamSets);
            	return $teamSets[$team_set_id];
            }
        }


		$teamSet = BeanFactory::newBean('TeamSets');
		$teams = $teamSet->getTeams($team_set_id);
		$team_names = array();
		foreach($teams as $id => $team){
			$team_names[$id] = $team->name;
		}
		asort($team_names);
		if(!is_array($teamSets)){
			$teamSets = array();
		}
        foreach ($team_names as $team_id => $team_name) {
            $tm = $teams[$team_id];
            $teamSets[$team_set_id][] = array(
                'id' => (string) $team_id,
                'name' => $team_name,
                'name_2' => $tm->name_2,
            );
        }

	 	sugar_cache_put(TEAM_SET_CACHE_KEY,$teamSets);

        if ( ! file_exists($cachefile) ) {
            mkdir_recursive(dirname($cachefile));
        }

        if(sugar_file_put_contents_atomic($cachefile, "<?php\n\n".'$teamSets = '.var_export($teamSets,true).";\n ?>") === false)
        {
            $GLOBALS['log']->error("File $cachefile could not be written");
        }

        return isset($teamSets[$team_set_id])?$teamSets[$team_set_id]:'';
	}

	/**
	 * Retrieve a list of team associated with a set for display purposes
	 *
	 * @param $team_set_id string
	 * @return array of teams array('id', 'name');
	 */
	public static function getTeamsFromSet($team_set_id){
		if(empty($team_set_id)) return array();
		return self::getFormattedTeamNames(self::getUnformattedTeamsFromSet($team_set_id));
	}

    /**
     * Return a formatted list of teams with badges.
     *
     * @param $focus
     * @param bool|false $forDisplay
     * @return mixed|string|void
     */
    public static function getFormattedTeamsFromSet($focus, $forDisplay = false)
    {
        $result = array();
        $isTBAEnabled = TeamBasedACLConfigurator::isEnabledForModule($focus->module_dir);

        $team_set_id = $focus->team_set_id ? $focus->team_set_id : $focus->team_id;
        $teams = self::getTeamsFromSet($team_set_id);

        $selectedTeamIds = array();
        if ($isTBAEnabled && !empty($focus->acl_team_set_id)) {
            $selectedTeamIds = array_map(function ($el) {
                return $el['id'];
            }, TeamSetManager::getTeamsFromSet($focus->acl_team_set_id));
        }

        foreach ($teams as $key => $row) {
            $isPrimaryTeam = false;
            $row['title'] = $forDisplay ?
                $row['display_name'] :
                (!empty($row['name']) ? $row['name'] : $row['name_2']);

            if (!empty($focus->team_id) && $row['id'] == $focus->team_id) {
                $row['badges']['primary'] = $isPrimaryTeam = true;
            }

            if ($isTBAEnabled && in_array($row['id'], $selectedTeamIds)) {
                $row['badges']['selected'] = $hasBadge = true;
            }

            if ($isPrimaryTeam) {
                array_unshift($result, $row);
            } else {
                array_push($result, $row);
            }
        }

        $detailView = new Sugar_Smarty();
        $detailView->assign('teams', $result);
        return $detailView->fetch('modules/Teams/tpls/DetailView.tpl');
    }

	/**
	 * Return a comma delimited list of teams for display purposes
	 *
     * @param string $team_set_id
     * @param string $primary_team_id
	 * @param boolean $for_display
	 * @return string
	 */
	public static function getCommaDelimitedTeams($team_set_id, $primary_team_id = '', $for_display = false){
        $team_set_id = $team_set_id?$team_set_id:$primary_team_id;
		$teams = self::getTeamsFromSet($team_set_id);
		$value = '';
	    $primary = '';
	   	foreach($teams as $row){
	        if(!empty($primary_team_id) && $row['id'] == $primary_team_id){
	        	  if($for_display){
	        	  	 $primary = ", {$row['display_name']}";
	        	  }else{
	        	  	$primary = ", ".(!empty($row['name']) ? $row['name'] : $row['name_2']);
	        	  }
	        }else{
	        	if($for_display){
	        		$value .= ", {$row['display_name']}";
	        	}else{
	   				$value .= ", ".(!empty($row['name']) ? $row['name'] : $row['name_2']);
	        	}
	        }
	   	}
	   	$value = $primary.$value;
	   	return substr($value, 2);
	}

	/**
	 * clear out the cache
	 *
	 */
	public static function flushBackendCache( ) {
        // This function will flush the cache files used for the module list and the link type lists

        // TeamSetCache
        sugar_cache_clear(TEAM_SET_CACHE_KEY);
        $cachefile = sugar_cached('modules/Teams/TeamSetCache.php');
        if(sugar_file_put_contents_atomic($cachefile, "<?php\n\n".'$teamSets = array();'."\n ?>") === false) {
            $GLOBALS['log']->error("File $cachefile could not be written (flush)");
        }

        // TeamSetMD5Cache
        sugar_cache_clear(TEAM_SET_MD5_CACHE_KEY);
        $cachefile = sugar_cached('modules/Teams/TeamSetMD5Cache.php');
        if(sugar_file_put_contents_atomic($cachefile, "<?php\n\n".'$teamSetsMD5 = array();'."\n ?>") === false) {
            $GLOBALS['log']->error("File $cachefile could not be written (flush)");
        }
    }

    /**
     * Given a particular team id, remove the team from all team sets that it belongs to
     *
     * @param string $team_id The team's id to remove from the team sets
     * @return Array of team_set ids that were affected
     */
    public static function removeTeamFromSets($team_id)
    {
        $conn = DBManagerFactory::getConnection();

        $query = 'SELECT tsm.team_set_id, tsm.module_table_name
FROM team_sets_modules tsm
INNER JOIN team_sets_teams tst
ON tsm.team_set_id = tst.team_set_id
WHERE tst.team_id = ?';
        $stmt = $conn->executeQuery($query, array($team_id));

        $affectedTeamSets = array();
        $team_set_id_modules = array();

        while (($row = $stmt->fetch())) {
    		  $team_set_id_modules[$row['team_set_id']][] = $row['module_table_name'];
    	}

        $teamSet = BeanFactory::newBean('TeamSets');

        foreach ($team_set_id_modules as $team_set_id => $tables) {
            $teamSet->id = $team_set_id;
            $teamSet->removeTeamFromSet($team_id);

            // Now check if the new team_md5 value already exists.  If it does, we have to go and
            // update all the records that to use an existing team_set_id and get rid of this team set since
            // it is essentially a duplicate
            $query = 'SELECT id FROM team_sets WHERE team_md5 = ? AND id != ?';
            $stmt = $conn->executeQuery($query, array($teamSet->team_md5, $teamSet->id));

            while (($existing_team_set_id = $stmt->fetchColumn())) {
                //Update the records
                foreach ($tables as $table) {
                    $conn->update($table, array(
                        'team_set_id' => $existing_team_set_id,
                    ), array(
                        'team_set_id' => $teamSet->id,
                    ));
                }

                //Remove the team set entry
                $conn->delete('team_sets', array(
                    'id' => $teamSet->id,
                ));

                //Remove the team_sets_teams entries
                $conn->delete('team_sets_teams', array(
                    'team_set_id' => $teamSet->id,
                ));

                //Remove the team_sets_modules entries
                $conn->delete('team_sets_modules', array(
                    'team_set_id' => $teamSet->id,
                ));
            }

    	      $affectedTeamSets[$team_set_id] = $row[$team_set_id];
    	}

	    return $affectedTeamSets;
    }
}
