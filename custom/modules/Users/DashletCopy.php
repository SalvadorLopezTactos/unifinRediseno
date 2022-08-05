<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/Administration/Administration.php');

global $timedate;
global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
global $sugar_config;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

$focus = new Administration();
$focus->retrieveSettings();

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_NAME'] . ": " . "Dashlet Copy", true);
echo "\n</p>\n";
global $theme;
global $currentModule;
$theme_path = "themes/" . $theme . "/";
$image_path = $theme_path . "images/";


if (!isset($sugar_config))
{
    die('SugarCRM Configuration required. This file should be in the same path.');
}

if ($sugar_config['dbconfig']['db_type'] != 'mysql')
{
    die('This has only been tested on SugarCRM for MySQL.');
}

global $db;
$hostname = $sugar_config['dbconfig']['db_host_name'];
$username = $sugar_config['dbconfig']['db_user_name'];
$password = $sugar_config['dbconfig']['db_password'];
$database = $sugar_config['dbconfig']['db_name'];
//$db = mysql_connect($hostname, $username, $password, 1);

//if (!mysql_select_db($database, $db))
//{
//    die(mysql_error());
//}


if (isset($_POST['execute']) && $_POST['execute'] == 'Submit')
{

    if (empty($_POST['src_user']))
    {
        die('Please Go Back and select a user to source the Dashlets from.<p> <p> <a href="index.php?module=Users&action=DashletCopy&return_module=Administration" >Click here to return to Dashlet Copy</a>');
    }


    $dest_arr = array();
    foreach ($_POST as $key => $value)
    {
        if (substr($key, 0, 4) == 'chk_')
        {
            $tmp = substr($key, 4);

            if ($tmp == $_POST['src_user'])
            {
                continue;
            }

            $dest_arr[] = $tmp;

        }
    }

    if (empty($dest_arr))
    {
        die('Please Go Back and Select at least one user to copy the Dashlet configuration to. <p> <p> <a href="index.php?module=Users&action=DashletCopy&return_module=Administration" >Click here to return to Dashlet Copy</a>');
    }


    $dm = new DashletMover($_POST['src_user'], $dest_arr);

    if ($dm->getSourceDashletConfig())
    {
        $dm->updateUserDashletConfig();
        print('<pre>' . print_r($dm->err, TRUE) . '</pre>');

        die('Finished. The destination user(s) will see the new dashboard configuration on their next login. <p> <p> <a href="index.php?module=Users&action=DashletCopy&return_module=Administration" >Click here to return to Dashlet Copy</a>');
    } else
    {
        die('<pre>' . print_r($dm->err, TRUE) . '</pre>');
    }


}

echo '<script type="text/javascript" src="custom/include/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="custom/include/js/jquery.dataTables.columnFilter.js"></script>

                <script type="text/javascript">
                $(document).ready(function() {
                        $(\'#destUsers\').dataTable({
                            	"bPaginate": false,
                                "bLengthChange": false,
                                "bFilter": true,
                                "bSort": false,
                                "bInfo": false,
                                "bAutoWidth": false
                        })
                        .columnFilter({ 	sPlaceHolder: "head:before",
                        					aoColumns: [ 	null,
                        				    	 		    { type: "text" },
                                                            { type: "text" }
                        						]

                        		});
                        ;
                });
                </script>
                <link href="custom/include/css/jquery.dataTables.css" rel="stylesheet">
                ';


$dm_d = new DashletMover_UI();
$dm_d->getAllSourceUsers();
$dm_d->getAllDestUSers();
echo '<script type="text/javascript">
        function toggleChecked(status) {
            $(".checkbox").each( function() {
                $(this).attr("checked",status);
            })
        }
      </script>';
echo '<form action="index.php?module=Users&action=DashletCopy&return_module=Administration" method="post">';
echo '<table cellspacing="40"><tr><th>Source User</th><th>Destination Users</th><th&nbsp;</th></tr><tr><td valign="top">';
echo $dm_d->getSourceUsersDisplay();
echo '</td><td valign="top">';
echo $dm_d->getDestUsersDisplay();
echo '</td><td valign="top"><input type="submit" name="execute" value="Submit" onClick="return confirm(\'This action cannot be undone. Are you sure you want to continue.\');" /></td></tr></table></form>';

