module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Project Plugins

    compass: { // compile sass/scss to css

      clean: {
        options: {
          clean: true // removes generated files and sass cache
        }
      },

      dev: {
        options: {
          sassDir: 'scss',
          cssDir: 'css',
          environment: 'development',
          sourcemap: true,
          force: true // overwrite existing file
        }
      },
      dist: {
        options: {
          sassDir: '[scss]',
          cssDir: '[css]',
          environment: 'production'
        }
      }
    },

    uglify: { // minify js
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: { // add different build tasks for different folders as you build out functionalities
        src: 'js/forms_js_interface.js',
        dest: 'js/forms_js_interface.min.js'
      },
      build2: {
          src: 'js/scripts_admin.js',
          dest: 'js/scripts_admin.min.js'
      }
    },

    jshint: { // test code give hints for errors
      files: ['Gruntfile.js', '**/*.js'],  // files to lint
      options: {  // options to override jshint default
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },

    watch: { // watch for changes is the scss and the js, run tasks if any changes
      tasks: ['jshint'],
      scss: { // changes in scss runs sass task, which translates scss to css
        files: ['**/*.scss'],
        tasks: ['compass:dev']
      },
      js: {
        files: ['js/**/*.js'],
        task: ['uglify'],
          options: {
              livereload:true
          }
      },
      changes: { // if changes in js livereload
        files: ['**/*.php', '**/*.css', '!node_modules'],
        options: {
          livereload: 1337
        }
      }
    }

});

  // Load the plugins

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-compass');

  // register tasks

  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'sass', 'compass']);
  grunt.registerTask('test', ['jshint']);

};