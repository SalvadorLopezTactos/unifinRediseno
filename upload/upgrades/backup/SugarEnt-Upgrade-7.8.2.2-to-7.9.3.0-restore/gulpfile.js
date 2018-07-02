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
var commander = require('commander');
var fs = require('fs');
var filter = require('gulp-filter');
var glob = require('glob');
var gulp = require('gulp');
var gutil = require('gulp-util');
var os = require('os');
var todo = require('gulp-todo');

/**
 * A function that returns an object from a given JSON filename, which will also strip comments.
 *
 * @param {string} filename Filename to parse.
 *
 * @returns {Object} Parsed file.
 */
function readJSONFile(filename) {
    var stripJsonComments = require('strip-json-comments');
    return JSON.parse(stripJsonComments(fs.readFileSync(filename, 'utf8')));
}

/**
 * A function that returns list of first party files.
 *
 * @returns {Array} List of files to be documented.
 */
function getFirstPartyFiles() {
    return [
        'clients/base/**/*.js',
        'include/javascript/sugar7/**/*.js',
        'modules/**/clients/base/**/*.js',
    ];
}

function splitByCommas(val) {
    return val.split(',');
}

gulp.task('karma', function(done) {
    var Server = require('karma').Server;

    // get command-line arguments for karma tests
    commander
        .option('-d, --dev', 'Set Karma options for debugging')
        .option('--coverage', 'Enable code coverage')
        .option('--ci', 'Enable CI specific options')
        .option('--path <path>', 'Set base output path')
        .option('--manual', 'Start Karma and wait for browser to connect (manual tests)')
        .option('--team <name>', 'Filter by specified team', splitByCommas)
        .option('--browsers <list>',
            'Comma-separated list of browsers to run tests with',
            splitByCommas
        )
        .option('--sauce', 'Run IE 11 tests on SauceLabs. Not compatible with --dev option')
        .parse(process.argv);

    // set up default Karma options
    var baseFiles = readJSONFile('gulp/assets/base-files.json');
    var tests = [];

    if (commander.team) {
        var teams = readJSONFile('../.mention-bot').alwaysNotifyForPaths;
        var team = _.findWhere(teams, {name: 'sugarcrm/eng-' + commander.team});

        if (!team) {
            return done('Cannot find the specified team');
        } else {
            process.stdout.write('Preparing tests for team `' + commander.team + '`...\n');
        }

        tests = _.reduce(team.files, function(memo, value) {
            if (!value.endsWith('**') && !value.endsWith('js')) {
                return memo;
            }

            if (value.endsWith('**')) {
                value = value + '/*.js';
            }

            if (value.startsWith('sugarcrm/tests/')) {
                value = value.replace(/^sugarcrm\//, '');
            } else {
                // TODO: As soon as most of the teams add their tests to mentionbot, we will remove this
                value = value.replace(/^sugarcrm/, 'tests');
            }

            memo.push(value);
            return memo;
        }, []);

        // Need to filter these before passing to karma to avoid warnings
        tests = _.filter(tests, function(pattern) {
            return !_.isEmpty(glob.sync(pattern));
        });
    } else {
        tests = readJSONFile('gulp/assets/default-tests.json');
    }

    if (_.isEmpty(tests)) {
        return done('There are no tests defined for the current settings.');
    }

    var karmaAssets = _.flatten([
        baseFiles,
        tests
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
    path += '/karma';

    karmaOptions.preprocessors = {};
    _.each(getFirstPartyFiles(), function(value) {
        karmaOptions.preprocessors[value] = [];
    });

    if (commander.browsers) {
        karmaOptions.browsers = commander.browsers;
    }

    if (commander.coverage) {
        _.each(karmaOptions.preprocessors, function(value, key) {
            karmaOptions.preprocessors[key].push('coverage');
        });

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

    new Server(karmaOptions, function(exitStatus) {
        // Karma's return status is not compatible with gulp's streams
        // See: http://stackoverflow.com/questions/26614738/issue-running-karma-task-from-gulp
        // or: https://github.com/gulpjs/gulp/issues/587 for more information
        done(exitStatus ? 'There are failing unit tests' : undefined);
    }).start();
});

// run the modern PHPUnit tests (i.e. testsunit/, not tests/)
gulp.task('test:unit:php', function(done) {
    var path = require('path');

    /**
     * Set up the environment for Jenkins.
     *
     * @param {string} workspace Base output directory.
     */
    function setUpCiConfiguration(workspace) {
        var rm = require('rimraf').sync;

        var testOutputPath = path.join(workspace, 'test-output');
        var junitOutputPath = path.join(workspace, 'junit');
        rm(testOutputPath);
        rm(junitOutputPath);
        fs.mkdirSync(testOutputPath);
        fs.mkdirSync(junitOutputPath);
    }

    commander
        .option('--ci', 'Set up CI-specific environment')
        .option('--path <path>', 'Set base output path')
        .option('--coverage', 'Enable code coverage')
        .parse(process.argv);

    var workspace = commander.path || process.env.WORKSPACE || os.tmpdir();
    var args = [];
    if (commander.ci) {
        setUpCiConfiguration(workspace);
        args.push(
            '-derror_log=' + path.join(workspace, 'test-output', 'php_errors.log'),
            '--log-tap', path.join(workspace, 'test-output', 'tap.txt'),
            '--log-junit', path.join(workspace, 'junit', 'phpunit.xml'),
            '--testdox-text', path.join(workspace, 'testdox.txt')
        );
    }

    if (commander.coverage) {
        args.push('--coverage-html', path.join(workspace, 'coverage'));
        process.stdout.write('Coverage reports will be generated to: ' + path.join(workspace, 'coverage') + '\n');
    }

    var execa = require('execa');
    var phpunitPath = path.join('..', 'vendor', 'bin', 'phpunit');
    var phpProcess = execa(phpunitPath, args, {
        maxBuffer: 1e6, // 1 MB
        cwd: 'testsunit',
        reject: false,
    });
    phpProcess.stdout.pipe(process.stdout);
    phpProcess.stderr.pipe(process.stderr);
    phpProcess.then(function(result) {
        done(result.code ? 'There are failing unit tests' : undefined);
    });
});

// confirm our files have the desired license header
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
        whiteList: 'gulp/assets/check-license/license-white-list.json'
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
    pattern = pattern.replace(/\n/g, '\\s');
    pattern = pattern.replace(/\(/g, '\\(');
    pattern = pattern.replace(/\)/g, '\\)');

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
        if (stderr.length !== 0) {
            done(stderr);
        } else if (stdout.length !== 0) {
            // Invalid license headers found
            done(stdout);
        } else {
            // All files have the exact license specified in `sugarcrm/LICENSE`
            done();
        }
    });
});

