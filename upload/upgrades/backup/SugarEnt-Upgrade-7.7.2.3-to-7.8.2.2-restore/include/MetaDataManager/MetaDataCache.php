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

/**
 * Assists in modifying the Metadata in places that the core cannot handle at this time.
 *
 */
class MetaDataCache
{
    protected $db;

    /**
     * Name of the cache table used to store metadata cache data
     * @var string
     */
    protected static $cacheTable = "metadata_cache";

    protected static $isCacheEnabled = true;

    public function __construct(DBManager $db)
    {
        $this->db = $db;
    }

    public function get($key)
    {
        return $this->getFromCacheTable($key);
    }

    public function set($key, $data)
    {
        if ($data == null) {
            return $this->removeFromCacheTable($key);
        } else {
            return $this->storeToCacheTable($key, $data);
        }
    }

    public function getKeys()
    {
        $ret = array();
        $result = $this->db->query('SELECT type FROM ' . static::$cacheTable);
        while ($row = $this->db->fetchByAssoc($result)) {
            $ret[] = $row['type'];
        }

        return $ret;
    }

    public function reset()
    {
        $this->clearCacheTable();
    }

    /**
     * Checks if metadata cache is operable with current database schema
     *
     * This check should be made during upgrades when the source code has been upgraded by the moment,
     * but database schema hasn't yet.
     *
     * @return bool
     */
    public static function isCacheOperable()
    {
        return DBManagerFactory::getInstance()->tableExists(static::$cacheTable);
    }

    /**
     * Used to cache metadata responses in the database
     *
     * @param String $key key for data stored in the cache table
     *
     * @return mixed|null Value pulled from cache table blob if found.
     */
    protected function getFromCacheTable($key)
    {
        $result = null;
        //During install/setup, this function might get called before the DB is setup.
        if (!empty($this->db)) {
            $sqlResult = $this->db->query("SELECT id, data FROM " . static::$cacheTable . " WHERE type="
                . $this->db->quoted($key) . " ORDER BY date_modified DESC");

            if (($row = $this->db->fetchByAssoc($sqlResult))) {
                $cacheResult = $row['data'];
            }
            if ($row){
                //If we have more than one entry for the same key, we need to remove the duplicate entries.
                while (($row = $this->db->fetchByAssoc($sqlResult))) {
                    $this->db->query("DELETE FROM " . static::$cacheTable . " WHERE id=" . $this->db->quoted($row['id']));
                }
            }

            if (!empty($cacheResult)) {
                try {
                    $result = unserialize(gzinflate(base64_decode($cacheResult)));
                } catch (Exception $e) {
                    $GLOBALS['log']->error("Exception when decompressing metadata hash for $key:" . $e->getMessage());
                }
            }
        }

        return $result;
    }

    /**
     * Stores data in the cache table compressed and serialized. Any PHP data is valid.
     *
     * @param String $key key to store data with
     * @param mixed  $data Data to store in the cache table blob
     *
     * @return bool
     */
    protected function storeToCacheTable($key, $data)
    {
        if (!empty($this->db)) {
            try {
                $encoded = base64_encode(gzdeflate(serialize($data)));
            } catch (Exception $e) {
                $GLOBALS['log']->fatal("Exception when compressing metadata for $key:" . $e->getMessage());

                return false;
            }

            $id = null;
            $result = $this->db->query("SELECT id FROM " . static::$cacheTable . " WHERE type="
                            . $this->db->quoted($key) . " ORDER BY date_modified DESC");

            if (($row = $this->db->fetchByAssoc($result)) && !empty($row['id'])) {
                $id = $row['id'];
                //If we have more than one entry for the same key, we need to remove the duplicate entries.
                while (($row = $this->db->fetchByAssoc($result))) {
                    $this->db->query("DELETE FROM " . static::$cacheTable . " WHERE id=" . $this->db->quoted($row['id']));
                }
            }

            $values = array(
                'id' => $id,
                'type' => $key,
                'data' => $encoded,
                'date_modified' => TimeDate::getInstance()->nowDb(),
                'deleted' => 0,
            );

            $fields = array();
            foreach ($this->getFields() as $field) {
                $fields[$field['name']] = $field;
            }
            $this->db->commit();
            if (empty($values['id'])) {
                $values['id'] = create_guid();
                $return = $this->db->insertParams(
                    static::$cacheTable,
                    $fields,
                    $values,
                    null,
                    true,
                    $this->db->supports('prepared_statements')
                );
            } else {
                $return = $this->db->updateParams(
                    static::$cacheTable,
                    $fields,
                    $values,
                    array('id' => $values['id']),
                    null,
                    true,
                    $this->db->supports('prepared_statements')
                );
            }
            $this->db->commit();

            return $return;
        }

        return false;
    }

    /**
     * Remove an entry in the cache table.
     *
     * @param String $key
     *
     * @return mixed
     */
    protected function removeFromCacheTable($key)
    {
        if (!self::$isCacheEnabled) {
            return true;
        }

        return $this->db->query("DELETE FROM " . static::$cacheTable . " WHERE type=" . $this->db->quoted($key));
    }

    /**
     * Clears all entries in the cache table.
     */
    protected static function clearCacheTable()
    {
        if (!self::$isCacheEnabled) {
            return true;
        }

        $db = DBManagerFactory::getInstance();
        $db->commit();
        $db->query($db->truncateTableSQL(static::$cacheTable));
        $db->commit();
    }

    public function clearKeysLike($key) {
        return $this->db->query("DELETE FROM " . static::$cacheTable . " WHERE type LIKE " . $this->db->quoted($key . '%'));
    }


    /**
     * Returns array of fields of static::$cacheTable
     *
     * @return array
     */
    protected function getFields()
    {
        global $dictionary;
        include_once 'modules/TableDictionary.php';

        $fields = array();
        if (!empty($dictionary[static::$cacheTable]['fields'])) {
            $fields = $dictionary[static::$cacheTable]['fields'];
        }

        return $fields;
    }
}
