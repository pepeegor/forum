const gulp = require('gulp');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify'); 

// Задача для обработки CSS
gulp.task('styles', function() {
  return gulp.src([
      'src/css/_base.css', 
      'src/css/_header.css', 
      'src/css/_main.css',
      'src/css/_form.css' // !!! Добавляем _form.css
    ])
    .pipe(concat('styles.min.css'))
    .pipe(cleanCSS())
    .pipe(gulp.dest('dist/css'));
});

// Задача для обработки JavaScript
gulp.task('scripts', function() {
  return gulp.src('src/js/*.js')
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('dist/js'));
});

// Задача по умолчанию (запускает все задачи)
gulp.task('default', gulp.parallel('styles', 'scripts'));