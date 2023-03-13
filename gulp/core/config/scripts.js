var TerserPlugin = require('terser-webpack-plugin');
var ESLintPlugin = require('eslint-webpack-plugin');

// utils
var deepMerge = require('../utils/deepMerge');

// config
var assets = require('./common').paths.assets;

/**
 * Script Building
 * Configuration
 * Object
 *
 * @type {{}}
 */
module.exports = deepMerge({
	paths: {
		watch: assets.src + '/js/**/*.js',
		src: [
			assets.src + '/js/*.js',
			'!' + assets.src + '/js/**/_*'
		],
		dest: assets.dest + '/js',
		clean: assets.dest + '/js/**/*.{js,map}'
	},

	options: {
		webpack: {

			// merged with defaults
			// for :watch task
			watch: {
				mode: 'development',
				cache: true,
				watch: true,
				devtool: 'eval'
			},


			// merged with defaults
			// for :dev task
			dev: {
				mode: 'development',
				devtool: 'eval'
			},


			// merged with defaults
			// for :prod task
			prod: {
				mode: 'production',
				optimization: {
					minimize: true,
					minimizer: [
						new TerserPlugin({
							terserOptions: {
								output: {
									comments: false,
								},
							},
							extractComments: false,
						})
					]
				}
			},

			defaults: {
				resolve: {
					extensions: ['.js', '.jsx', '.ts', '.tsx']
				},
				output: {
					chunkFilename: 'chunk-[name].js'
				},
				stats: {
					colors: true
				},
				module: {
					rules: [
						{
							test: /\.m?js$/,
							exclude: /node_modules/,
							loader: 'babel-loader',
							options: {
								presets: ['@babel/preset-env'],
								plugins: ['@babel/plugin-transform-runtime']
							}
						},
						{
							test: /swiper\.esm\.js/, // force tree shaking for swiper js
							sideEffects: false
						}
					]
				},
				plugins: [
					new ESLintPlugin({
						failOnError: false
					})
				],
				externals: {
					jquery: 'jQuery'
				},
				performance: {
					hints: false,
					maxEntrypointSize: 512000,
					maxAssetSize: 512000
				}
			}
		}
	}
});
