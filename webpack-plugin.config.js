/**
 * WEBPACK CONFIGURATION
 */

const baseConfig = require('./webpack-base.config');

const pluginVariables = require('./webpack-plugin.variables');

module.exports = function (env, argv) {
    return baseConfig.buildConfig(pluginVariables, argv.mode);
};