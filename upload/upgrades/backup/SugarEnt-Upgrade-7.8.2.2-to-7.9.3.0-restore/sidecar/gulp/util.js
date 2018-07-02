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

var _ = require('lodash');
var stripJsonComments = require('strip-json-comments');
var fs = require('fs');

/**
 * Object used for caching mechanism.
 *
 * @type {Object}
 * @private
 */
var _cache = {};

module.exports = {
    /**
     * A function that returns an object from a given JSON filename, which will also strip comments.
     * @param {string} filename Filename to parse.
     *
     * @returns {Object} Parsed file.
     */
    readJSONFile: function (filename) {
        return _cache[filename] = _cache[filename] ||
            JSON.parse(stripJsonComments(fs.readFileSync(filename, 'utf8')));
    },

    /**
     * A function that returns parsed files.json.
     *
     * @returns {Object} Parsed file.
     */
    getFilesJson: function () {
        return this.readJSONFile('gulp/assets/files.json');
    },

    /**
     * A function that returns sidecarFiles based on parsed files.json.
     *
     * @returns {Array} List of sidecar files to be processed.
     */
    getSidecarFiles: function () {
        return this.getFilesJson().buildFiles.sidecar;
    },

    /**
     * A function that returns list of files to be linted, based on sidecarFiles.
     *
     * @returns {Array} List of files to be linted.
     */
    getFilesToLint: function () {
        var sidecarFiles = this.getSidecarFiles();
        var filesToLint = _.clone(sidecarFiles);
        filesToLint.push('!lib/**/*.min.js'); // ignore minified files
        filesToLint.push('!lib/!(sugar*)/**/*.js'); // ignore non-sugarcrm library files

        return filesToLint;
    },

    /**
     * A function that returns list of first party files.
     *
     * @returns {Array} List of files to be documented.
     */
    getFirstPartyFiles: function () {
        // FIXME SC-4937: hopefully when we implement webpack we can ditch this hardcoded list
        return [
            'src/**/*.js',
            'lib/sugaranalytics/*.js',
            'lib/sugarapi/sugarapi.js',
            'lib/sugarlogic/*.js',
        ];
    },
};
