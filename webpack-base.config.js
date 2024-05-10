/**
 * WEBPACK CONFIGURATION
 */
const path = require('path');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports.buildConfig = function (webpackVariables) {
    return {
        entry: webpackVariables.webpackParams.entryPath,
        output: {
            filename: webpackVariables.webpackParams.jsOutputPath,
            path: path.resolve(__dirname),
        },
        devtool: 'inline-source-map',
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
                                url: false,
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
