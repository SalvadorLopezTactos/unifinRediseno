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

var runner = require('karma').runner;
var server = require('karma').server;
var os = require('os');
var path = require('path');
var _ = require('lodash');

module.exports = function(grunt) {

    grunt.registerMultiTask('karma', 'Karma task.', function() {
        var targetOptions = grunt.config.get([this.name, this.target].join('.'));
        if (targetOptions.reporters && _.contains(targetOptions.reporters, 'coverage')) {
            var preProcessors = loadAsset('default-pre-processors', this.options());

            grunt.config.set([this.name, 'options', 'preprocessors'].join('.'), preProcessors);

            var reporters = targetOptions.coverageReporter.reporters;
            if (reporters) {
                _.each(reporters, function(reporter) {
                    if (!reporter.dir || (reporter.type === 'text' && !reporter.file)) {
                        return;
                    }

                    grunt.log.ok('[' + reporter.type + '] Coverage report will be generated to: ' + reporter.dir);
                });
            }
        }

        var baseFiles = loadAsset('base-files', this.options()),
            files = _.union(baseFiles, loadAsset('default-tests', this.options()));

        grunt.config.set([this.name, 'options', 'files'].join('.'), files);

        karmaOriginal = _.bind(karmaOriginal, this);
        karmaOriginal();
    });

    /**
     * Load asset content.
     *
     * @param {String} name Asset name.
     * @param {Object} [options] Asset options, including `assetsDir`.
     * @return {Object} Asset content.
     */
    loadAsset = function(name, options) {
        var dir = options && options.assetsDir.replace(/\/+$/, '') || '.',
            asset = dir + '/' + name + '.js';

        return eval(readFile(asset));
    };

    /**
     * Read file content.
     *
     * @param {String} file File path.
     * @return {String} File content.
     */
    readFile = function(file) {
        if (!grunt.file.exists(file)) {
            grunt.log.debug('Failed to load file: ' + file);
            return '';
        }

        var content = grunt.file.read(file);

        grunt.log.debug('Loaded file: ' + file);

        return content;
    };

    /**
     * Copy of the karma task available on grunt-karma plugin version 0.9.0.
     */
    karmaOriginal = function() {
        var done = this.async();
        var options = this.options({
            background: false
        });

        if (!options.client) {
            options.client = {};
        }

        // Merge karma default options
        _.defaults(options.client, {
            args: [],
            useIframe: true,
            captureConsole: true
        });

        var opts = _.cloneDeep(options);
        // Merge options onto data, with data taking precedence.
        var data = _.merge(opts, this.data);

        // Allow for passing cli arguments compatible with the ones Karma
        // supports originally
        var args = parseArgs(process.argv.slice(2));

        // override data with supplied CLI arguments
        data = _.merge(data, args);

        // Merge client.args
        if (this.data.client && _.isArray(this.data.client.args)) {
            data.client.args = this.data.client.args.concat(options.client.args);
        }

        if (data.configFile) {
            data.configFile = path.resolve(data.configFile);
            data.configFile = grunt.template.process(data.configFile);
        }

        if (data.files) {
            data.files = _.flatten(data.files);
        }

        //support `karma run`, useful for grunt watch
        if (this.flags.run) {
            runner.run(data, finished.bind(done));
            return;
        }

        //allow karma to be run in the background so it doesn't block grunt
        if (data.background) {
            var backgroundArgs = {
                cmd: 'node',
                args: process.execArgv.concat([path.join(__dirname, '..', 'lib', 'background.js'), JSON.stringify(data)])
            };
            var backgroundProcess = grunt.util.spawn(backgroundArgs, function(error) {
                if (error) {
                    grunt.log.error(error);
                }
            });
            process.on('exit', function() {
                backgroundProcess.kill();
            });
            done();
        }
        else {
            server.start(data, finished.bind(done));
        }
    }
};

function finished(code){ return this(code === 0); }

// Parse out all cli arguments in the form of `--arg something` and return the
// array.
function parseArgs(args) {
    var params = {},
        lastArg = '';

    _.each(args, function(arg) {
        if (arg.match(/^--/)) {
            lastArg = arg;
            return; // continue
        }

        if (!_.isEmpty(lastArg)) {
            params[lastArg.substr(2)] = arg.split(',');
            lastArg = '';
        }
    });

    return params;
}
