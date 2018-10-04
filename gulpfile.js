// Less configuration
var gulp = require( 'gulp' );
var sass = require('gulp-sass');
var postcss = require( 'gulp-postcss' );
var autoprefixer = require( 'autoprefixer' );
var cleanCSS = require( 'gulp-clean-css' );
var rename = require( 'gulp-rename' );
var concat = require( 'gulp-concat' );
var babel = require('gulp-babel');
var terser = require('gulp-terser');

gulp.task( 'default', function() {
    gulp.watch( './src/Assets/**/*.scss', ['customize-controls-css'] );
    gulp.watch( './src/Assets/js/customize-controls.js', ['customize-controls-js'] );
    gulp.watch( './src/Assets/js/customize-preview.js', ['customize-preview-js'] );
});


gulp.task( 'customize-controls-css', function() {
  gulp.src( './src/Assets/scss/customize-controls.scss' )
    .pipe( sass() )
    .pipe( postcss([ autoprefixer( { browsers: ['last 2 versions'] } ) ]) )
    .pipe( gulp.dest( './resources/css' ) )
    .pipe( rename( { extname: '.min.css' } ) )
    .pipe( cleanCSS() )
    .pipe( gulp.dest( './resources/css' ) );    
 });


gulp.task( 'customize-controls-js', function() {
    gulp.src( 'src/Assets/js/customize-controls.js' )
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe( gulp.dest( 'resources/js' ) )
        .pipe( rename( { extname: '.min.js' } ) )
        .pipe( terser() )
        .pipe( gulp.dest( 'resources/js' ) ); 
});


gulp.task( 'customize-preview-js', function() {
    gulp.src( 'src/Assets/js/customize-preview.js' )
        .pipe(babel({
            presets: ['@babel/env']
        }))      
        .pipe( gulp.dest( 'resources/js' ) )
        .pipe( rename( { extname: '.min.js' } ) )
        .pipe( terser() )
        .pipe( gulp.dest( 'resources/js' ) ); 
});
