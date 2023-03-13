var gulp         = require('gulp');
var plumber      = require('gulp-plumber');
var named        = require('vinyl-named');
var webpack 	 = require('webpack');
var gulpWebpack  = require('webpack-stream');
var browserSync  = require('browser-sync');

// utils
var deepMerge    = require('../../utils/deepMerge');
var logStats     = require('../../utils/webpackLogStats');
var notifaker    = require('../../utils/notifaker');
var pumped       = require('../../utils/pumped');

// config
var config       = require('../../config/scripts');


/**
 * Watch for changes
 * to JS assets and
 * update the JS packages
 * with webpack
 *
 * @returns {*}
 */
module.exports = function (done) {
	gulp.src(config.paths.src)
		.pipe(plumber())

		.pipe(named()) // vinyl-named is used to allow for
									 // multiple entry files
		.pipe(gulpWebpack(
			deepMerge(
				config.options.webpack.defaults,
				config.options.webpack.watch
			), webpack, function (err, stats) {
				logStats(err, stats, { watch: true });

				// reload browser-sync when
				// a package is updated
				browserSync.reload();
				notifaker(pumped('JS Packaged'));
   	 		})
		)
		.pipe(gulp.dest(config.paths.dest));

	done();
};
