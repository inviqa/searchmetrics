/* jshint -W097, unused: true, node: true */
'use strict';

var gulp = require('gulp');
var phpcs = require('gulp-phpcs');

/////
// TASKS
////
gulp.task('phpcs', function () {

  var phpcsConfig = {
    bin: 'vendor/bin/phpcs',
    standard: 'PSR2'
  };

  return gulp.src('src/**/*.php')
    .pipe(phpcs(phpcsConfig))
    .pipe(phpcs.reporter('log'));

});

/////
// DEFAULT TASK
/////
gulp.task('default', ['phpcs'], function () {

  gulp.watch('src/**/*.php', ['phpcs']);

});
