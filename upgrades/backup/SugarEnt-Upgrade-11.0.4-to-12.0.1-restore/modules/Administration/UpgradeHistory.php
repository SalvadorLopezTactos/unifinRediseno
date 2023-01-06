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

use Sugarcrm\Sugarcrm\PackageManager\Entity\PackageManifest;
use Sugarcrm\Sugarcrm\PackageManager\Exception\PackageManifestException;
use Doctrine\DBAL\DBALException;

/**
 * External module class
 */
class UpgradeHistory extends SugarBean
{
    const STATUS_STAGED = 'staged';
    const STATUS_INSTALLED = 'installed';

    var $new_schema = true;
    var $module_dir = 'Administration';

    // Stored fields
    var $id;
    var $filename;
    var $md5sum;
    var $type;
    var $version;
    var $status;
    var $date_entered;

    /**
     * @var string
     */
    public $date_modified;

    var $name;
    var $description;
    var $id_name;

    /**
     * serialized base_64_encoded package manifest
     * @var string
     */
    public $manifest;

    /**
     * prepared package manifest
     * @var PackageManifest
     */
    private $packageManifest;

    /**
     * serialized base_64_encoded package patch
     * @var string
     */
    public $patch;

    /**
     * is package deleted?
     * @var string
     */
    public $enabled;

    /**
     * is upgrade history deleted?
     * @var bool
     */
    public $deleted;

    /**
     * published date provided by package manifest. Saved as is.
     * @var string
     */
    public $published_date;

    /**
     * Is package uninstallable;
     * @var bool
     */
    public $uninstallable;

    var $tracker_visibility = false;
    var $table_name = "upgrade_history";
    var $object_name = "UpgradeHistory";
    var $module_name = "UpgradeHistory";
    var $column_fields = Array( "id", "filename", "md5sum", "type", "version", "status", "date_entered" );
    var $disable_custom_fields = true;

    /**
     * UpgradeHistory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->disable_row_level_security = true;
    }

    /**
     * return unserialized and decoded package patch
     * @return array
     */
    public function getPackagePatch(): array
    {
        $packagePatch = [];
        if (!empty($this->patch)) {
            $packagePatch = unserialize(base64_decode($this->patch), ['allowed_classes' => false]);
        }
        return $packagePatch;
    }

    /**
     * return prepared package manifest
     * @return PackageManifest
     * @throws PackageManifestException
     */
    public function getPackageManifest(): PackageManifest
    {
        if (!$this->packageManifest) {
            $manifest = unserialize(base64_decode($this->manifest), ['allowed_classes' => false]);
            // Previous manifest might be saved with empty string instead of array
            foreach (['manifest', 'installdefs', 'upgrade_manifest'] as $key) {
                if (empty($manifest[$key]) || !is_array($manifest[$key])) {
                    $manifest[$key] = [];
                }
            }
            $this->packageManifest = new PackageManifest(
                $manifest['manifest'],
                $manifest['installdefs'],
                $manifest['upgrade_manifest']
            );
        }
        return $this->packageManifest;
    }

    /**
     * is package enabled?
     * @return bool
     */
    public function isPackageEnabled(): bool
    {
        return intval($this->enabled) === 1;
    }

    /**
     * is package uninstallable?
     * @return bool
     */
    public function isPackageUninstallable(): bool
    {
        return intval($this->uninstallable) === 1;
    }

    /**
     * get installed packages by type
     * @param string $type
     * @return array
     * @throws SugarQueryException
     */
    public function getInstalledPackagesByType(string $type): array
    {
        $query = new SugarQuery();
        $query->from($this);
        $query->where()
            ->equals('status', self::STATUS_INSTALLED)
            ->equals('type', $type);
        return $this->fetchFromQuery($query);
    }

    /**
     * return all packages
     * @return SugarBean[]
     * @throws SugarQueryException
     */
    public function getPackages(): array
    {
        $query = new SugarQuery();
        $query->from($this);
        $query->orderBy('date_entered');
        return $this->fetchFromQuery($query);
    }

    /**
     * return all packages by type
     * @param string $type
     * @return SugarBean[]
     * @throws SugarQueryException
     */
    public function getPackagesByType(string $type): array
    {
        $query = new SugarQuery();
        $query->from($this);
        $query->where()->equals('type', $type);
        $query->orderBy('date_entered');
        return $this->fetchFromQuery($query);
    }

    /**
     * return module packages by status
     * @param string $status
     * @return SugarBean[]
     * @throws SugarQueryException
     */
    public function getModulePackagesByStatus(string $status): array
    {
        $query = new SugarQuery();
        $query->from($this);
        $query->where()->equals('type', PackageManifest::PACKAGE_TYPE_MODULE);
        $query->where()->equals('status', $status);
        return $this->fetchFromQuery($query);
    }

