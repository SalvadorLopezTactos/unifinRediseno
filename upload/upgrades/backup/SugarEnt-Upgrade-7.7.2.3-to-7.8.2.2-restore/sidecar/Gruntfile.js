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

var os = require('os');

module.exports = function(grunt) {
    grunt.loadTasks('grunt/tasks');
    grunt.loadNpmTasks('grunt-jsduck');
    grunt.loadNpmTasks('grunt-gjslint');
    grunt.loadNpmTasks('grunt-contrib-jshint');

    var path = grunt.option('path');
    path = path && path.replace(/\/+$/, '') + '/' || os.tmpdir();

    grunt.initConfig({
        // FIXME SC-4937: replace this hardcoded list with webpack
        files: grunt.file.readJSON('grunt/assets/files.json'),
        karma: {
            options: {
                assetsDir: 'grunt/assets',
                autoWatch: false,
                browsers: ['PhantomJS'],
                configFile: 'grunt/karma.conf.js',
                singleRun: true
            },
            dev: {
                autoWatch: true,
                browsers: ['Chrome'],
                singleRun: false
            },
            sauce: {
                browsers: ['sl_safari'],
                reporters: ['dots', 'saucelabs'],
                singleRun: true
            },
            coverage: {
                coverageReporter: {
                    reporters: [
                        {type: 'html', dir: path + '/karma/sidecar/coverage-html'},
                        {type: 'text', dir: path + '/karma/sidecar/coverage'}
                    ]
                },
                reporters: [
                    'coverage',
                    'dots'
                ]
            },
            ci: {
                junitReporter: {
                    outputDir: path,
                    outputFile: '/karma/sidecar/test-results.xml',
                    useBrowserName: false
                },
                reporters: [
                    'dots',
                    'junit'
                ]
            },
            'ci-coverage': {
                coverageReporter: {
                    subdir: '',
                    reporters: [
                        {
                            type: 'cobertura',
                            dir: path + '/karma/sidecar/coverage-xml',
                            file: 'cobertura-coverage.xml',
                            subdir: function() {return '';}
                        },
                        {
                            type: 'html',
                            dir: path + '/karma/sidecar/coverage-html',
                            subdir: function() {return '';}
                        }
                    ]
                },
                junitReporter: {
                    outputDir: path,
                    outputFile: '/karma/sidecar/test-results.xml',
                    useBrowserName: false
                },
                reporters: [
                    'coverage',
                    'dots',
                    'junit'
                ]
            }
        },
        jsduck: {
            sidecar: {
                src: [
                    'src/**/*.js',
                    'lib/sugaraccessibility/*.js',
                    'lib/sugaranalytics/*.js',
                    'lib/sugarapi/sugarapi.js',
                    'lib/sugarlogic/*.js'
                ],

                dest: 'docs',

                options: {
                    'title': 'Sidecar Javascript Documentation',
                    'color': true,
                    'head-html': '<link rel="stylesheet" href="../../styleguide/assets/css/jsduck.css" type="text/css">',
                    'builtin-classes': true,
                    'external': 'jQuery'
                }
            }
        },
        gjslint: {
            options: {
                flags: [
                    '--max_line_length=120',
                    '--disable 200' // ignore jsdoc errors, since we use jsduck
                ],
                reporter: {
                    name: 'console'
                },
                pythonPath: 'python2', // some Linux distros make "python" Python 3 by default
                force: false
            },
            lite: {
                src: ['<%= files.buildFiles.sidecar.lite %>', '!lib/**/*.min.js']
            }
        },
        jshint: {
            options: {
                force: true, // FIXME SC-4939: once all of our code is compliant, this should be set to false
            },
            lite: '<%= gjslint.lite.src %>'
        }
    });

    grunt.registerTask('lint', ['jshint', 'gjslint']);
};
