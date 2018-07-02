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

var GJSDuck = require('gulp-jsduck');
var _ = require('lodash');
var commander = require('commander');
var concat = require('gulp-concat');
var os = require('os');
var fs = require('fs');
var gjslint = require('gulp-gjslint');
var gulp = require('gulp');
var jscs = require('gulp-jscs');
var jshint = require('gulp-jshint');
var karma = require('karma').server;
var process = require('process');
var rename = require('gulp-rename');
var sourceMaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var file = require('gulp-file');

// retrieve sidecar files
var sidecarFiles = JSON.parse(fs.readFileSync('grunt/assets/files.json', 'utf8')).buildFiles.sidecar;
var sidecarLite = sidecarFiles.lite;
var sidecarFull = _.union(sidecarFiles.extra, sidecarLite);

var filesToLint = _.clone(sidecarLite);
filesToLint.push('!lib/**/*.min.js'); // ignore minified files

// FIXME SC-4937: hopefully when we implement webpack we can ditch this hardcoded list
var firstPartyFiles = [
    'src/**/*.js',
    'lib/sugaraccessibility/*.js',
    'lib/sugaranalytics/*.js',
    'lib/sugarapi/sugarapi.js',
    'lib/sugarlogic/*.js'
];

gulp.task('jscs', function() {
    return gulp.src(filesToLint)
        .pipe(jscs())
        .pipe(jscs.reporter());
    // FIXME SC-5268: add a fail reporter
});

gulp.task('jshint', function() {
    return gulp.src(filesToLint)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
        // FIXME SC-5062: once sidecar is jshint-compliant, we should add a "fail" reporter
});

gulp.task('gjslint', function() {
    return gulp.src(filesToLint)
        .pipe(gjslint({flags: ['--nojsdoc', '--max_line_length 120', '--disable 200']}))
        .pipe(gjslint.reporter('console'));
});

gulp.task('jsduck', function() {
    var options = [
        '--out',
        'docs',
        '--title=Sidecar Javascript Documentation',
        '--color',
        '--head-html=<link rel=\"stylesheet\" href=\"../../styleguide/assets/css/jsduck.css\" type=\"text/css\">',
        '--builtin-classes',
        '--external=jQuery' // FIXME SC-5047: we may need to add more types here
    ];
    var gjsduck = new GJSDuck(options);
    return gulp.src(firstPartyFiles)
        .pipe(gjsduck.doc());
});

gulp.task('build:min', function() {
    return gulp.src(sidecarFull, {base: 'sidecar'})
        .pipe(sourceMaps.init())
        .pipe(concat('sidecar.min.js'))
        .pipe(gulp.dest('minified'))
        .pipe(uglify({
            compress: false, // FIXME SC-4953 - compressor disabled for now for performance reasons
            mangle: false // Do not disable - without this, source maps break
        }))
        .pipe(sourceMaps.write('.', {
            sourceRoot: '../../'
        }))
        .pipe(gulp.dest('minified'));
});

gulp.task('build:full', function() {
    var jsArray = [
        '/*',
        ' * Your installation or use of this SugarCRM file is subject to the applicable',
        ' * terms available at',
        ' * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.',
        ' * If you do not agree to all of the applicable terms or do not have the',
        ' * authority to bind the entity as an authorized representative, then do not',
        ' * install or use this SugarCRM file.',
        ' *',
        ' * Copyright (C) SugarCRM Inc. All rights reserved.',
        ' */',
        '(function() {',
        '    var he = document.getElementsByTagName(\'head\')[0];',
        '    ',
        '    // We need a good URL to figure out where to get this stuff in the browser.',
        '    var sidecarUrl = \'sidecar/\';',
        '    var indexOfSugarCrm = location.pathname.indexOf("/sugarcrm");',
        '    if ( indexOfSugarCrm > -1 ) {',
        '        sidecarUrl = location.pathname.slice(0, indexOfSugarCrm) + "/sugarcrm/" + sidecarUrl;',
        '    }',
        '    ',
        '    function include(file) {',
        '        // Use docment.write to make sure files are loaded and parsed',
        '        // before any other scripts on the page.  We\'re not worried about',
        '        // performance for dev or for the config file.',
        '        document.write(\'<scr\' + \'ipt src="\' + file + \'" type="text/javascript"></scr\' + \'ipt>\');',
        '    }',
        '    ',
        '    '
    ];
    _.each(sidecarFull, function(jsFile) {
        jsArray.push('    include(sidecarUrl + \'' + jsFile + '\');');
    });
    jsArray.push('}());\n');
    return file('sidecar.js', jsArray.join('\n'), {src: true})
        .pipe(gulp.dest('minified'));
});

