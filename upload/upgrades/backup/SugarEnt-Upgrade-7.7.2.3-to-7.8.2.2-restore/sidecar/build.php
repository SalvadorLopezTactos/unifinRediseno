#!/usr/bin/env php
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
 * This script is used to built the javascript associated to the sidecar framework
 *
 * It will concatenate and minify any files specified in an array in src/include-manifest.php. It will
 * also build documentation for the framework if the appropriate library is available.
 *
 * The variable $buildFiles is specified in src/include-manifest.php and consists of an array of the format below.
 * $buildFiles = array(
 *     'outputFileName' => array(
 *         'file1.js',
 *         'file2.js'
 *     )
 * )
 *
 *
 * How to include Sidecar:
 * =======================
 * In your HTML file include the following lines:
 *
 * <script type="text/javascript" src="/path/to/minified/sidecar.min.js" data-config="relative/path/from/sidecar/to/config.js">
 *     var App = SUGAR.App.init({
 *         el: "#sidecar",
 *         callback: function(app){
 *             app.start();
 *         }
 *     });
 * </script>
 *
 * // Or...
 *
 * <script type="text/javascript" src="/path/to/minified/sidecar.min.js"></script>
 * <script type="text/javascript" src="/path/to/config.js"></script>
 *
 * // And put the following before the end of the closing body tag...
 *
 * <script type="text/javascript">
 *     var App = SUGAR.App.init({
 *         el: "#sidecar",
 *         callback: function(app){
 *             app.start();
 *         }
 *     });
 * </script>
 *
 *
 * Development guide:
 * ==================
 * To allow to easier development, a non-minified version of sidecar
 * is created during the build.  To use this version, simply include
 * `sidecar.js` instead of `sidecar.min.js`.
 *
 * The development version loads the dependent files individually so
 * that it is as close to adding the individual files as possible.
 *
 *
 * Requirements:
 * =============
 *  nodejs   (http://nodejs.org)
 *  ruby     (http://rvm.io)
 *  uglifyjs (sudo npm install -g uglify-js)
 *  jshint   (sudo npm install -g jshint)
 *  jsduck   (gem install jsduck)
 *
 *
 * Usage:
 * ======
 * php build.php -p # this would include portal files
 * php build.php -v # this would produce "verbose" output from jshint
 *
 **/

require('src/include-manifest.php');

$verbose = false;
$useUglify = false;
$noMinify = false;
$createdGroups = array();
$license = <<<JS
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
JS;

function main($buildFiles)
{
    // Set Build directory
    $outputDir = "minified";
    $options = initOptions($buildFiles);
    createOutputDirectory($outputDir);
    build($buildFiles, $outputDir);
    generateDocumentation();
    verifyAndExit($outputDir);
}

// Entry point
main($buildFiles);

/**
 * @param array $buildFiles array of files to build
 * @param string $outputDir where to put the built files
 */
function build($buildFiles, $outputDir)
{
    global $createdGroups;
    global $verbose;
    
    if ($buildFiles) {
        // groupName = "sidecar", "portal", etc.
        foreach ($buildFiles as $groupName => $fileList) {
            $createdGroups[] = $groupName;
            
            buildFile($outputDir, $groupName . ".js", $fileList, false);
            buildFile($outputDir, $groupName . ".min.js", $fileList, true);
            
            if ($verbose) {
                _lintFiles($fileList);
            }
        }
    } else {
        echo "You do not appear to have include-manifest.php or we were unable to parse it.";
        exit(1);
    }
}

/**
 * Creates and writes built JavaScript file.
 *
 * For production version, the files in the given file list are read and the
 * contents of each are concatenated to a buffer, which is then minified
 * and written to disk.
 *
 * For development version, the files in the given file list read and
 * some JavaScript is written for each that will load the file contents
 * on page load.
 *
 * For both versions, custom JavaScript is inserted to allow for dynamic
 * inclusion of the config.js file that may be defined in as a data
 * attribute on the tag that includes the built file. Another piece of
 * the custom JavaScript allows for the bootstrap code
 * (i.e., SUGAR.App.init(...)) to be placed inside the script tag.
 *
 * @param  String  $outputDir    Where the built file will be created.
 * @param  String  $fileName     The name of the file to be created.
 * @param  Array   $files        The list of files to include in the built file.
 * @param  boolean $prodVersion  Whether or not to minify the included files.
 * @return String                The contents of the created file.
 */
function buildFile($outputDir, $fileName, $files, $prodVersion)
{
    global $license;

    $contents = '';
    
    if ($prodVersion) {
        $contents .= _concatFiles($files);
        $contents = _minifyJS($contents);
    } else {
        foreach ($files as $file) {
            $contents .= "\n    include(sidecarUrl + '" . $file . "');";
        }
        // Adding JavaScript here!
        // Take care with your syntax.
        $contents = <<<JS
$license
(function() {
    var he = document.getElementsByTagName('head')[0];
    
    // We need a good URL to figure out where to get this stuff in the browser.
    var sidecarUrl = 'sidecar/';
    var indexOfSugarCrm = location.pathname.indexOf("/sugarcrm");
    if ( indexOfSugarCrm > -1 ) {
        sidecarUrl = location.pathname.slice(0, indexOfSugarCrm) + "/sugarcrm/" + sidecarUrl;
    }
    
    function include(file) {
        // Use docment.write to make sure files are loaded and parsed
        // before any other scripts on the page.  We're not worried about
        // performance for dev or for the config file.
        document.write('<scr' + 'ipt src="' + file + '" type="text/javascript"></scr' + 'ipt>');
    }
    
    $contents
}());

JS;
    }
    
    _writeFile($contents, $outputDir . "/" . $fileName);
    
    return $contents;
}

/**
 * Creates a directory to write to.
 * @param  String $outputDir The path of the directory to create.
 * @return null
 */
function createOutputDirectory($outputDir)
{
    remove($outputDir);
    mkdir($outputDir, 0777, true);
}

/**
 * Initialize the option variables.
 * @param  array $buildFiles List of files to be built.
 * @return null
 */
function initOptions($buildFiles)
{
    global $verbose, $useUglify, $noMinify;
    $shortopts = "p";   // include portal files
    $shortopts .= "v";  // verbose e.g. jshint errors
    $shortopts .= "u";  // force uglify
    $shortopts .= "n";  // Don't minifiy at all

    $options = getopt($shortopts);
    
    if (!array_key_exists('p', $options)) {
        unset($buildFiles['portal']);
    }
    
    if (array_key_exists('v', $options)) {
        $verbose = true;
    }

    if (array_key_exists('u', $options)) {
        $useUglify = true;
    }

    if (array_key_exists('n', $options)) {
        $noMinify = true;
    }
    
    return $options;
}

/**
 * Recursively remove given directory and files.
 * @param  String $path The directory to delete.
 * @return result of rmdir($path)
 */
function remove($path)
{
    if (!file_exists($path)) {
        return true;
    }
    
    if (is_file($path)) {
        return unlink($path);
    }
    
    $d = dir($path);
    
    while ($e = $d->read()) {
        if ($e == '.' || $e =='..') {
            continue;
        }
        $nPath = $path . '/'. $e;
        remove($nPath);
    }
    
    $d->close();
    return rmdir($path);
}

/**
 * Generates documentation for Sidecar.
 * @return null
 */
function generateDocumentation()
{
    $docs = shell_exec('jsduck src lib/sugarapi --output docs 2>&1');
}

/**
 * Verifies that the appropriate files were created and exits with
 * the appropriate exit status.
 * @param {String} $outputDir output folder
 * @return null
 */
function verifyAndExit($outputDir)
{
    global $createdGroups;
    $exitStatus = 0;
    
    foreach ($createdGroups as $groupName) {
        if (!file_exists($outputDir . '/' . $groupName . '.min.js')) {
            fwrite(STDERR, "Could not find minified file for grouping '$groupName'!\n");
            $exitStatus = 1;
        }
        if (!file_exists($outputDir . '/' . $groupName . '.js')) {
            fwrite(STDERR, "Could not find development file for grouping '$groupName'!\n");
            $exitStatus = 1;
        }
    }
    
    if ($exitStatus != 0) {
        exit($exitStatus);
    }
}

/////////////
// Helpers //
/////////////

/**
 * Write given content to a new file.
 * @param  String $content  The content to write to the $file.
 * @param  String $fileName The file to create and write to.
 */
function _writeFile($content, $fileName)
{
    $writeFile = fopen($fileName, "w");
    fwrite($writeFile, $content);
    fclose($writeFile);
}

/**
 * Lints the given files, printing the results to the console.
 * @param  Array $files List of files.
 */
function _lintFiles($files)
{
    foreach ($files as $file) {
        // Only lint files not in the /lib directory
        if (0 == preg_match('/^\W*lib\/.*$/i', $file) && file_exists($file)) {
            _jshintFile($file);
        }
    }
}

/**
 * Concatenates the given files.
 * @param  Array $files  The list of files to concatenate.
 * @return String        The contents of all the files.
 */
function _concatFiles($files)
{
    $concatBuffer = '';
    
    foreach ($files as $file) {
        $concatBuffer .= file_get_contents($file) . ';';
    }
    
    return $concatBuffer;
}

/**
 * Minifies the given JavaScript using UglifyJS.
 * @param  String $content  The JavaScript content.
 * @return String           Minified JavaScript.
 */
function _minifyJS($content)
{
    global $useUglify, $noMinify;
    
    if ($noMinify) {
        return $content;
    }

    $uglify = shell_exec('which uglifyjs 2>&1');

    // if -u was passed, force uglify as it will produce smaller file output
    if (!$useUglify || empty($uglify)) {
        // If the JSMIn extension is loaded, use that as it can be as much as 1000x faster than JShrink
        if (extension_loaded("jsmin")) {
            return jsmin($content);
        }
    }

    // next fall back to uglify
    if (!empty($uglify)) {
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        );
        $process = proc_open($uglify, $descriptorspec, $pipes);
        if (is_resource($process)) {
            fwrite($pipes[0], $content);
            fclose($pipes[0]);
            $out = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            proc_close($process);
            return $out;
        }
    }

    // Finally attempt to use JShrink
    if (file_exists('Minifier.php')) {
        require_once('Minifier.php');
    } elseif (file_exists('../jssource/Minifier.php')) {
        require_once('../jssource/Minifier.php');
    } else {
        // No minifier found, just return the content
        return $content;
    }

    return JShrink\Minifier::minify($content);
}

/**
 * Lint the given file and echo the results.
 * @param  String $file  Path to the file to lint.
 */
function _jshintFile($file)
{
    $jshintError = shell_exec('jshint ' . $file . ' 2>&1');
    if ($jshintError) {
        echo $jshintError;
    }
}