function getFilesToLint() {
    return _.union(
        ['**/*.js'],
        _.map(require('./.jscs.json').excludeFiles, function(str) {
            return '!' + str;
        })
    );
}

gulp.task('jscs', function() {
    var jscs = require('gulp-jscs');
    return gulp.src(getFilesToLint())
        .pipe(jscs())
        .pipe(jscs.reporter());
});

gulp.task('jshint', function() {
    var jshint = require('gulp-jshint');
    return gulp.src(getFilesToLint())
        .pipe(jshint())
        .pipe(jshint.reporter());
});

gulp.task('lint', ['jshint', 'jscs']);

gulp.task('find-todos', function() {
    var teams = require('./gulp/plugins/team/team.js');
    commander
        .option('--teams <list>', 'Choose teams to filter by', splitByCommas)
        .option('--path <path>', 'Set output path')
        .parse(process.argv);
    var destPath = commander.path || os.tmpdir();
    console.log('Results will be output to ' + destPath + '/TODO.md');
    var teamsChosen = commander.teams;
    try {
        return gulp.src('**/*.{js,php}')
            .pipe(!_.isEmpty(teamsChosen) ? filter(teams(teamsChosen)) : gutil.noop())
            .pipe(todo())
            .pipe(gulp.dest(destPath));
    } catch (e) {
        console.error(e.toString());
    }
});
