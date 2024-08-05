var htmlmin = require('gulp-htmlmin');
var gulp = require('gulp');

gulp.task('compress', function() {
    var opts = {
        collapseWhitespace:    true,
        removeAttributeQuotes: true,
        removeComments:        true,
        minifyJS:              true
    };

    return gulp.src('./resources/cache/blade/*')
        .pipe(htmlmin(opts))
        .pipe(gulp.dest('./resources/cache/blade/'));
});