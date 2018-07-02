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

var _ = require('lodash');
var commander = require('commander');
var fs = require('fs');
var gulp = require('gulp');
var gutil = require('gulp-util');
var karma = require('karma').server;
var os = require('os');

function splitByCommas(val) {
    return val.split(',');
}

gulp.task('karma', function(done) {

    // get command-line arguments (only relevant for karma tests)
    commander
        .option('-d, --dev', 'Set Karma options for debugging')
        .option('--coverage', 'Enable code coverage')
        .option('--ci', 'Enable CI specific options')
        .option('--path <path>', 'Set base output path')
        .option('--browsers <list>',
            'Comma-separated list of browsers to run tests with',
            splitByCommas
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
    path += '/karma';

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
        // and 60 seconds of timeout seems to be normal...
        karmaOptions.browserNoActivityTimeout = 60000;
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

gulp.task('check-license', function(done) {
    var options = {
        excludedExtensions: [
            'json',
            'swf',
            'log',
            // image files
            'gif',
            'jpeg',
            'jpg',
            'png',
            'ico',
            // special system files
            'DS_Store',
            // Doc files
            'md',
            'txt',
            // vector files
            'svg',
            'svgz',
            // font files
            'eot',
            'ttf',
            'woff',
            'otf',
            // stylesheets
            'less',
            'css'
        ],
        licenseFile: 'LICENSE',
        // Add paths you want to exclude in the whiteList file.
        whiteList: 'grunt/assets/check-license/license-white-list.json'
    };

    var exec = require('child_process').exec;

    var licenseFile = options.licenseFile;
    var whiteList = options.whiteList;
    var excludedExtensions = options.excludedExtensions.join('|');

    //Prepares excluded files.
    var excludedFiles = JSON.parse(fs.readFileSync(whiteList, 'utf8'));
    excludedFiles = _.map(excludedFiles, function(f) {
        return './' + f;
    }).join('\\n');

    var pattern = fs.readFileSync(licenseFile).toString();
    pattern = pattern.trim();

    //Add '*' in front of each line.
    pattern = pattern.replace(/\n/g, '\n \*');
    //Add comment token at the beginning and the end of the text.
    pattern = pattern.replace(/^/, '/\*\n \*');
    pattern = pattern.replace(/$/, '\n \*/');
    //Put spaces after '*'.
    pattern = pattern.replace(/\*(?=\w)/g, '\* ');

    // Prepares the PCRE pattern.
    pattern = pattern.replace(/\*/g, '\\*');
    // Ignore CRLF files
    pattern = pattern.replace(/\n/g, '\\s*');
    pattern = pattern.replace(/\(/g, '\\(');
    pattern = pattern.replace(/\)/g, '\\)');

    // Ignore if license isn't with the correct spacing
    pattern = pattern.replace(/\\s\* \\\*/g, '\\s*\\s*\\\*');

    // Ignore last CRLF line of the license
    pattern += '\\s*';

    var cmdOptions = [
        '--buffer-size=10M',
        '-M',
        // The output will be a list of files that don't match the pattern.
        '-L',
        // Recursive mode.
        '-r',
        // Ignores case.
        '-i',
        // Excluded extensions.
        '--exclude="((.*)\.(' + excludedExtensions + '))"',
        // Pattern to match in each file.
        '"^' + pattern + '$"',
        // Directory where the command is executed.
        '.'
    ];

    var command = 'pcregrep ' + cmdOptions.join(' ') + '| grep -v -F "$( printf \'' + excludedFiles + '\' )"';

    // Runs the command.
    exec(command, {maxBuffer: 2000 * 1024}, function(error, stdout, stderr) {
        if (stderr.length != 0) {
            done(stderr);
        } else if (stdout.length != 0) {
            // Invalid license headers found
            done(stdout);
        } else {
            // All files have the exact license specified in `sugarcrm/LICENSE`
            done();
        }
    });
});
