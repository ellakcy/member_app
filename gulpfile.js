var gulp= require('gulp');
var rename=require('gulp-rename');
var ext_replace = require('gulp-ext-replace');

/**
* Location where to store the 3rd party libraries
*/
var web_folder="web/assets/vendor"


/*################################### Installing Dependencies ###############################*/

//Move Bootstrap
gulp.task('move_bootstrap',function(){

  var bootstrap_dir='bower_components/AdminLTE/bootstrap';
  var dest=web_folder+'/bootstrap';
  //MoveCss
  gulp.src(bootstrap_dir+'/css/bootstrap.min.css')
    .pipe(rename('bootstrap.css'))
    .pipe(gulp.dest(dest+'/css'))

  gulp.src(bootstrap_dir+'/js/bootstrap.min.js')
    .pipe(rename('bootstrap.js'))
    .pipe(gulp.dest(dest+'/js'));

  gulp.src(bootstrap_dir+'/fonts/*')
      .pipe(gulp.dest(dest+'/fonts'));
})

//Jquery & miscellanous Javascript move
gulp.task('move_jquery',function(){

  var jqueryFiles=[
                    'bower_components/jquery/dist/jquery.min.js',
                    'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
                    'bower_components/jquery-ui/jquery-ui.min.js',
                    'bower_components/fastclick/lib/fastclick.js'
                  ]
  gulp.src(jqueryFiles)
    .pipe(ext_replace('.js','.min.js'))
    .pipe(gulp.dest(web_folder))
});

//Move the Admin's LTE css
gulp.task('move_admin_lte',function(){

  var cssLocation='bower_components/AdminLTE/dist/css';
  var jsLocaton="bower_components/AdminLTE/dist/js/"
  var dest=web_folder+'/adminlte/'

  gulp.src([cssLocation+'/AdminLTE.min.css'])
    .pipe(rename('adminlte.css'))
    .pipe(gulp.dest(dest));

  gulp.src([cssLocation+'/skins/skin-blue.min.css'])
      .pipe(rename('skin-blue.css'))
      .pipe(gulp.dest(dest));
  
  gulp.src(jsLocaton+"app.min.js").pipe(gulp.dest(dest));
});

//For xeditable library
gulp.task('move_xeditable',function(){
  var path='bower_components/x-editable/dist/bootstrap3-editable';
  var dest=web_folder+'/xeditable';

  //Move Xeditable library itself
  gulp.src(path+'/css/*').pipe(gulp.dest(dest+'/css'));
  gulp.src(path+'/img/*').pipe(gulp.dest(dest+'/img'));
  gulp.src(path+'/js/bootstrap-editable.min.js').pipe(rename('xeditable.js')).pipe(gulp.dest(dest+'/js/'))
})

//For fontawesome
gulp.task('move_fontawesome',function(){
  var path='bower_components/font-awesome';
  var dest=web_folder+'/font-awesome';

  gulp.src(path+'/fonts/*').pipe(gulp.dest(dest+'/fonts'));
  gulp.src(path+'/css/font-awesome.min.css')
    .pipe(rename('font-awesome.css'))
    .pipe(gulp.dest(dest+'/css'));
});

//For jqueryfileupload and knockout bindings
gulp.task('move_jquery_fileupload',function(){
  var src='bower_components/blueimp-file-upload/js/'

  var jquery_files=[src+'jquery.fileupload.js',src+'jquery.iframe-transport.js',src+'vendor/jquery.ui.widget.js']
  var dest=web_folder+'/jquery_fileupload/'
  gulp.src(jquery_files).pipe(gulp.dest(dest));

});

gulp.task('move_icheck',function(){
	var css='bower_components/iCheck/skins/*/*'
	var js='bower_components/iCheck/icheck.min.js'
	var dest=web_folder+'/icheck'
	
	gulp.src(js).pipe(rename('icheck.js')).pipe(gulp.dest(dest))
	gulp.src(css).pipe(gulp.dest(dest))
})
/* ############################################ Installing Dependencies ##################################### */

gulp.task('move_frontend',['move_bootstrap','move_admin_lte','move_jquery','move_xeditable','move_fontawesome','move_jquery_fileupload','move_icheck']);

gulp.task('default',['move_frontend']);
