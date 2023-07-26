/*
# Debug


# Dist
*.php    = Sincronizar
*.css    = en "dst"
*.js     = en "dst"
*.scss   = transcompilar style.scss > CSS en "dst"
imagenes = optimizar y copiar en "dst"

https://github.com/gruntjs/grunt-contrib-watch


*/
module.exports = function (grunt) {

grunt.initConfig({

  browserSync: {
    dev: {
      bsFiles: {
        src : [
          'dst/**/*.{png,svg,php,css,js,txt,html,png,svg}'
        ]
      },
      options: {
        // server: { baseDir: "./" }
        watchTask: true,
        open: false,
        proxy: "https://plugins.lndo.site/"
      }
    }
  },

  uglify: {
    dist: {
      files: {
        './dst/assets/js/build.js':[
          'src/assets/js/*.js',
          '!src/assets/js/customizer.js', // Es para el backend de WordPress
          '!src/assets/js/build.js'
        ]
      }
    }
  },

  sync: {
    all: {
      files: [{
        cwd: 'src/',
        src: [
          '**/*.{png,svg,php,css,js,txt,html,png,svg}'
        ],
        dest: 'dst/',
      }]
    },
    verbose: true, // Display log messages when copying files
    // pretend: true, // Don't do any IO. Before you run the task with `updateAndDelete` PLEASE MAKE SURE it doesn't remove too much.
    updateAndDelete: true, // Remove all files from dest that are not found in src. Default: false
    // compareUsing: "md5" // compares via md5 hash of file contents, instead of file modification ti
  },


  watch: {
    all: {
      files: [
        'dst/**/*.{png,svg,php,css,js,txt,html,png,svg}'
      ],
      tasks: ['sync:all'],
    }
  },

  clean: {
    dst: {
      src:['dst/*']
    }
  }
});


grunt.loadNpmTasks('grunt-sync');
grunt.loadNpmTasks('grunt-contrib-clean');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-browser-sync');

grunt.registerTask('dist', [
  'clean:dst',
  'sync:all'
]);

grunt.registerTask('dev', [
  'browserSync:dev',
  'watch:all'
]);

};
