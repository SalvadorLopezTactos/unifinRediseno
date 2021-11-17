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

namespace Sugarcrm\Sugarcrm\DbArchiver;

use Doctrine\DBAL\Connection;
use RuntimeException;

/**
 * Class DbArchiver
 */
class DbArchiver
{
    /**
     * Archive Limit value
     */
    private const ARCHIVE_LIMIT = 10000;

    /**
     * @var string
     */
    private $module;

    /**
     * @var SugarBean
     */
    private $bean;

    /**
     * @var string
     */
    private $cstmArchiveTableName;

    /**
     * DbArchiver constructor.
     * @param $module
     */

    /**
     * Array of ids that completed the archival process
     * @var array
     */
    private $rowsArchived = [];

    /**
     * Array of ids that completed the archival process for custom tables
     * @var array
     */
    private $cstmRowsArchived = [];

    /**
     * @var Connection
     */
    private $conn;

    public function __construct(string $module)
    {
        // set the active module for this instance of DbArchiver
        $this->module = $module;
    }

    /**
     * Returns the active table SugarBean
     * @return \SugarBean
     * @throws RuntimeException
     */
    public function getBean() : ?\SugarBean
    {
        if (is_null($this->bean)) {
            $bean = \BeanFactory::newBean($this->module);
            if (is_null($bean)) {
                throw new RuntimeException('Could not load bean from module: ' . $this->module);
            }
            $this->bean = $bean;
        }
        return $this->bean;
    }

    /**
     * Returns the module name
     * @return string
     */
    public function getModule() : ?string
    {
        return $this->module;
    }

    /**
     * Returns whether the module has a custom table associated with it or not
     * @return bool
     * @throws RuntimeException
     */
    private function hasCustomTable()
    {
        return $this->getBean()->hasCustomFields();
    }

    /**
     * Returns whether there module has an audit table associated with it or not
     * @return bool
     * @throws RuntimeException
     */
    private function hasAuditTable()
    {
        $bean = $this->getBean();
        return $bean->is_AuditEnabled() && $bean->db->tableExists($bean->get_audit_table_name());
    }

    /**
     * Creates the archive table based on the active table
     * @return bool
     * @throws RuntimeException
     */
    public function createArchiveTable() : bool
    {
        $bean = $this->getBean();

        $archiveTable = $bean->getArchiveTableName();

        $archiveBean = clone $bean;

        // Create new archive table with only the id index. Remove all auto-increment fields
        $fieldDefs = $bean->getFieldDefinitions();
        foreach ($fieldDefs as $key => $fieldDef) {
            if (isset($fieldDefs[$key]['auto_increment'])) {
                $fieldDefs[$key]['auto_increment'] = false;
            }
        }

        $indices['id'] = $bean->getIndices()['id'];
        $indices['id']['name'] = $indices['id']['name'] . '_archive';

        // If the table has not yet been created, create it
        if (!$bean->db->tableExists($archiveTable)) {
            // Create the archive table
            $archiveBean->db->createTableParams($archiveTable, $fieldDefs, $indices);
        } else {
            $archiveBean->db->repairTableParams($archiveTable, $fieldDefs, $indices);
        }

        // Additional logic to deal with the possibility of a cstm table having been created
        if ($this->hasCustomTable()) {
            $bean = clone $this->getBean();
            // By changing the object name, we no longer create indices through checking globals in bean->getIndices
            $bean->object_name = $bean->getObjectName() . '_archive';
            $bean->table_name = $bean->get_custom_table_name();
            $this->cstmArchiveTableName = $bean->getArchiveTableName();

            // Default cstmFieldDef for all custom tables
            $cstmFieldDefs = array(
                "id_c" => array(
                    "name" => "id_c",
                    "type" => "id",
                    "required" => 1,
                ),
            );

            // Add each fieldDef to the cstmFieldDef array
            $cstmFieldsOnBean = $this->getBean()->getFieldDefinitions('source', array('custom_fields'));
            foreach ($cstmFieldsOnBean as $field => $def) {
                unset($def['source']);
                $cstmFieldDefs[$field] = $def;
            }

            // Default indices array
            $indices = [
                [
                    'name' => $this->cstmArchiveTableName . '_pk',
                    'type' => 'primary',
                    'fields' => ['id_c'],
                ],
            ];

            // If the table has not yet been created, create it
            if (!$bean->db->tableExists($this->cstmArchiveTableName)) {
                // Create the new custom archive table
                $bean->db->createTableParams($this->cstmArchiveTableName, $cstmFieldDefs, $indices);
            } else {
                $bean->db->repairTableParams($this->cstmArchiveTableName, $cstmFieldDefs, $indices);
            }
        }
        return true;
    }

