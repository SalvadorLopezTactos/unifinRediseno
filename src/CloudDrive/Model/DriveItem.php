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

namespace Sugarcrm\Sugarcrm\CloudDrive\Model;

use Microsoft\Graph\Model\DriveItem as ModelDriveItem;

class DriveItem
{
    public $id;
    public $name;
    public $driveId;
    public $isFolder;
    public $parents;
    public $shared;
    public $owners;
    public $iconLink;
    public $webViewLink;
    public $dateModified;
    public $downloadUrl; //works for onedrive

    /**
     * Maps a model tp DriveItem
     *
     * @param ModelDriveItem $data
     * @return DriveItem
     */
    public static function fromOneDrive(ModelDriveItem $data): DriveItem
    {
        $item = new self([
            'id' => $data->getId(),
            'name' => $data->getName(),
        ]);

        if ($data->getRemoteItem()) {
            $data = $data->getRemoteItem();
            $data->setShared(true);
        }
        $parentReference = $data->getParentReference();

        if (!is_null($parentReference)) {
            $item->setDriveId($parentReference->getDriveId());
            $item->setParents($parentReference->getId());
        }
        $data->getFolder() ? $item->setFolder(true) : $item->setFolder(false);

        $createBy = $data->getCreatedBy();
        $user = null;
        if ($createBy) {
            $user = $createBy->getUser();
        }

        $item->setOwners([$user]);
        $item->setWebViewLink($data->getWebUrl());
        if (!is_null($data->getLastModifiedDateTime())) {
            $item->setDateModified($data->getLastModifiedDateTime()->format('c'));
        }
        $item->setDownloadUrl($item->downloadUrl);

        return $item;
    }

    /**
     * Map google item to DriveItem
     *
     * @param mixed $data
     * @return DriveItem
     */
    public static function fromGoogleDrive($data): DriveItem
    {
        $item = new self($data);
        $data->mimeType === 'application/vnd.google-apps.folder' ? $item->setFolder(true) : $item->setFolder(false);
        $item->setDateModified($data->modifiedTime);
        return $item;
    }

    /**
     * @constructor
     *
     * @param string $type
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->shared = $data['shared'];
        $this->parents = $data['parents'];
        $this->owners = $data['owners'];
        $this->iconLink = $data['iconLink'];
        $this->webViewLink = $data['webViewLink'];
    }

    /**
     * Setter for drive id;
     *
     * @param string $id
     * @return void
     */
    public function setDriveId(string $id)
    {
        $this->driveId = $id;
    }

    /**
     * Used only for onedrive
     * Set if item is folder
     *
     * @param bool $isFolder
     */
    public function setFolder(bool $isFolder)
    {
        $this->isFolder = $isFolder;
    }

    /**
     * Set parents
     *
     * @param string $parentId
     */
    public function setParents(?string $parentId)
    {
        $this->parents = [$parentId];
    }

    /**
     * Set shared
     * @param bool $isShared
     */
    public function setShared(bool $isShared)
    {
        $this->shared = $isShared;
    }

    /**
     * Set owners
     *
     * @param array $owners
     */
    public function setOwners(?array $owners)
    {
        $this->owners = $owners;
    }

    /**
     * Set owners
     *
     * @param string $link
     */
    public function setWebViewLink(?string $link)
    {
        $this->webViewLink = $link;
    }

    /**
     * Set date modified
     *
     * @param string $dateModified
     */
    public function setDateModified(?string $dateModified)
    {
        $this->dateModified = $dateModified;
    }

    /**
     * Set download url
     *
     * @param string $link
     */
    public function setDownloadUrl(?string $link)
    {
        $this->downloadUrl = $link;
    }
}
