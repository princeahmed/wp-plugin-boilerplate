import gulp from 'gulp';
import path from 'path';
import yargs from 'yargs';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';

const PRODUCTION = yargs.argv.prod;

const paths = {
    css: {
        src: ['src/css/frontend.scss', 'src/css/admin.scss'],
        dest: 'assets/css/'
    },
    js: {
        src: ['src/js/frontend.js', 'src/js/admin.js'],
        dest: 'assets/js/'
    },
    images: {
        src: 'src/images/**/*.{jpg,jpeg,png,gif,svg}',
        dest: 'assets/images'
    },
    other: {
        src: ['src/**/*', '!src/{css,js,images}', '!src/{css,js,images}/**/*'],
        dest: 'assets'
    }
};

export const clean = () => del(['assets']);

export const css = () => {
    return gulp.src(paths.css.src)
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility: 'ie8'})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(gulp.dest(paths.css.dest));
};

export const js = () => {
    return gulp.src(paths.js.src)
        .pipe(webpack({
            mode: PRODUCTION ? 'production' : 'development',
            entry: {
                frontend: path.resolve(__dirname, './src/js/frontend.js'),
                admin: path.resolve(__dirname, './src/js/admin.js')
            },
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: [
                            {
                                loader: 'babel-loader',
                                options: {
                                    presets: ['babel-preset-env']
                                }
                            }
                        ]
                    }
                ]
            },
            output: {
                path: path.resolve(__dirname, './assets'),
                filename: `[name]${PRODUCTION ? `.min` : ''}.js`
            },
            devtool: !PRODUCTION ? 'inline-source-map' : false
        }))
        .pipe(gulp.dest(paths.js.dest));
};

export const images = () => {
    return gulp.src(paths.images.src)
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(gulp.dest(paths.images.dest));
};

export const copy = () => {
    return gulp.src(paths.other.src)
        .pipe(gulp.dest(paths.other.dest));
};

export const watch = () => {
    gulp.watch('src/css/**/*.scss', css);
    gulp.watch(paths.images.src, images);
    gulp.watch(paths.other.src, copy);
};

export const dev = gulp.series(clean, gulp.parallel(css, js, images, copy), watch);
export const build = gulp.series(clean, gulp.parallel(css, js, images, copy));

export default dev;