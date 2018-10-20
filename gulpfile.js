// 能够优化前端工作流程
var gulp = require('gulp');
// 执行shell脚本
var shell = require('shelljs');
// 预编译模块的方案【前端模块，都得预编译】
var browserify = require('browserify');
// 文件处理
var fs = require('fs');
// 用于循序执行任务
var sequence = require('run-sequence');
// 监听文件变化
var watchify = require('watchify');
// 合并文件
var concat = require('gulp-concat');
// 浏览器同步热更新
var browserSync = require('browser-sync').create();


// ----------------------------------------------------
// SCSS
// ----------------------------------------------------
var sass = require('gulp-sass'); // 实现编译
var autoprefixer = require('gulp-autoprefixer'); // 补全浏览器兼容的css
var cssmin = require('gulp-clean-css'); // 压缩css

// ----------------------------------------------------
// JS
// ----------------------------------------------------
var babel = require("gulp-babel"); // es6转es5
var uglify = require('gulp-uglify'); // 压缩js
var jshint = require('gulp-jshint'); // 校验js的工具
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var sourcemaps = require("gulp-sourcemaps");
// ----------------------------------------------------

// 这个 task 负责调用其他 task
gulp.task('default', function () {
    // 顺序执行指定任务
    sequence('start');
});



//++++++++++++++++++++++++++++++++++++++++++++++++++++
//      SCSS
//++++++++++++++++++++++++++++++++++++++++++++++++++++
var scss_src = 'resources/assets/scss/*.scss'; // 监听scss文件
var css_dst_dir = 'public/static_pc/css';
// SCSS 编译与压缩 
gulp.task('compile_scss', function () {
    return gulp.src(scss_src)
        .pipe(sass())
        .pipe(autoprefixer({
            browsers: ['last 5 versions', 'Android >= 4.0'],
            cascade: false
        }))
        .pipe(cssmin())
        .pipe(gulp.dest(css_dst_dir));
});


//++++++++++++++++++++++++++++++++++++++++++++++++++++
//      JS 编成es5
//++++++++++++++++++++++++++++++++++++++++++++++++++++
var js_assets_dir = 'resources/assets/js/';
var js_es6_src = js_assets_dir + 'es6/**/*.js'; // 书写的文件
var js_es5_dir = js_assets_dir + 'es5'; // 编译成浏览器兼容前的临时区
var js_path = 'public/static_pc/js';
// var js_dst_dir = 'public/static_pc/js';
gulp.task('compile_js', function () {
    gulp.src(js_es6_src)
        // - js 语法检测
        // .pipe(jshint())
        // .pipe(jshint.reporter('default'))
        .pipe(babel())
        .pipe(gulp.dest(js_es5_dir));
});


//++++++++++++++++++++++++++++++++++++++++++++++++++++
//      Browserify es5模块编译到正式环境
//++++++++++++++++++++++++++++++++++++++++++++++++++++
gulp.task("browserify", function () {
    // 需要打包的文件目录
    var entiryFiles = [
        js_es5_dir + '/gulp_test/test.js',
        // js_es5_dir + '/test.js',
        // 早期的未使用es6标准书写，目前忽略
        // js_es5_dir + '/global.js',
        // js_es5_dir + '/modules.js',
        // js_es5_dir + '/xss_filter.js',
    ];

    entiryFiles.map(function (entry) {
        var _temp_arr = entry.split("/");
        var file_name = _temp_arr[_temp_arr.length - 1];
        return browserify({ entries: [entry] })
            .bundle()
            .pipe(source(file_name)) // 存储时的对应层级与文件名
            .pipe(buffer())
            .pipe(uglify())
            .pipe(gulp.dest(js_path));
    });


});

//++++++++++++++++++++++++++++++++++++++++++++++++++++
//  监听对应目录所有文件的变化，如果变化， 则执行任务
//++++++++++++++++++++++++++++++++++++++++++++++++++++
gulp.task('watch', function () {
    gulp.watch(scss_src, ['compile_scss']);
    gulp.watch(js_es6_src, function () {
        sequence(
            'compile_js',
            'browserify'
        );
    });
});


// ----------------------------------------------------
gulp.task('start', function () {
    sequence(
        'compile_scss',
        'compile_js',
        'browserify',
        'watch'
    );

    // sequence( 'compile_js', 'browserify', 'watch');
});