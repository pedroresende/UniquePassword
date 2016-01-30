var gulp = require('gulp');
var less = require('gulp-less');
var uglify = require("gulp-uglify");
var path = require('path');
var minifyCSS = require('gulp-minify-css');
var rename = require("gulp-rename");

gulp.task('minify-js', function () {
    gulp.src('./src/**/**/Resources/public/js/*.js') // path to your files
            .pipe(uglify())
            .pipe(rename({dirname: ''}))
            .pipe(gulp.dest('web/js'));
});

gulp.task('minifylesstocss', function () {
    gulp.src('./src/**/**/Resources/public/less/*.less')
            .pipe(less())
            .pipe(minifyCSS())
            .pipe(rename({dirname: ''}))
            .pipe(gulp.dest('web/css'));
});

gulp.task('default', ['minifylesstocss', 'minify-js'], function () {
    console.log("Started gulp");
});

gulp.watch('./src/**/**/Resources/public/less/*.less', ['minifylesstocss'], function () {
    console.log("Compressing less");
});

gulp.watch('./src/**/**/Resources/public/js/*.js', ['minify-js'], function () {
    console.log("Compressing js");
});