/**
 * WEBPACK CONFIGURATION
 */
const baseConfig = require('./webpack-base.config');

// include webpack variables
const pluginVariableds = require('./webpack-plugin.variables');

module.exports = baseConfig.buildConfig(pluginVariableds);