    /**
     * find all packages by md5
     * @param string $md5Sum
     * @param array $queryOptions
     * @return SugarBean[]
     * @throws SugarQueryException
     */
    public function findByMd5(string $md5Sum, array $queryOptions = []): array
    {
        $query = new SugarQuery();
        $query->from($this, $queryOptions);
        $query->where()->equals('md5sum', $md5Sum);
        return $this->fetchFromQuery($query);
    }

    /**
     * retrieve by MD5
     * @param string $md5Sum
     * @param array $queryOptions
     * @return SugarBean|null
     * @throws SugarQueryException
     */
    public function retrieveByMd5(string $md5Sum, array $queryOptions = []):? SugarBean
    {
        $result = $this->findByMd5($md5Sum, $queryOptions);
        if (!empty($result)) {
            return array_shift($result);
        }
        return null;
    }

    /**
     * retrieve upgrade history by id_name
     * @param string $idName
     * @return SugarBean|null
     * @throws SugarQueryException
     */
    public function retrieveByIdName(string $idName):? SugarBean
    {
        $query = new SugarQuery();
        $query->from($this);
        $query->where()->equals('id_name', $idName);
        $query->limit(1);
        $result = $this->fetchFromQuery($query);
        if (!empty($result)) {
            return array_shift($result);
        }
        return null;
    }

    /**
     * find all matches by source names upgrade history
     * @param UpgradeHistory $source
     * @return array
     * @throws SugarQueryException
     */
    public function findMatchesByName(UpgradeHistory $source): array
    {
        if (empty($source->id_name) && empty($source->name)) {
            return [];
        }

        $query = new SugarQuery();
        $query->from($this);

        if (!empty($source->id_name)) {
            $query->where()->equals('id_name', $source->id_name);
        } else {
            $query->where()->equals('name', $source->name);
        }

        if (!empty($source->id)) {
            $query->where()->notEquals('id', $source->id);
        }

        return $this->fetchFromQuery($query);
    }

    /**
     * Given a name check if it exists in the table
     * @param UpgradeHistory $source
     * @return null|UpgradeHistory
     * @throws SugarQueryException
     */
    public function checkForExisting(UpgradeHistory $source):? UpgradeHistory
    {
        $result = $this->findMatchesByName($source);
        if (!empty($result)) {
            return array_shift($result);
        }
        return null;
    }

    /**
     * Return upgrade history data as array
     * @return array
     */
    public function getData(): array
    {
        return [
            'id' => $this->id,
            'name' => (string) $this->name,
            'type' => (string) $this->type,
            'status' => (string) $this->status,
            'description' => (string) $this->description,
            'version' => (string) $this->version,
            'published_data' => (string) $this->published_date,
            'enabled' => $this->isPackageEnabled(),
            'uninstallable' => $this->isPackageUninstallable(),
            'file' => $this->id,
            'file_install' => $this->id,
            'unFile' => $this->id,
        ];
    }

    /**
     * return list of not installed dependencies
     * @return array
     * @throws PackageManifestException
     * @throws DBALException
     * @throws Exception
     */
    public function getListNotInstalledDependencies(): array
    {
        $result = [];
        $requiredDependencies = $this->getPackageManifest()->getManifestValue('dependencies', []);

        $conn = $this->db->getConnection();
        $stmt = $conn->prepare(sprintf(
            'SELECT version FROM %s WHERE id_name = ? AND status = ? AND deleted = 0',
            $this->table_name,
        ));

        foreach ($requiredDependencies as $dependency) {
            if (empty($dependency['id_name']) || empty($dependency['version'])) {
                continue;
            }
            $stmt->execute([$dependency['id_name'], self::STATUS_INSTALLED]);
            $isRequiredVersionInstalled = false;
            while ($row = $stmt->fetch()) {
                if (version_compare($row['version'], $dependency['version'], '>=')) {
                    $isRequiredVersionInstalled = true;
                    break;
                }
            }
            if (!$isRequiredVersionInstalled) {
                $result[] = $dependency['id_name'];
            }
        }
        return $result;
    }

    /**
     * Get previous installed version for staged upgrade history
     * @return UpgradeHistory|null
     * @throws SugarQueryException
     */
    public function getPreviousInstalledVersion():? UpgradeHistory
    {
        if ($this->status === self::STATUS_INSTALLED) {
            return null;
        }

        $query = new SugarQuery();
        $query->from($this);
        $query->where()
            ->equals('id_name', $this->id_name)
            ->equals('status', self::STATUS_INSTALLED);
        $query->orderBy('date_entered', 'DESC');

        /** @var UpgradeHistory[] $versions */
        $versions = $this->fetchFromQuery($query);
        if (empty($versions)) {
            return null;
        }

        $previousInstalled = array_shift($versions);
        foreach ($versions as $version) {
            if (version_compare($version->version, $previousInstalled->version, '>')) {
                $previousInstalled = $version;
            }
        }
        return $previousInstalled;
    }

    /**
     * @deprecated please use mark_deleted
     */
    public function delete(): void
    {
        $this->mark_deleted($this->id);
    }
}