exit();

class DashletMover
{

    public $source_user_id = '';
    public $dest_user_ids = array();
    public $err = '';

    public $source_dashlets = array();


    public function __construct($source_user_id, Array $dest_user_ids)
    {
        $this->source_user_id = $source_user_id;
        $this->dest_user_ids = $dest_user_ids;
    }


    public function getSourceDashletConfig()
    {
        global $db;

        /**
         * @author bdekoning@levementum.com
         * @brief Querying more than just Home dashboards
         * @date 5/12/14
         */
        $countSql = "SELECT count(*) FROM dashboards WHERE assigned_user_id='{$this->source_user_id}'";
        /* END bdekoning@levementum.com 5/12/14 */

        //$result = mysql_query($sql, $db);
	    $result = $db->getOne($countSql);
        if ($result === false)
        {
            $this->err .= $db->lastDbError() . "\n";
            return false;
        } else if ($result === 0)
        {
            $this->err .= 'No Dashlet config found for this user.' . "\n";
            return false;
        }

	    /**
	     * @author kgillis@levementum.com
	     * @date   6/3/14
	     * @brief  Remove the reference to the tracker table and ensure only regular dashboards are copied.
	     */
	    $sql = "SELECT d.id, d.name, d.description, d.dashboard_module, d.metadata, d.view_name FROM dashboards d WHERE d.assigned_user_id='{$this->source_user_id}' AND d.deleted=0 AND d.dashboard_type = 'dashboard'";
	    /* END kgillis@levementum.com 6/3/14 */

	    $result = $db->query($sql);

	    //$sql = "SELECT * FROM tracker WHERE user_id='{$this->source_user_id}' AND deleted=0 ORDER BY date_modified DESC";
	    //$result = $db->fetchOne($sql);

	    //Select the dashboards
	    //$sql = "SELECT id, name, description, dashboard_module, view_name, metadata FROM dashboards WHERE assigned_user_id='{$this->source_user_id}' AND dashboard_module = 'Home' AND deleted=0 AND id='{$result['item_id']}'";
	    //$sql = "SELECT id, category, contents FROM user_preferences WHERE assigned_user_id='1' AND category IN ('Home','Dashboard')"; Used as testing
	    /*if ($result = $db->fetchOne($sql)) {
		    $this->source_dashlets[$result['dashboard_module']] = $result;
	    }*/

	    while ($row = $db->fetchByAssoc($result)) {
		    if (!isset($this->source_dashlets[$row['dashboard_module']])) {
			    $this->source_dashlets[$row['dashboard_module']] = $row;
		    }
	    }

        if (empty($this->source_dashlets))
        {
            $this->err .= 'Found no Dashlets to copy from.' . "\n";
            return false;
        }


        return true;
    }


    public function updateUserDashletConfig()
    {
        global $db;

        foreach ($this->dest_user_ids as $uid)
        {
            foreach ($this->source_dashlets as $type => $c)
            {
	            $sql = "DELETE FROM dashboards WHERE assigned_user_id='{$uid}' AND dashboard_module = '{$type}' ";
	            $db->query($sql);

	            $guid = create_guid();
	            $metadata = html_entity_decode($c['metadata'], ENT_QUOTES);
	            $insert = "
                    INSERT INTO dashboards (
                    	id,
                    	name,
                    	date_entered,
                    	date_modified,
                    	modified_user_id,
                    	created_by,
                    	description,
                    	deleted,
                    	assigned_user_id,
                    	dashboard_module,
                    	view_name,
                    	metadata
                    )
                    VALUES
                    	('{$guid}', '{$c['name']}', UTC_TIMESTAMP(), UTC_TIMESTAMP(), '{$uid}', '{$uid}', '{$c['description']}', 0, '{$uid}', '{$c['dashboard_module']}', '{$c['view_name']}', '{$metadata}')";

	            $db->query($insert);
            }




        }

    }
}


