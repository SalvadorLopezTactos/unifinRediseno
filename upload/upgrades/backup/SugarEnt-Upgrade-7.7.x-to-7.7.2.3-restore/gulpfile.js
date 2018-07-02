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
var _=require('lodash');var commander=require('commander');var fs=require('fs');var gulp=require('gulp');var karma=require('karma').server;var os=require('os');gulp.task('karma',function(done){commander.option('-d, --dev','Set Karma options for debugging').option('--path <path>','Set code coverage path (implies --coverage)').option('--browsers <list>','Comma-separated list of browsers to run tests with',function(val){return val.split(',');}).parse(process.argv);var coverageRoot=os.tmpdir();if(commander.path){commander.coverage=true;coverageRoot=commander.path;}
var karmaAssets=_.flatten([eval(fs.readFileSync('grunt/assets/base-files.js','utf8')),eval(fs.readFileSync('grunt/assets/default-tests.js','utf8'))],true);var karmaOptions={files:karmaAssets,autoWatch:false,browsers:commander.browsers||['PhantomJS'],configFile:__dirname+'/grunt/karma.conf.js',singleRun:true,reporters:['dots']};if(commander.dev){karmaOptions.browsers=commander.browsers||['Chrome'];karmaOptions.autoWatch=true;karmaOptions.singleRun=false;}
return karma.start(karmaOptions,function(){done();});});