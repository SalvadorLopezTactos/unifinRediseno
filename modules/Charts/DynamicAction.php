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

if (!isset($_GET['DynamicAction']) || $_GET['DynamicAction'] !== 'saveImage') {
    return;
}
if (!sugar_mkdir(sugar_cached("images"), 0777, true)) {
    throw new \RuntimeException(sprintf("Can't create directory '%s'", sugar_cached('images')));
}
$filename = pathinfo($_POST['filename'], PATHINFO_BASENAME);
if (strpos($filename, chr(0)) || strpos($filename, '..')) {
    throw new \RuntimeException(sprintf("Filename '%s' contains forbidden characters", $filename));
}
$filepath = sugar_cached("images/$filename");

$image = str_replace(' ', '+', $_POST['imageStr']);
$data = substr($image, strpos($image, ","));
$tmpFile = tempnam(sugar_cached('images'), 'charts');
if (false === file_put_contents($tmpFile, base64_decode($data))) {
    throw new \RuntimeException(sprintf("Can't write data into '%s'", $tmpFile));
}
if (!verify_uploaded_image($tmpFile)) {
    unlink($tmpFile);
    throw new \RuntimeException('Uploaded file is not a valid image');
}
if (!rename($tmpFile, $filepath)) {
    throw new \RuntimeException("Can't rename tmp file '%s' to '%s'", $tmpFile, $filepath);
}
