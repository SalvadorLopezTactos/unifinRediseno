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

var webpack = require('webpack');
var path = require('path');

module.exports = {
    devtool: 'source-map',

    entry: {
        sidecar: [
            'entry.js',
        ],
    },

    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /(node_modules|lib)/,
                loader: 'babel',
                query: {
                    presets: ['es2015']
                },
            },
        ],
    },

    output: {
        path: __dirname + '/minified',
        filename: '[name].min.js',
        sourceMapFilename: '[name].min.js.map',
        // map the path correctly to avoid being inside of webpack://
        devtoolModuleFilenameTemplate: "sidecar:///[resourcePath]",
        devtoolFallbackModuleFilenameTemplate: "sidecar:///[resourcePath]?[hash]",
    },

    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            compress: false, // FIXME SC-4953 - compressor disabled for now for performance reasons
            mangle: false, // Do not disable - without this, source maps break
        }),
    ],

    resolve: {
        root: [
            path.resolve(__dirname, 'src'),
            path.resolve(__dirname, 'lib'),
            path.resolve(__dirname, 'node_modules')
        ],
        modulesDirectories: [
            'node_modules'
        ],
        extensions: [
            '', '.js', '.json'
        ],
    },
}
