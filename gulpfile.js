var gulp = require('gulp');
var less = require('gulp-less');
var uglify = require("gulp-uglify");
var path = require('path');
var cssnano = require('gulp-cssnano');
var rename = require("gulp-rename");
var image = require('gulp-image');
var react = require('gulp-react');

gulp.task('copy-react-js', function() {
    gulp.src('./src/**/**/Resources/public/jsx/**/*.jsx')
        .pipe(react())
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest('web/js'));
});

gulp.task('minify-js', function () {
    gulp.src('./src/**/**/Resources/public/js/*.js') // path to your files
            .pipe(uglify())
            .pipe(rename({dirname: ''}))
            .pipe(gulp.dest('web/js'));
});

gulp.task('minifylesstocss', function () {
    gulp.src('./src/**/**/Resources/public/less/*.less')
            .pipe(less())
            .pipe(cssnano())
            .pipe(rename({dirname: ''}))
            .pipe(gulp.dest('web/css'));
});

gulp.task('image', function () {
  gulp.src('./src/**/**/Resources/public/img/*')
    .pipe(image())
    .pipe(rename({dirname: ''}))
    .pipe(gulp.dest('web/img'));
});

gulp.task('default', ['minifylesstocss', 'minify-js', 'copy-react-js', 'image'], function () {
    console.log("Started gulp");
});

gulp.watch('./src/**/**/Resources/public/less/*.less', ['minifylesstocss'], function () {
    console.log("Compressing less");
});

gulp.watch('./src/**/**/Resources/public/js-react/*.js', ['copy-react-js'], function () {
    console.log("Copying react.js");
});

gulp.watch('./src/**/**/Resources/public/js/*.js', ['minify-js'], function () {
    console.log("Compressing js");
});

gulp.watch('./src/**/**/Resources/public/img/*', ['image'], function () {
    console.log("Compressing images");
});
