var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename');

gulp.task('styles', function() {
    return gulp.src('src/**/*.scss')
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest('assets/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('assets/'));
});

gulp.task('watch', function() {
    gulp.watch('src/**/*.scss', ['styles']);
});