gulp.task('karma', function(done) {

    /**
     * Return the Karma options appropriate for the given options.
     * @param {string} mode One of 'ci', 'ci-coverage', 'coverage', 'dev',
     *   or 'sauce'.
     * @param {string} [path=os.tmpdir()] Path to output results to.
     * @param {string[]} [browsers] List of browsers to test in.
     */
    function makeKarmaOptions(mode, path, browsers) {
        path = path || os.tmpdir();

        // retrieve test data
        var karmaAssets = _.flatten([
            eval(fs.readFileSync('grunt/assets/base-files.js', 'utf8')),
            eval(fs.readFileSync('grunt/assets/default-tests.js', 'utf8'))
        ], true);

        var baseKarmaOptions = {
            files: karmaAssets,
            configFile: __dirname + '/grunt/karma.conf.js',
            browsers: ['PhantomJS'],
            autoWatch: false,
            singleRun: true
        };

        var junitReporter = {
            outputDir: path,
            outputFile: '/karma/sidecar/test-results.xml',
            useBrowserName: false
        };

        // determine mode-specific overrides
        var overrides;
        switch(mode) {
            case 'ci':
                overrides = {
                    junitReporter: junitReporter,
                    reporters: [
                        'dots',
                        'junit'
                    ]
                };
                break;
            case 'ci-coverage':
                overrides = {
                    preprocessors: {},
                    coverageReporter: {
                        reporters: [
                            {
                                type: 'cobertura',
                                dir: path + '/karma/sidecar/coverage-xml',
                                file: 'cobertura-coverage.xml',
                                subdir: function () {
                                    return '';
                                }
                            },
                            {
                                type: 'html',
                                dir: path + '/karma/sidecar/coverage-html'
                            }
                        ]
                    },
                    junitReporter: junitReporter,
                    reporters: [
                        'coverage',
                        'dots',
                        'junit'
                    ]
                };
                break;
            case 'coverage':
                overrides = {
                    preprocessors: {},
                    coverageReporter: {
                        reporters: [
                            {
                                type: 'text',
                                dir: path + '/karma/sidecar/coverage'
                            },
                            {
                                type: 'html',
                                dir: path + '/karma/sidecar/coverage-html'
                            }
                        ]
                    },
                    reporters: [
                        'coverage',
                        'dots'
                    ]
                };
                break;
            case 'dev':
                overrides = {
                    autoWatch: true,
                    browsers: ['Chrome'],
                    singleRun: false
                };
                break;
            case 'sauce':
                overrides = {
                    browsers: ['sl_safari'],
                    reporters: ['dots', 'saucelabs']
                };
                break;
        }

        var karmaOptions = _.extend(baseKarmaOptions, overrides);
        if (browsers) {
            karmaOptions.browsers = browsers;
        }
        return karmaOptions;
    }

    // get command-line arguments (only relevant for karma tests)
    commander
        .option('-d, --dev', 'Set Karma options for debugging')
        .option('--coverage', 'Enable code coverage')
        .option('--ci-coverage', 'Enable code coverage, optimized for CI')
        .option('--path <path>', 'Set base output path')
        .option('--browsers <list>',
                'Comma-separated list of browsers to run tests with',
                function(val) { return val.split(','); })
        .option('--sauce', 'Run Safari tests on SauceLabs')
        .parse(process.argv);

    // determine what test mode we want
    var mode = 'ci';
    if (commander.dev) {
        mode = 'dev';
    } else if (commander.coverage) {
        mode = 'coverage';
    } else if (commander.ciCoverage) {
        mode = 'ci-coverage';
    } else if (commander.sauce) {
        mode = 'sauce';
    }

    // set up Karma
    var karmaOptions = makeKarmaOptions(mode, commander.path, commander.browsers);

    if (commander.coverage || commander.ciCoverage) {
        // add all of our first-party files to the list of files to use code coverage on
        _.each(firstPartyFiles, function(fileString) {
            karmaOptions.preprocessors[fileString] = ['coverage'];
        });

        process.stdout.write('[' + karmaOptions.coverageReporter.type + '] ' +
            'Coverage report will be generated to: ' +
            karmaOptions.coverageReporter.reporters[1].dir + '\n');
    }

    return karma.start(karmaOptions, function() {
        // wrapping this in a function avoids showing an unwanted stack trace.
        // https://stackoverflow.com/questions/26614738/issue-running-karma-task-from-gulp
        done();
    });
});

gulp.task('lint', ['jscs', 'jshint', 'gjslint']);
gulp.task('build', ['build:min', 'build:full']);
gulp.task('default', ['jshint', 'build']);
