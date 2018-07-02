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
//include the base class
require_once 'modules/ModuleBuilder/parsers/views/DeployedMetaDataImplementation.php';
//include the file to convert BWC metadata files
require_once 'include/MetaDataManager/MetaDataConverter.php';
//include the class to deploy sidecar files
require_once 'modules/ModuleBuilder/parsers/views/DeployedSidecarFilterImplementation.php';


/*
 * Implementation class for handling search metadata
 */
class DeployedSearchMetaDataImplementation extends DeployedMetaDataImplementation
{
    /**
     * Deploy the sidecar filter metadata files after converting from BWC files.
     * @param array $defs : the defs to be deployed
     * @overrides DeployedMetaDataImplementation::deploy()
     */
    public function deploy($defs)
    {
        parent::deploy($defs);
        $this->createSidecarFilterDefsFromLegacy($defs);
    }
    /**
     * Convert BWC searchdefs to sidecar filter metadata files.
     * @param array $defs : the defs of BWC modules to be converted
     * @return array
     */
    public function createSidecarFilterDefsFromLegacy($defs = array(), $filterDefs = array())
    {
        if (empty($defs)) {
            $defs = $this->getViewdefs();
        }
        $converter = new MetaDataConverter();
        $scDefs = $converter->convertLegacyViewDefsToSidecar(
            $defs,
            $this->_moduleName,
            $this->getFieldDefs(),
            $this->_viewType,
            $this->_viewClient,
            $filterDefs
        );
        $sidecarFilter = new DeployedSidecarFilterImplementation($this->_moduleName);
        return $sidecarFilter->deploy($scDefs);
    }
}
