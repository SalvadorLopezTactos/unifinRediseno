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

use Sugarcrm\Sugarcrm\Security\Crypto\Blowfish;

/**
 * Outbuound email management
 * @api
 */
class OutboundEmail
{
    const TYPE_USER = 'user';
    const TYPE_SYSTEM = 'system';
    const TYPE_SYSTEM_OVERRIDE = 'system-override';

	/**
	 * Necessary
	 */
	var $db;

    protected $table_name = 'outbound_email';

    public $field_defs = array();

    protected $adminSystemFields = array(
        'mail_smtptype',
        'mail_sendtype',
        'mail_smtpserver',
        'mail_smtpport',
        'mail_smtpauth_req',
        'mail_smtpssl',
        'mail_smtpuser',
        'mail_smtppass',
    );

    protected $userSystemFields = array(
        'mail_smtptype',
        'mail_sendtype',
        'mail_smtpserver',
        'mail_smtpport',
        'mail_smtpauth_req',
        'mail_smtpssl',
    );

	/**
	 * Columns
	 */
	var $id;
	var $name;
	var $type; // user or system
	var $user_id; // owner
	var $mail_sendtype; // smtp
	var $mail_smtptype;
	var $mail_smtpserver;
	var $mail_smtpport = 25;
	var $mail_smtpuser;
	var $mail_smtppass;
	var $mail_smtpauth_req; // bool
	var $mail_smtpssl; // bool
	var $mail_smtpdisplay; // calculated value, not in DB
	var $new_with_id = FALSE;

    /**
     * @var null|OutboundEmail
     */
    protected static $sysMailerCache = null;

	/**
	 * Sole constructor
	 */
    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance();

