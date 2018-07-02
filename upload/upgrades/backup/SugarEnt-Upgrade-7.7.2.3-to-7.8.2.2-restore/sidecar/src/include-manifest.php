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

// FIXME SC-4937: we want to get rid of this file

$filesJson = json_decode(file_get_contents(dirname(__FILE__) . '/../grunt/assets/files.json'));
$sidecar = $filesJson->buildFiles->sidecar;

// Sidecar Lite: no jQuery
$sidecarLite = $sidecar->lite;

$buildFiles = array(
    'sidecar.lite' => $sidecarLite,
    'sidecar' => array_merge($sidecar->extra, $sidecarLite),
);
