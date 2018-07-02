/*
     YUI 3.15.0 (build 834026e)
     Copyright 2014 Yahoo! Inc. All rights reserved.
     Licensed under the BSD License.
     http://yuilibrary.com/license/
     */
YUI.add('classnamemanager',function(Y,NAME){var CLASS_NAME_PREFIX='classNamePrefix',CLASS_NAME_DELIMITER='classNameDelimiter',CONFIG=Y.config;CONFIG[CLASS_NAME_PREFIX]=CONFIG[CLASS_NAME_PREFIX]||'yui3';CONFIG[CLASS_NAME_DELIMITER]=CONFIG[CLASS_NAME_DELIMITER]||'-';Y.ClassNameManager=function(){var sPrefix=CONFIG[CLASS_NAME_PREFIX],sDelimiter=CONFIG[CLASS_NAME_DELIMITER];return{getClassName:Y.cached(function(){var args=Y.Array(arguments);if(args[args.length-1]!==true){args.unshift(sPrefix);}else{args.pop();}
return args.join(sDelimiter);})};}();},'3.15.0',{"requires":["yui-base"]});