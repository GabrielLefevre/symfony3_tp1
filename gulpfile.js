/**
 * Created by DEV2 on 17/03/2017.
 */

var gulp = require('gulp');

var plugins = require('bootstrap')();

var source = './node_modules';
var destination = './web';

gulp.task('css', function () {
    return gulp.src(source + '/bootstrap/dist/css/*')
        .pipe(gulp.dest(destination + '/css/'));
});