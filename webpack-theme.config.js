/**
 * WEBPACK CONFIGURATION
 */

const baseConfig = require('./webpack-base.config');

const themeVariables = require('./webpack-theme.variables');

module.exports = function (env, argv) {
    return baseConfig.buildConfig(themeVariables, argv.mode);
};