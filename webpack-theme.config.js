/**
 * WEBPACK CONFIGURATION
 */
const baseConfig = require('./webpack-base.config');

// include webpack variables
const themeVariableds = require('./webpack-theme.variables');

module.exports = baseConfig.buildConfig(themeVariableds);
