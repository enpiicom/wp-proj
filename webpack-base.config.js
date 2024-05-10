/**
 * WEBPACK CONFIGURATION
 */
const path = require('path');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

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
                {
                    test: /\.tsx?$/,
                    use: 'ts-loader',
                    exclude: /node_modules/,
                },
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
                    use: [MiniCssExtractPlugin.loader, 'style-loader', 'css-loader', 'postcss-loader']
                },

                // compile all .scss files to plain old css
                {
                    test: /\.(sass|scss)$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                                url: false,
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
            ]
        },
        resolve: {
            extensions: ['.ts', '.tsx', '.js'],
        },
        plugins: [
            // extract css into dedicated file
            new MiniCssExtractPlugin({
                filename: webpackVariables.webpackParams.cssOutputPath,
            }),

            // notifier plugin
            new WebpackBuildNotifierPlugin({
                title: "WP Webpack Build",
                suppressSuccess: true
            }),

            new BrowserSyncPlugin(
                // BrowserSync options
                {
                    // browse to http://localhost:3000/ during development, or replace with your local development url
                    host: 'localhost',
                    port: 3000,
                    // proxy the Webpack Dev Server endpoint
                    // (which should be serving on http://localhost:3100/)
                    // through BrowserSync
                    proxy: 'http://localhost:3100/'
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
            minimize: true,
            minimizer: [
                // enable the js minification plugin
                new TerserPlugin({
                    parallel: true,
                    terserOptions: {
                        sourceMap: true,
                        compress: true,
                    },
                    extractComments: true,
                }),
                // enable the css minification plugin
                new CssMinimizerPlugin(),
            ]
        }
    }
};
