/**
 * WEBPACK CONFIGURATION
 */
const path = require('path');
const webpackBuildNotifierPlugin = require('webpack-build-notifier');
const uglifyJSPlugin = require('uglifyjs-webpack-plugin');
const miniCssExtractPlugin = require('mini-css-extract-plugin');
const cssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const {PurgeCSSPlugin} = require('purgecss-webpack-plugin');
const browserSyncPlugin = require('browser-sync-webpack-plugin')
const glob = require('glob');

module.exports.buildConfig = function (webpackVariables) {
    return {
        devtool: 'inline-source-map',
        entry: webpackVariables.webpackParams.entryPath,
        output: {
            filename: webpackVariables.webpackParams.jsOutputPath,
            path: path.resolve(__dirname),
        },
        module: {
            rules: [
                // perform js babelization on all .js files
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', {targets: "defaults"}]
                        ]
                    }
                },
                {
                    test: /\.js$/,
                    enforce: "pre",
                    use: ["source-map-loader"],
                },
                // inject CSS to page
                {
                    test: /\.css$/i,
                    use: [miniCssExtractPlugin.loader, 'style-loader', 'css-loader', 'postcss-loader']
                },

                // compile all .scss files to plain old css
                {
                    test: /\.(sass|scss)$/,
                    use: [
                        miniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                            },

                        },
                        {
                            loader: 'resolve-url-loader',
                            options: {
                                sourceMap: true,
                            },
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                },
                // Define fonts and images url from theme dir
                {
                    test: /\.(woff|woff2|eot|ttf|otf)$/,
                    loader: 'file-loader',
                    options: {
                        outputPath: webpackVariables.webpackParams.fontOutputPath,
                        name: '[name].[ext]'
                    }
                },
                {
                    test: /\.(png|svg|jpg|gif)$/,
                    loader: 'file-loader',
                    options: {
                        outputPath: webpackVariables.webpackParams.imageOutputPath,
                        name: '[name].[ext]'
                    }
                },
            ]
        },
        plugins: [
            // extract css into dedicated file
            new miniCssExtractPlugin({
                filename: webpackVariables.webpackParams.cssOutputPath,
            }),

            // notifier plugin
            new webpackBuildNotifierPlugin({
                title: "WP Webpack Build",
                suppressSuccess: true
            }),

            // remove unused css
            new PurgeCSSPlugin({
                paths: glob.sync(`${webpackVariables.webpackParams.entryPath}/**/*`, {nodir: true}),
            }),

            new browserSyncPlugin(
                // BrowserSync options
                {
                    // browse to http://localhost:3000/ during development, or replace with your local development url
                    // host: 'localhost',
                    // port: 3000,
                    // proxy the Webpack Dev Server endpoint
                    // (which should be serving on http://localhost:3100/)
                    // through BrowserSync
                    // proxy: 'http://localhost:3100/'
                },
                // plugin options
                {
                    // prevent BrowserSync from reloading the page
                    // and let Webpack Dev Server take care of this
                    reload: false
                }
            )
        ],
        optimization: {
            minimizer: [
                // enable the js minification plugin
                new uglifyJSPlugin({
                    cache: true,
                    parallel: true,
                    sourceMap: true,
                }),
                // enable the css minification plugin
                new cssMinimizerPlugin(),
            ]
        }
    }
};
