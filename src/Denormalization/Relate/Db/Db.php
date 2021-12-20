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

namespace Sugarcrm\Sugarcrm\Denormalization\Relate\Db;

use DBManager;
use DBManagerFactory;
use SugarBean;
use SugarConfig;
use Sugarcrm\Sugarcrm\Dbal\Connection;
use UnexpectedValueException;

abstract class Db implements OfflineOperations, OnlineOperations
{
    /** @var string */
    protected const TMP_TABLE_NAME = "denorm_tmp";

    /** @var string */
    protected const TMP_PRIMARY_INDEX_NAME = 'denorm_tmp_idx';

    /** @var string */
    protected const TMP_TARGET_ID_INDEX_NAME = 'denorm_tmp_target_id_idx';

    /** @var DBManager */
    protected $db;

    /** @var Connection */
    protected $connection;

    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance();
        $this->connection = $this->db->getConnection();
    }

    public static function getInstance(): Db
    {
        $type = SugarConfig::getInstance()->get('dbconfig')['db_type'];

        switch ($type) {
            case 'mysql':
                $class = MySql::class;
                break;
            case 'ibm_db2':
                $class = IbmDb2::class;
                break;
            case 'oci8':
                $class = Oracle::class;
                break;
            case 'mssql':
                $class = MsSql::class;
                break;
            default:
                throw new UnexpectedValueException(
                    sprintf('The provided DB type "%s" is not supported', $type)
                );
        }

        return new $class;
    }

    public function createTemporaryTable(array $fieldDefForValue): void
    {
        if ($this->db->tableExists(self::TMP_TABLE_NAME)) {
            $this->dropTemporaryTable();
        }

        $valueFieldDef = [
            'name' => 'value',
            'type' => $fieldDefForValue['type'],
            'len' => $fieldDefForValue['len'] ?? null,
        ];

        $fieldDefs = [
            [
                'name' => 'id',
                'type' => 'int',
                'auto_increment' => true,
                'auto_increment_platform_options' => [
                    'cache' => 10000,
                ],
            ],
            [
                'name' => 'target_id',
                'type' => 'id',
            ],
            $valueFieldDef,
        ];
        $index = [
            'type' => 'primary',
            'name' => self::TMP_PRIMARY_INDEX_NAME,
            'fields' => ['id'],
        ];

        $this->db->createTableParams(self::TMP_TABLE_NAME, $fieldDefs, $index);
    }

    public function dropTemporaryTable(): void
    {
        $this->db->dropTableName(self::TMP_TABLE_NAME);
    }

    public function getTemporaryTableCount(): int
    {
        return $this->getTableRowCount(self::TMP_TABLE_NAME);
    }

    public function getTableRowCount(string $tableName): int
    {
        $result = $this->connection->fetchColumn("SELECT COUNT(*) FROM $tableName");

        return (int) $result;
    }

    public function getAlterSql(string $tableName, array $fieldDef): ?string
    {
        $sql = null;
        if (!$this->isAltered($tableName, $fieldDef['name'])) {
            $sql = $this->db->addColumnSQL(
                $tableName,
                $fieldDef
            );
        }

        return $sql;
    }

    public function ensureTemporaryTableIndex(): void
    {
        $tmpTableName = self::TMP_TABLE_NAME;
        $tmpTargetIdIndexName = self::TMP_TARGET_ID_INDEX_NAME;

        $index = $this->db->get_index($tmpTableName, $tmpTargetIdIndexName);

        if (!$index) {
            $fields = [
                ['name' => 'target_id'],
                ['name' => 'id'],
            ];
            $sql = $this->db->createIndexSQL($tmpTableName, $fields, $tmpTargetIdIndexName);
            $this->connection->exec($sql);
        }
    }

    public function finalizeTemporaryTable(): void
    {
        // At least Oracle DB requires an additional step to make the table ready
        // And this step should be performed after all operations were done
    }

    public function ensureColumnExists(string $tableName, array $fieldDef): void
    {
        $sql = $this->getAlterSql($tableName, $fieldDef);
        if ($sql) { // otherwise the table is in sync
            $this->connection->exec($sql);
        }
    }

    public function isAltered(string $tableName, string $fieldName): bool
    {
        $tableDescription = $this->getTableDescription($tableName);

        return !empty($tableDescription[$fieldName]);
    }

    public function getTableDescription(string $tableName): array
    {
        return $this->db->getTableDescription($tableName, true);
    }

    public function populateTemporaryTable(
        string $idField,
        string $sourceFieldName,
        string $fromTable,
        string $joinTable,
        string $joinConditionTargetField,
        string $joinConditionSourceField
    ): void {
        $qb = $this->connection->createQueryBuilder();
        $qb->select(["t.$idField as id", "s.$sourceFieldName"])
            ->from($fromTable, 't')
            ->join(
                't',
                $joinTable,
                's',
                "t.$joinConditionTargetField = s.$joinConditionSourceField"
            )
            ->where("t.deleted = 0");

        $tmpTableName = self::TMP_TABLE_NAME;

        $insertFieldList = ['target_id', 'value'];

        $autoIncrementValue = $this->db->getAutoIncrementSQL($tmpTableName, "id");
        if (!empty($autoIncrementValue)) {
            $qb->addSelect($autoIncrementValue);
            $insertFieldList[] = 'id';
        }

        $insertSql = "INSERT INTO $tmpTableName (" . implode(', ', $insertFieldList) . ") " . $qb->getSQL();

        $this->connection->executeUpdate($insertSql);
    }

    public function replicateIndex(string $tableName, string $indexName, SugarBean $targetBean, array $fieldDefs): void
    {
        $index = $this->db->get_index($tableName, $indexName);

        if (empty($index)) {
            $this->db->createIndex($targetBean, $fieldDefs, $indexName, false);
        }
    }

    public function updateBean(SugarBean $bean, string $fieldName): void
    {
        $this->connection->update(
            $bean->getTableName(),
            [$fieldName => $bean->$fieldName],
            ['id' => $bean->id]
        );
    }

    public function updateLinkedBean(
        string $relateRecordId,
        ?string $joinTableName,
        ?string $joinPrimaryKey,
        ?string $joinLinkedKey,
        string $denormalizedFieldName,
        string $primaryTableName,
        string $primaryKey,
        $value
    ): void {
        if (!empty($joinTableName)) {
            $where = $this->connection->createQueryBuilder();
            $where->select($joinPrimaryKey)
                ->from($joinTableName)
                ->where("$joinLinkedKey = :link_id");
            $whereSql = $where->getSql();
        } else {
            $whereSql = ":link_id";
        }

        $update = $this->connection->createQueryBuilder();
        $update->update($primaryTableName)
            ->set($denormalizedFieldName, ':value')
            ->where($update->expr()->in($primaryKey, $whereSql))
            ->setParameter('value', $value)
            ->setParameter('link_id', $relateRecordId);

        $update->execute();
    }

    public function updateBeanWithLinkId(
        SugarBean $bean,
        string $linkedFieldName,
        string $linkedTableName,
        string $linkedKey,
        string $primaryTableName,
        string $denormalizedFieldName,
        string $linkId
    ): void {
        $subQuery = $this->connection->createQueryBuilder();
        $subQuery->select($linkedFieldName)
            ->from($linkedTableName)
            ->where("$linkedKey = :link_id");

        $update = $this->connection->createQueryBuilder();
        $update->update($primaryTableName)
            ->set($denormalizedFieldName, "(" . $subQuery->getSQL() . ")")
            ->where('id = :bean_id')
            ->setParameter('bean_id', $bean->id)
            ->setParameter('link_id', $linkId);

        $update->execute();
    }

    public function updateTemporaryTableWithValue(SugarBean $bean, $value): void
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->update(self::TMP_TABLE_NAME);

        $builder->set('value', ':value')
            ->where('target_id = :target_id')
            ->setParameter('value', $value)
            ->setParameter('target_id', $bean->id);

        $builder->execute();
    }

    public function updateTemporaryTable(
        SugarBean $bean,
        string $relatedFieldName,
        string $relatedTableName,
        string $relatedKey
    ): void {
        $subQuery = $this->connection->createQueryBuilder();
        $subQuery->select($relatedFieldName)
            ->from($relatedTableName)
            ->where("$relatedKey = :target_id");

        $builder = $this->connection->createQueryBuilder();
        $builder->update(self::TMP_TABLE_NAME);

        $builder->set('value', '(' . $subQuery->getSql() . ')')
            ->where('target_id = :target_id')
            ->setParameter('target_id', $bean->id);

        $builder->execute();
    }

    /**
     * @return false|mixed
     */
    public function fetchValue(string $tableName, string $fieldName, string $id)
    {
        return $this->connection->createQueryBuilder()
            ->select($fieldName)
            ->from($tableName)
            ->where("id = :link_id")
            ->setParameter('link_id', $id)
            ->execute()
            ->fetchColumn();
    }
}