        $dictionary = array();
        require 'metadata/outboundEmailMetaData.php';
        $this->field_defs = $dictionary['OutboundEmail']['fields'];
	}

	/**
	 * Retrieves the mailer for a user if they have overriden the username
	 * and password for the default system account.
	 *
	 * @param String $user_id
     * @return OutboundEmail|null
	 */
    public function getUsersMailerForSystemOverride($user_id)
	{
        $email = new self();
        $email->retrieveByCriteria(
            array('user_id' => $user_id, 'type' => self::TYPE_SYSTEM_OVERRIDE),
            array('name' => 'ASC')
        );

        return $email->id ? $email : null;
	}

	/**
	 * Duplicate the system account for a user, setting new parameters specific to the user.
	 *
	 * @param string $user_id
	 * @param string $user_name
	 * @param string $user_pass
     * @return OutboundEmail
	 */
	function createUserSystemOverrideAccount($user_id,$user_name = "",$user_pass = "")
	{
	    $ob = $this->getSystemMailerSettings();
	    $ob->id = create_guid();
	    $ob->new_with_id = TRUE;
	    $ob->user_id = $user_id;
        $ob->type = self::TYPE_SYSTEM_OVERRIDE;
	    $ob->mail_smtpuser = $user_name;
	    $ob->mail_smtppass = $user_pass;
	    $ob->save();

	    return $ob;
	}

	/**
	 * Determines if a user needs to set their user name/password for their system
	 * override account.
	 *
     * @param string $user_id
     * @return bool
	 */
	function doesUserOverrideAccountRequireCredentials($user_id)
	{
	    $userCredentialsReq = FALSE;
	    $sys = new OutboundEmail();
	    $ob = $sys->getSystemMailerSettings(); //Dirties '$this'

	    //If auth for system account is disabled or user can use system outbound account return false.
	    if($ob->mail_smtpauth_req == 0 || $this->isAllowUserAccessToSystemDefaultOutbound() || $this->mail_sendtype == 'sendmail')
	       return $userCredentialsReq;

	    $userOverideAccount = $this->getUsersMailerForSystemOverride($user_id);
	    if( $userOverideAccount == null || empty($userOverideAccount->mail_smtpuser) || empty($userOverideAccount->mail_smtppass) )
	       $userCredentialsReq = TRUE;

        return $userCredentialsReq;

	}

	/**
	 * Retrieves name value pairs for opts lists
	 */
	function getUserMailers($user) {
		global $app_strings;

        $stmt = $this->db->getConnection()->executeQuery(
            sprintf('SELECT * FROM %s WHERE user_id = ? AND type = ? ORDER BY name', $this->table_name),
            array($user->id, self::TYPE_USER)
        );

		$ret = array();

		$system = $this->getSystemMailerSettings();

		//Now add the system default or user override default to the response.
		if(!empty($system->id) )
		{
			if ($system->mail_sendtype == 'SMTP')
			{
			    $systemErrors = "";
                $userSystemOverride = $this->getUsersMailerForSystemOverride($user->id);

                //If the user is required to to provide a username and password but they have not done so yet,
        	    //create the account for them.
        	     $autoCreateUserSystemOverride = FALSE;
        		 if( $this->doesUserOverrideAccountRequireCredentials($user->id) )
        		 {
        		      $systemErrors = $app_strings['LBL_EMAIL_WARNING_MISSING_USER_CREDS'];
        		      $autoCreateUserSystemOverride = TRUE;
        		 }

                //Substitute in the users system override if its available.
                if($userSystemOverride != null)
        		   $system = $userSystemOverride;
        		else if ($autoCreateUserSystemOverride)
        	       $system = $this->createUserSystemOverrideAccount($user->id,"","");

			    $isEditable = ($system->type == 'system') ? FALSE : TRUE; //User overrides can be edited.

                if( !empty($system->mail_smtpserver) )
				    $ret[] = array('id' =>$system->id, 'name' => "$system->name", 'mail_smtpserver' => $system->mail_smtpdisplay,
								   'is_editable' => $isEditable, 'type' => $system->type, 'errors' => $systemErrors);
			}
			else //Sendmail
			{
				$ret[] = array('id' =>$system->id, 'name' => "{$system->name} - sendmail", 'mail_smtpserver' => 'sendmail',
								'is_editable' => false, 'type' => $system->type, 'errors' => '');
			}
		}

        while ($a = $stmt->fetch()) {
			$oe = array();
			if($a['mail_sendtype'] != 'SMTP')
				continue;

			$oe['id'] =$a['id'];
			$oe['name'] = $a['name'];
			$oe['type'] = $a['type'];
			$oe['is_editable'] = true;
			$oe['errors'] = '';
			if ( !empty($a['mail_smtptype']) )
			    $oe['mail_smtpserver'] = $this->_getOutboundServerDisplay($a['mail_smtptype'],$a['mail_smtpserver']);
			else
			    $oe['mail_smtpserver'] = $a['mail_smtpserver'];

			$ret[] = $oe;
		}

		return $ret;
	}

	/**
	 * Retrieves a cascading mailer set
	 * @param object user
	 * @param string mailer_id
	 * @return object
	 */
	function getUserMailerSettings(&$user, $mailer_id='', $ieId='') {
        $conn = $this->db->getConnection();

        $criteria = array('user_id' => $user->id);

        if (!empty($mailer_id)) {
            $criteria['id'] = $mailer_id;
        } elseif (!empty($ieId)) {
            $stmt = $conn->executeQuery("SELECT stored_options FROM inbound_email WHERE id = ?", array($ieId));
            $options = $stmt->fetchColumn();

            if ($options) {
                $options = unserialize(base64_decode($options));
                if (!empty($options['outbound_email'])) {
                    $criteria['id'] = $options['outbound_email'];
				}
			}
		}

        $this->retrieveByCriteria($criteria);
        return empty($this->id) ? $this->getSystemMailerSettings() : $this;
	}

	/**
	 * Retrieve an array containing inbound emails ids for all inbound email accounts which have
	 * their outbound account set to this object.
	 *
	 * @param SugarBean $user
	 * @return array
	 */
    public function getAssociatedInboundAccounts($user)
    {
        $stmt = $this->db->getConnection()->executeQuery(
            'SELECT id, stored_options FROM inbound_email WHERE is_personal = ? AND deleted = ? AND created_by = ?',
            array(1, 0, $user->id)
        );

        $results = array();
        while ($row = $stmt->fetch()) {
            $opts = unserialize(base64_decode($row['stored_options']));
            if( isset($opts['outbound_email']) && $opts['outbound_email'] == $this->id)
            {
                $results[] = $row['id'];
            }
		}

		return $results;
	}

	/**
	 * Retrieves a cascading mailer set
     * @param object $user
     * @param string $mailer_id
     * @param string $ieId
	 * @return object
	 */
    public function getInboundMailerSettings($user, $mailer_id = '', $ieId = '')
    {
        $emailId = null;
		if(!empty($mailer_id)) {
            $emailId = $mailer_id;
		} elseif(!empty($ieId)) {
            $stmt = $this->db->getConnection()->executeQuery(
                'SELECT stored_options FROM inbound_email WHERE id = ?',
                array($ieId)
            );
            $options = $stmt->fetchColumn();
            // its possible that its an system account
            $emailId = $ieId;
            if (!empty($options)) {
                $options = unserialize(base64_decode($options));
                if (!empty($options['outbound_email'])) {
                    $emailId = array('id' => $options['outbound_email']);
				}
			}
		}

        if (empty($emailId)) {
            $criteria = array('type' => self::TYPE_SYSTEM);
        } else {
            $criteria = array('id' => $emailId);
        }

        $this->retrieveByCriteria($criteria);

        if (empty($this->id)) {
            return $this->getSystemMailerSettings();
		}
        return $this;
	}

	/**
	 *  Determine if the user is allowed to use the current system outbound connection.
	 */
	function isAllowUserAccessToSystemDefaultOutbound()
	{
	    $allowAccess = FALSE;

	    // first check that a system default exists
        $a = $this->getSystemMailData();
		if (!empty($a)) {
		    // next see if the admin preference for using the system outbound is set
            $admin = Administration::getSettings('',TRUE);
            if (isset($admin->settings['notify_allow_default_outbound'])
                &&  $admin->settings['notify_allow_default_outbound'] == 2 )
                $allowAccess = TRUE;
        }

        return $allowAccess;
	}

	/**
	 * Retrieves the system's Outbound options
	 */
    function getSystemMailerSettings() {
        if (is_null(static::$sysMailerCache)) {
            // result puts in static cache to avoid per-request repeating calls
            $a = $this->getSystemMailData();

            if(empty($a)) {
                $this->id = "";
                $this->name = 'system';
                $this->type = 'system';
                $this->user_id = '1';
                $this->mail_sendtype = 'SMTP';
                $this->mail_smtptype = 'other';
                $this->mail_smtpserver = '';
                $this->mail_smtpport = 25;
                $this->mail_smtpuser = '';
                $this->mail_smtppass = '';
                $this->mail_smtpauth_req = 1;
                $this->mail_smtpssl = 0;
                $this->mail_smtpdisplay = $this->_getOutboundServerDisplay($this->mail_smtptype,$this->mail_smtpserver);
                $this->save();
                static::$sysMailerCache = $this;
            } else {
                static::$sysMailerCache = $this->retrieve($a['id']);
            }
        }

        if (is_object(static::$sysMailerCache)) {
            foreach(static::$sysMailerCache as $k => $v) {
                $this->$k = $v;
            }
        }

        return static::$sysMailerCache;
    }

	/**
	 * Populates this instance
	 * @param string $id
	 * @return object $this
	 */
    public function retrieve($id)
    {
        $this->retrieveByCriteria(array('id' => $id));
		return $this;
	}

    /**
     * populate current object with data from DB by criteria
     * @param array $criteria
     * @param array $order
     * @return $this
     */
    public function retrieveByCriteria(array $criteria, array $order = [])
    {
        $data = $this->getDataByCriteria($criteria, $order);
        if (!empty($data)) {
            $this->populate($data);
        }
        return $this;
    }

    /**
     * Retrieve data from DB by criteria
     * @param array $criteria
     * @param array $order
     * @throws \Doctrine\DBAL\DBALException
     * @return array|null
     */
    protected function getDataByCriteria(array $criteria, array $order = [])
    {
        $builder = $this->db->getConnection()->createQueryBuilder();
        $query = $builder->select('*')
            ->from($this->table_name);

        if (!empty($criteria)) {
            $where = $builder->expr()->andX();
            foreach ($criteria as $name => $value) {
                $where->add($builder->expr()->eq($name, $builder->createPositionalParameter($value)));
            }
            $query->where($where);
        }

        foreach ($order as $field => $direction) {
            $query->addOrderBy($field, $direction);
        }

        return $query->execute()->fetch();
    }

    /**
     * Populate object from array
     * @param array $data
     */
    protected function populate(array $data)
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }

        if (!empty($data['mail_smtppass'])) {
            $this->mail_smtppass = blowfishDecode(blowfishGetKey('OutBoundEmail'), $data['mail_smtppass']);
            $this->mail_smtppass = htmlspecialchars_decode($this->mail_smtppass, ENT_QUOTES);
        }

        $this->mail_smtpdisplay = $data['mail_smtpserver'];
        if (!empty($data['mail_smtptype'])) {
            $this->mail_smtpdisplay = $this->_getOutboundServerDisplay(
                $data['mail_smtptype'],
                $data['mail_smtpserver']
            );
        }
    }

    /**
     * return system type data from DB
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getSystemMailData()
    {
        return $this->getDataByCriteria(array('type' => self::TYPE_SYSTEM));
    }

    /**
     *  populate email from $_POST
     */
    public function populateFromPost()
    {
        foreach ($this->field_defs as $name => $def) {
            if (array_key_exists($name, $_POST)) {
                $this->$name = $_POST[$name];
            } elseif ($name != 'mail_smtppass') {
                $this->$name = '';
            }
        }
    }

	/**
	 * Generate values for saving into outbound_emails table
     * @param array $fieldDefs
	 * @return array
	 */
    protected function getValues($fieldDefs)
	{
        global $sugar_config;
	    $values = array();

        foreach ($fieldDefs as $field => $def) {
            if (isset($this->$field)) {
                if ($field == 'mail_smtppass') {
                    if (!empty($this->mail_smtppass)) {
                        $this->mail_smtppass = htmlspecialchars_decode($this->mail_smtppass, ENT_QUOTES);
                    }
                    $this->mail_smtppass = Blowfish::encode(Blowfish::getKey('OutBoundEmail'), $this->mail_smtppass);
                }
                if ($field == 'mail_smtpserver'
                    && !empty($sugar_config['bad_smtpservers'])
                    && in_array($this->mail_smtpserver, $sugar_config['bad_smtpservers'])
                ) {
                    $this->mail_smtpserver = '';
                }
                $values[$field] = $this->$field;
            }
	    }
	    return $values;
	}

	/**
	 * saves an instance
	 */
	function save() {
	    if( empty($this->id) ) {
	        $this->id = create_guid();
			$this->new_with_id = true;
		}

        $values = $this->getValues($this->field_defs);

		if($this->new_with_id) {
            $this->db->insertParams($this->table_name, $this->field_defs, $values);
		} else {
            $this->db->updateParams($this->table_name, $this->field_defs, $values, array('id' => $this->id));
		}

        $this->resetSystemMailerCache();
		return $this;
	}

	/**
	 * Saves system mailer.  Presumes all values are filled.
	 */
	function saveSystem() {
        $a = $this->getSystemMailData();

		if(empty($a)) {
			$a['id'] = ''; // trigger insert
		}

		$this->id = $a['id'];
		$this->name = 'system';
		$this->type = 'system';
		$this->user_id = '1';
		$this->save();

        // If there is no system-override record for the System User - Create One using the System Mailer Configuration
        // If there already is one, update the smtpuser and smtppass
        //      If User Access To System Default Outbound is enabled
        //   Or If SMTP Auth is required And Either the smtpuser or smtppass is empty
        $oe_system = $this->getSystemMailerSettings();
        $oe_override = $this->getUsersMailerForSystemOverride($this->user_id);
        if ($oe_override == null) {
            $this->createUserSystemOverrideAccount($this->user_id, $oe_system->mail_smtpuser, $oe_system->mail_smtppass);
        }
        else if ($this->doesUserOverrideAccountRequireCredentials($this->user_id) ||
                 $this->isAllowUserAccessToSystemDefaultOutbound() ||
                   ( $oe_override->mail_smtpauth_req &&
                     $oe_override->mail_smtpserver == $oe_system->mail_smtpserver &&
                     ( empty($oe_override->mail_smtpuser) || ($oe_system->mail_smtpuser==$oe_override->mail_smtpuser) || empty($oe_override->mail_smtppass))) ) {
            $this->updateAdminSystemOverrideAccount();
        }

        $this->updateUserSystemOverrideAccounts();
        $this->resetSystemMailerCache();
	}

    /**
     * Update the Admin's user system override account with the system information if anything has changed.
     */
    function updateAdminSystemOverrideAccount()
    {
        $this->updateSystemOverride($this->adminSystemFields, array('user_id' => 1));
    }

    /**
	 * Update the user system override accounts with the system information if anything has changed.
	 */
	function updateUserSystemOverrideAccounts()
	{
        $this->updateSystemOverride($this->userSystemFields);
    }

    /**
     * update system override settings
     * @param array $fields
     * @param array $where
     * @return bool
     */
    protected function updateSystemOverride(array $fields, array $where = array())
    {
        $where['type'] = self::TYPE_SYSTEM_OVERRIDE;
        return $this->db->updateParams(
            $this->table_name,
            $this->field_defs,
            $this->getValues(array_flip($fields)),
            $where
        );
    }

	/**
	 * Deletes an instance
     *
     * @return bool
	 */
	function delete() {
		if(empty($this->id)) {
			return false;
		}

        $this->db->getConnection()->delete($this->table_name, array('id' => $this->id));

        return true;
	}

	private function _getOutboundServerDisplay(
	    $smtptype,
	    $smtpserver
	    )
	{
	    global $app_strings;

	    switch ($smtptype) {
        case "yahoomail":
            return $app_strings['LBL_SMTPTYPE_YAHOO']; break;
        case "gmail":
            return $app_strings['LBL_SMTPTYPE_GMAIL']; break;
        case "exchange":
            return $smtpserver . ' - ' . $app_strings['LBL_SMTPTYPE_EXCHANGE']; break;
        default:
            return $smtpserver; break;
        }
	}

	/**
	 * Get mailer for current user by name
	 * @param User $user
	 * @param string $name
	 * @return OutboundEmail|false
	 */
	public function getMailerByName($user, $name)
	{
	    if($name == "system" && !$this->isAllowUserAccessToSystemDefaultOutbound()) {
	        $oe = $this->getUsersMailerForSystemOverride($user->id);
	        if(!empty($oe) && !empty($oe->id)) {
	            return $oe;
	        }
            else  {
                return $this->getSystemMailerSettings();
            }
	    }
        $this->retrieveByCriteria(array('user_id' => $user->id, 'name' => $name));
        return $this->id ? $this : false;
	}

    /**
     * Reset system mailer settings cache
     */
    public function resetSystemMailerCache()
    {
        static::$sysMailerCache = null;
    }
}