class DashletMover_UI
{
    public $err = '';

    public $user_string_arr = array();
    public $user_dash_arr = array();

    public $dest_user_arr = array();


    public function __construct()
    {

    }

    public function getAllSourceUsers()
    {
        global $db;

        $sql = "SELECT
  u.id
  , u.user_name
  , concat(u.first_name, ' ', u.last_name) full_name
FROM users u
LEFT JOIN dashboards d
  ON u.id=d.assigned_user_id
  AND d.deleted=0

WHERE
  u.deleted=0
  AND ((u.status='Active' AND u.employee_status='Active'))
  AND u.is_group=0
  AND d.dashboard_module='Home'
group by u.id
order by user_name;";
        //$result = mysql_query($sql, $db);
	    $result = $db->query($sql);
        if (!$result)
        {
            $this->err .= $db->lastDbError() . "\n";
            $this->err .= $sql . "\n";
            return false;
        }

        while ($row = $db->fetchByAssoc($result))
        {
            $this->user_string_arr[$row['id']] = $row['user_name'] . ' (' . $row['full_name'] . ')';
            $this->user_dash_arr[$row['id']] = explode(',', $row['categories']);
        }


        if (empty($this->user_string_arr))
        {
            $this->err .= 'No users with Home or Dashboard configurations found.' . "\n";
            return FALSE;
        }

        return TRUE;
    }


    public function getAllDestUsers()
    {
        global $db;

        /* add any additional fields to this query */
        $sql = "SELECT
  u.id
  , u.user_name
  , ifnull(u.title, '') title
  , concat(u.first_name, ' ', u.last_name) full_name
FROM users u
WHERE
  u.status='Active'
  AND u.deleted=0
  AND u.employee_status='Active'
  AND u.is_group=0
ORDER BY u.user_name;";

        //$result = mysql_query($sql, $db);
	    $result = $db->query($sql);
        if (!$result)
        {
            $this->err .= $db->lastDbError() . "\n";
            $this->err .= $sql . "\n";
            return false;
        }

        while ($row = $db->fetchByAssoc($result))
        {
            $this->dest_user_arr[$row['id']]['name'] = $row['user_name'] . ' (' . $row['full_name'] . ')';
            /* add any additional fields as needed */

        }


        if (empty($this->dest_user_arr))
        {
            $this->err .= 'No Destination users found.' . "\n";
            return FALSE;
        }

        return TRUE;

    }


    public function getSourceUsersDisplay()
    {
        $html = '';

        $html .= '<SELECT name="src_user" id="src_user">';
        $html .= '<option value=""> -- Select One -- </option>';
        #die('<pre>'.print_r($this->user_string_arr, TRUE).'</pre>');
        foreach ($this->user_string_arr as $value => $label)
        {
            $selected = (isset($_POST['src_user']) && $_POST['src_user'] == $value) ? ("selected=\"selected\"") : '';
            $html .= '<OPTION value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }
        $html .= '</SELECT>';

        return $html;
    }


    public function getDestUsersDisplay()
    {
        $html = '<table>';

        $html .= "<tr><td colspan='2'><input type='checkbox' class='checkall' onclick=\"toggleChecked(this.checked)\"> Select all/Deselect all</td></tr></table>
        <table cellpadding='0' cellspacing='0' border='0' class='display dataTable' id='destUsers'>
        <thead><tr><th>Select</th><th>User Name</th></tr></thead>";

        $counter = 0;
        foreach ($this->dest_user_arr as $value => $label)
        {

            $html .= "<tr>";
            $html .= "<td>";
            $id = 'chk_' . $value;
            $checked = (isset($_POST[$id])) ? ("checked") : '';
            $html .= '<input type="checkbox" class="checkbox" name="' . $id . '" id="' . $id . '" ' . $checked . '/>';
            $html .= "</td>";
            $html .= "<td>";
            $html .= $label['name'];
            $html .= "</td>";
            /* add any additional fields as needed */
            $html .= "</tr>";
        }

        $html .= "</table>";

        return $html;
    }

}