    /**
     * Performs the given data manipulation process (Archive and Delete or Only Delete)
     * @param Where $where
     * @param string $type Either archive  or delete
     * @return array array of ids that were processed
     * @throws RuntimeException
     * @throws \SugarQueryException
     */
    public function performProcess($where, $type = \DataArchiver::PROCESS_TYPE_ARCHIVE)
    {
        // Return the results of a query to the database using the given where clause object
        $resultsArray = $this->getTableResults($where);
        $results = $resultsArray[0];
        $cstmResults = $resultsArray[1];

        // create an array of ids
        $ids = array_column($results, 'id');
        $cstmIds = array_column($cstmResults, 'id_c');

        if (empty($ids)) {
            return [];
        }

        // Get connection for DB in order to instantiate QueryBuilders
        $this->conn = \DBManagerFactory::getConnection();

        // Call this method in case the archive table hasnt been created yet
        if ($type === \DataArchiver::PROCESS_TYPE_ARCHIVE) {
            $this->createArchiveTable();
            $this->archive($results, $cstmResults);
        }

        // Deletion always occurs
        $this->delete($ids);

        // Delete from custom table if there is one
        if ($this->hasCustomTable()) {
            $this->delete($cstmIds, $this->getBean()->get_custom_table_name(), 'id_c');
        }

        // Delete relationships if hard delete, otherwise, leave them alone
        if ($type === \DataArchiver::PROCESS_TYPE_DELETE) {
            $this->deleteRelationships($ids);

            // Delete audit table entries if hard delete, otherwise, leave them alone
            if ($this->hasAuditTable()) {
                $this->delete($ids, $this->getBean()->get_audit_table_name(), 'parent_id');
            }
        }

        return $ids;
    }

    /**
     * Runs the archiving process
     * @param $rows
     * @param $cstmRows
     * @throws RuntimeException
     */
    private function archive($rows, $cstmRows)
    {
        // NOTE: This function can be potentially optimized in the future to use 1 SQL statement. This would require
        // changing functionality in QueryBuilder. Specifically, it would require allowing multiple values arrays
        // to be added.

        // Creating the builder objects each iteration because there is no way to reset the parameters that are on
        // each object without the original library being altered.
        // Instantiate QueryBuilder for the insertion into archive table
        $builder = $this->conn->createQueryBuilder();
        $qbArchive = $builder
            ->insert($this->getBean()->getArchiveTableName());

        $builder2 = null;
        $qbArchiveCstm = null;
        if ($this->hasCustomTable()) {
            $builder2 = $this->conn->createQueryBuilder();
            $qbArchiveCstm = $builder2
                ->insert($this->cstmArchiveTableName);
        }

        for ($i = 0, $m = count($rows), $cm = count($cstmRows); $i < $m; $i++) {
            $qbArchive
                ->values(
                    array_map(function ($value) use ($builder) {
                        return $builder->createPositionalParameter($value);
                    }, $rows[$i])
                );

            // If the active table has a custom table associated with it, querybuilders need to be set up in the same
            // manner as above
            if ($this->hasCustomTable() && $i < $cm) {
                $qbArchiveCstm
                    ->values(
                        array_map(function ($value) use ($builder2) {
                            return $builder2->createPositionalParameter($value);
                        }, $cstmRows[$i])
                    );
            }

            // Execute archiving SQL statement
            $qbArchive->execute();
            array_push($this->rowsArchived, $rows[$i]['id']);

            // Clear parameters for next iteration
            $qbArchive->setParameters([]);

            // Execute archiving and deletion SQL statements for potential custom table
            if ($this->hasCustomTable() && $i < $cm) {
                $qbArchiveCstm->execute();
                array_push($this->cstmRowsArchived, $rows[$i]['id']);
                $qbArchiveCstm->setParameters([]);
            }
        }
    }

    /**
     * Runs the deletion process
     * @param $ids list of ids to delete
     * @param null $table The table to delete from
     * @param string $id_name column id name (i.e. 'id', or 'id_c', or 'contact_id'
     * @param bool $isCustom Whether or not this deletion is from a custom table or not
     * @throws RuntimeException
     * @throws \Doctrine\DBAL\DBALException
     */
    private function delete($ids, $table = null, $id_name = 'id', $isCustom = false)
    {
        // Grab table name to use in queries
        if (is_null($table)) {
            $table = $this->getBean()->getTableName();
        }

        // Single query to delete all ids passed
        $builder = $this->conn->createQueryBuilder();

        $builder->delete($table)
            ->where($builder->expr()->in($id_name, ':ids'))
            ->setParameter('ids', $ids, Connection::PARAM_STR_ARRAY);

        // Execute query builder
        $builder->execute();

        // Delete from custom table
        if (!$isCustom && $this->hasCustomTable()) {
            $this->delete($ids, $this->getBean()->get_custom_table_name(), 'id_c', true);
        }
    }

