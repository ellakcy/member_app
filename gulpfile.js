var gulp = require('gulp');
var rename = require('gulp-rename');
var vfs = require('vinyl-fs');

/**
* Location where to store the 3rd party libraries
*/
const frontend_folder="./frontend"
const vendor_folder=`${frontend_folder}/vendor`
const frontent_dev_folder_js=`${frontend_folder}/js`
const frontent_dev_folder_css=`${frontend_folder}/css`

/**
* Indication whether the build is done for
* procuction release of for for development release
*/
var status="dev";

/*############################ Bootastraping #################################*/

gulp.task('set_dev',function(done){
  status="dev";
  done()
});

gulp.task('set_prod',function(done){
  status="prod";
  done()
});

/*################################### Installing Dependencies ###############################*/

//Move Bootstrap
gulp.task('move_bootstrap',function(done){

  var bootstrap_dir='./node_modules/bootstrap/dist';
  var dest=`${vendor_folder}/bootstrap`;

  var css_files=[`${bootstrap_dir}/css/bootstrap.min.css`,`${bootstrap_dir}/css/bootstrap.min.css.map`];
  var js_files=[`${bootstrap_dir}/js/bootstrap.bundle.min.js`,`${bootstrap_dir}/js/bootstrap.bundle.min.js.map`];

  gulp.src(css_files).pipe(gulp.dest(`${dest}/css`));
  gulp.src(js_files).pipe(gulp.dest(`${dest}/js`));

  done();
})

//Jquery & plugins move
gulp.task('move_jquery',function(done){
  var jqueryFiles=[
                   './node_modules/jquery/dist/jquery.min.js',
                   './node_modules/jquery-ui-dist/jquery-ui.min.css',
                   './node_modules/jquery-ui-dist/jquery-ui.min.js',
                   './node_modules/animatescroll.js/animatescroll.min.js'
                  ];
  gulp.src(jqueryFiles).pipe(gulp.dest(vendor_folder));
  done();
});

//For fontawesome
gulp.task('move_fontawesome',function(done){
  var path='./node_modules/@fortawesome/fontawesome-free';
  var dest=vendor_folder+'/font-awesome';

  gulp.src(path+'/webfonts/*').pipe(gulp.dest(dest+'/webfonts'));
  gulp.src(path+'/css/all.min.css').pipe(gulp.dest(dest+'/css'));

  done();
});

gulp.task('move_flagicon_css',function(done){
  var path="./node_modules/flag-icon-css";
  var dest=vendor_folder+'/flag-icon-css';
  gulp.src(`${path}/css/flag-icon.min.css`).pipe(gulp.dest(dest))
  gulp.src(`${path}/flags/**`).pipe(gulp.dest(`${dest}/../flags/`))
  done();
});

gulp.task('move_jsrender',function(done){
  var jsrenderFiles=[
    './node_modules/jsrender/jsrender.min.js',
    './node_modules/jsrender/jsrender.min.js.map'
  ];

  var dest=`${vendor_folder}/jsrender`

  gulp.src(jsrenderFiles).pipe(gulp.dest(dest));
  done();
})

gulp.task('move_qrious',function(done){
  var dest=`${vendor_folder}/qrious`

  gulp.src('./node_modules/qrious/dist/qrious.min.*').pipe(gulp.dest(dest));
  done();
})


gulp.task('move_cookie_js',function(done){
  var dest=`${vendor_folder}/cookie-js`

  gulp.src('./node_modules/js-cookie/src/js.cookie.js').pipe(gulp.dest(dest));
  done();
});

gulp.task('move_jspdf', function(done){

 const dest=`${vendor_folder}/jspdf`;
 gulp.src(['./node_modules/jspdf/dist/jspdf.*.js',
 './node_modules/html2canvas/dist/html2canvas.min.js'] ).pipe(gulp.dest(dest));
 
 done();
});

/******* Build Final Steps ****************************************************/

gulp.task('link_assets',function(done){

  vfs.src(frontend_folder+'/*', {followSymlinks: false})
        .pipe(vfs.symlink('./web/assets/'));

  return done();
});



/* ############################################ Installing Dependencies ##################################### */

gulp.task('move_frontend',
          gulp.parallel(['move_bootstrap','move_jquery','move_fontawesome','move_flagicon_css','move_jsrender','move_qrious','move_cookie_js','move_jspdf'],
          (done)=>{done()}
        ));

gulp.task('dev',gulp.series(['set_dev','move_frontend','link_assets'],(done)=>{done();}));

gulp.task('default',gulp.series(['dev'],(done)=>{done()}));
