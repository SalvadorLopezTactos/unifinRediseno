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
var babel = require('gulp-babel');
var commander = require('commander');
var concat = require('gulp-concat');
var os = require('os');
var gulp = require('gulp');
var jscs = require('gulp-jscs');
var jshint = require('gulp-jshint');
var process = require('process');
var sourceMaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');
var utils = require('./gulp/util.js');
var webpack = require('webpack');

gulp.task('jscs', function () {
    var filesToLint = utils.getFilesToLint();

    return gulp.src(filesToLint)
        .pipe(jscs())
        .pipe(jscs.reporter());

    // FIXME SC-5268: add a fail reporter
});

gulp.task('jshint', function () {
    var filesToLint = utils.getFilesToLint();

    return gulp.src(filesToLint)
        .pipe(jshint({
            esversion: 6,
        }))
        .pipe(jshint.reporter('default'))
        .pipe(jshint.reporter('fail'));
});

gulp.task('doc', function (cb) {
    var jsdoc = require('gulp-jsdoc3');
    var jsdocConfig = require('./jsdoc.json');
    var firstPartyFiles = utils.getFirstPartyFiles();

    gulp.src(['README.md'].concat(firstPartyFiles), { read: false })
        .pipe(jsdoc(jsdocConfig, cb));
});

gulp.task('watch', function () {
    var sidecarFiles = utils.getSidecarFiles();

    watch(sidecarFiles, function () {
        gulp.start('build');
    });
});

gulp.task('build:min', function() {
    var sidecarFiles = utils.getSidecarFiles();

    return gulp.src(sidecarFiles, {base: 'sidecar'})
        .pipe(sourceMaps.init())
        .pipe(babel({
            only: utils.getFirstPartyFiles(),
            presets: ['es2015'],
        }))
        .pipe(concat('sidecar.min.js'))
        .pipe(uglify({
            compress: false, // FIXME SC-4953 - compressor disabled for now for performance reasons
            mangle: false // Do not disable - without this, source maps break
        }))
        .pipe(sourceMaps.write('.'))
        .pipe(gulp.dest('minified'));
});

gulp.task('build', function (done) {
    return webpack(require('./webpack.config.js'), function (err) {
        return done(err ? err : undefined);
    });
});

gulp.task('karma', function(done) {

    var Server = require('karma').Server;

    // get command-line arguments (only relevant for karma tests)
    commander
        .option('--zepto', 'Use zepto instead of jQuery')
        .option('-d, --dev', 'Set Karma options for debugging')
        .option('--coverage', 'Enable code coverage')
        .option('--ci', 'Enable CI specific options')
        .option('--path <path>', 'Set base output path')
        .option('--manual', 'Start Karma and wait for browser to connect (manual tests)')
        .option('--browsers <list>',
            'Comma-separated list of browsers to run tests with',
            function (val) {
                return val.split(',');
            }
        )
        .option('--sauce', 'Run IE 11 tests on SauceLabs. Not compatible with --dev option')
        .parse(process.argv);

    // set up default Karma options
    var defaultTests = utils.readJSONFile('gulp/assets/default-tests.json');
    var firstPartyFiles = utils.getFirstPartyFiles();

    var karmaAssets = _.flatten([
        utils.readJSONFile('gulp/assets/' + (commander.zepto ? 'zepto' : 'jquery') + '.json'),
        utils.readJSONFile('gulp/assets/base-files.json'),
        defaultTests,
    ], true);

    var karmaOptions = {
        files: karmaAssets,
        configFile: __dirname + '/gulp/karma.conf.js',
        browsers: ['PhantomJS'],
        autoWatch: false,
        singleRun: true,
        reporters: ['dots'],
    };

    var path = commander.path || os.tmpdir();
    path += '/karma/sidecar';

    if (commander.browsers) {
        karmaOptions.browsers = commander.browsers;
    }

    karmaOptions.preprocessors = {};
    _.each(_.union(firstPartyFiles, defaultTests), function (value) {
        karmaOptions.preprocessors[value] = ['babel'];
    });

    if (commander.coverage) {
        _.each(firstPartyFiles, function (value) {
            karmaOptions.preprocessors[value].push('coverage');
        });

        karmaOptions.reporters.push('coverage');

        karmaOptions.coverageReporter = {
            reporters: [
                {
                    type: 'cobertura',
                    dir: path + '/coverage-xml',
                    file: 'cobertura-coverage.xml',
                    subdir: function () {
                        return '';
                    },
                },
                {
                    type: 'html',
                    dir: path + '/coverage-html',
                },
            ],
        };

        process.stdout.write('Coverage reports will be generated to: ' + path + '\n');
    }

    if (commander.ci) {
        karmaOptions.reporters.push('junit');

        karmaOptions.junitReporter = {
            outputDir: path,
            outputFile: 'test-results.xml',
            useBrowserName: false,
        };
    }

    if (commander.manual) {
        karmaOptions.browsers = [];
        karmaOptions.singleRun = false;
        karmaOptions.autoWatch = true;
    } else if (commander.dev) {
        karmaOptions.autoWatch = true;
        karmaOptions.singleRun = false;
        if (!commander.browsers) {
            karmaOptions.browsers = ['Chrome'];
        }
    } else if (commander.sauce) {
        // --dev isn't supported for --sauce
        karmaOptions.reporters.push('saucelabs');
        karmaOptions.browsers = ['sl_ie'];

        // sauce is slower than local runs...
        karmaOptions.reportSlowerThan = 2000;

        // and 60 seconds of timeout seems to be normal...
        karmaOptions.browserNoActivityTimeout = 60000;
    }

    new Server(karmaOptions, function (exitStatus) {
        // Karma's return status is not compatible with gulp's streams
        // See: http://stackoverflow.com/questions/26614738/issue-running-karma-task-from-gulp
        // or: https://github.com/gulpjs/gulp/issues/587 for more information
        done(exitStatus ? 'There are failing unit tests' : undefined);
    }).start();
});

gulp.task('lint', ['jscs', 'jshint']);
gulp.task('default', ['jshint', 'build']);