    /**
     * Deletes all relationships associated with a specific hard deleted row from active table
     * @param $ids
     * @throws RuntimeException
     */
    private function deleteRelationships($ids)
    {
        $curTable = $this->getBean()->getTableName();
        // Grab the linked fields from the bean
        $bean = $this->getBean();
        $linked_fields=$bean->get_linked_fields();

        // Loop through each field, determine if there is an associated table and remove the row from that table
        foreach ($linked_fields as $name => $value) {
            if ($bean->load_relationship($name)) {
                // Its possible no relationship data exists, therefore it will never need to be worried about for this
                // process
                if ($bean->$name->getRelationshipObject() === null) {
                    continue;
                }

                // Grab the relationship table associated with the linked_field
                $rel_table = $bean->$name->getRelationshipObject()->getRelationshipTable();

                // We only care about relationships that are M2M and create active relationship tables in the db
                // This ensures that only relationship tables that make sense to delete are deleted.
                // For instance, we do not want to delete the row in cases table where an account may be references
                // because deleting an account should not mean that we lose all data ever associated with it.
                // We also dont care about relationships in the active table being hard deleted from since we are
                // removing the entire row anyway.
                // We only want to remove from the primary relationship tables that have the naming convention of
                // accounts_contacts, etc.
                if (! $bean->$name->getRelationshipObject() instanceof \M2MRelationship ||
                    !$this->getBean()->db->tableExists($rel_table) || $rel_table == $curTable) {
                    continue;
                }

                // Grab the 'side' of the relationship table that the table being hard deleted from is associed with
                $side = $bean->$name->getSide();

                // Grab the id label name associated with the list of ids we are working with as it corresponds to the
                // relationship table
                $id_name = $side === 'LHS' ? $bean->$name->relationship->def['join_key_lhs'] :
                    $bean->$name->getRelationshipObject()->def['join_key_rhs'];

                // For certain relationships this will not exist, and thus we dont want to attempt to delete, as it will
                // throw an error
                if ($id_name === null) {
                    continue;
                }

                // Delete from the relationship table where the specific ids are present
                $this->delete($ids, $rel_table, $id_name);
            }
        }
    }

    /**
     * Removes the given rows from the archive table. Psuedo transaction engine
     * @throws RuntimeException
     */
    public function removeArchivedRows()
    {
        $ids = $this->getRowsArchived();
        $cstmIds = $this->getCstmRowsArchived();
        if (count($ids) > 0) {
            $this->delete($ids, $this->getBean()->getArchiveTableName());
        }
        if (count($cstmIds) > 0) {
            $this->delete($cstmIds, $this->cstmArchiveTableName, 'id_c', true);
        }
    }

    /**
     * Returns the ids of the rows that were successfully archived
     * @return array
     */
    private function getRowsArchived()
    {
        return $this->rowsArchived;
    }

    /**
     * Returns the ids of the rows that were successfully archived from custom table
     * @return array
     */
    private function getCstmRowsArchived()
    {
        return $this->cstmRowsArchived;
    }

    /**
     * Returns the Database rows that need to be archived for the active table
     * @param $where the where clause that defines the filter definitons
     * @return array an array of rows from the database table
     * @throws \SugarQueryException|RuntimeException
     */
    private function getTableResults($where)
    {
        $allFieldDefs = $this->getBean()->getFieldDefinitions();
        $cstmFieldDefs = $this->getBean()->getFieldDefinitions('source', array('custom_fields'));
        $dbFieldDefs = array_filter($allFieldDefs, function ($field) use ($cstmFieldDefs) {
            return !key_exists('source', $field) && !in_array($field, $cstmFieldDefs);
        });

        $dbFields = array_keys($dbFieldDefs);

        $sq = new \SugarQuery();
        $sq->select($dbFields);
        $sq->from($this->getBean(), array('add_deleted' => false));
        foreach ($where->conditions as $condition) {
            $sq->where($condition);
        }
        $sq->limit(self::ARCHIVE_LIMIT);

        $filter = array_flip($dbFields);

        $results = array_map(function ($row) use ($filter) {
            return array_intersect_key($row, $filter);
        }, $sq->execute());

        // If this table has a custom table associated with it, grab the rows from that custom table as well
        $cstmResults = [];
        if ($this->hasCustomTable()) {
            $cstmResults = $this->getCstmTableResults($results);
        }

        // Return a results array used to create queries
        return array($results, $cstmResults);
    }

    /**
     * Returns the Database fields needed to be archived for the custom table
     * @param $rows
     * @return array
     * @throws RuntimeException
     */
    private function getCstmTableResults($rows)
    {
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $rows);
        $fields = array('id_c');
        $customFields = array_keys($this->getBean()->getFieldDefinitions('source', array('custom_fields')));
        $fields = array_merge($fields, $customFields);
        $table = $this->getBean()->get_custom_table_name();

        // Get connection for DB in order to instantiate QueryBuilders
        $conn = \DBManagerFactory::getConnection();

        // Custom table query
        $builder = $conn->createQueryBuilder();
        $builder
            ->select($fields)
            ->from($table)
            ->where($builder->expr()->in('id_c', ':ids'))
            ->setParameter('ids', $ids, Connection::PARAM_STR_ARRAY);

        return $builder->execute()->fetchAll();
    }

    /**
     * Used to archive an individual bean
     * @throws \SugarQueryException|RuntimeException
     */
    public function archiveBean($id)
    {
        // Generate where clause and pass to archive functionality
        $q = new \SugarQuery();
        $w = $q->where()->equals('id', $id);
        $this->performProcess($w);
    }
}
