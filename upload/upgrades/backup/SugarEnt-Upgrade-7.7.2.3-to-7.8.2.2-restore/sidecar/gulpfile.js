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

gulp.task('karma', function(done) {

    // get command-line arguments (only relevant for karma tests)
    commander
        .option('-d, --dev', 'Set Karma options for debugging')
        .option('--coverage', 'Enable code coverage')
        .option('--ci', 'Enable CI specific options')
        .option('--path <path>', 'Set base output path')
        .option('--browsers <list>',
            'Comma-separated list of browsers to run tests with',
            function (val) {
                return val.split(',');
            }
        )
        .option('--sauce', 'Run IE 11 tests on SauceLabs. Not compatible with --dev option')
        .parse(process.argv);

    // set up default Karma options
    eval('var baseFiles = ' + fs.readFileSync('grunt/assets/base-files.js', 'utf8'));
    eval('var defaultTests = ' + fs.readFileSync('grunt/assets/default-tests.js', 'utf8'));
    var karmaAssets = _.flatten([
        baseFiles,
        defaultTests
    ], true);

    var karmaOptions = {
        files: karmaAssets,
        configFile: __dirname + '/grunt/karma.conf.js',
        browsers: ['PhantomJS'],
        autoWatch: false,
        singleRun: true,
        reporters: ['dots'],
    };

    var path = commander.path || os.tmpdir();
    path += '/karma/sidecar';

    if (commander.dev) {
        karmaOptions.autoWatch = true;
        karmaOptions.singleRun = false;
        karmaOptions.browsers = ['Chrome'];
    } else if (commander.sauce) {
        // --dev isn't supported for --sauce
        karmaOptions.reporters.push('saucelabs');
        karmaOptions.browsers = ['sl_ie'];

        // sauce is slower than local runs...
        karmaOptions.reportSlowerThan = 2000;
    }

    if (commander.browsers) {
        karmaOptions.browsers = commander.browsers;
    }

    if (commander.coverage) {

        eval('karmaOptions.preprocessors = ' + fs.readFileSync('grunt/assets/default-pre-processors.js', 'utf-8'));
        karmaOptions.reporters.push('coverage');

        karmaOptions.coverageReporter = {
            reporters: [
                {
                    type: 'cobertura',
                    dir: path + '/coverage-xml',
                    file: 'cobertura-coverage.xml',
                    subdir: function() {
                        return '';
                    }
                },
                {
                    type: 'html',
                    dir: path + '/coverage-html'
                }
            ]
        };

        process.stdout.write('Coverage reports will be generated to: ' + path + '\n');
    }

    if (commander.ci) {
        karmaOptions.reporters.push('junit');

        karmaOptions.junitReporter = {
            outputDir: path,
            outputFile: '/test-results.xml',
            useBrowserName: false
        };
    }

    return karma.start(karmaOptions, function(exitStatus) {
        // Karma's return status is not compatible with gulp's streams
        // See: http://stackoverflow.com/questions/26614738/issue-running-karma-task-from-gulp
        // or: https://github.com/gulpjs/gulp/issues/587 for more information
        done(exitStatus ? 'There are failing unit tests' : undefined);
    });
});

gulp.task('lint', ['jscs', 'jshint', 'gjslint']);
gulp.task('build', ['build:min']);
gulp.task('default', ['jshint', 'build']);
