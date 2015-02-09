module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Project Plugins

    sass: { // compile sass/scss to css

      dev: {
        options: {
          style: 'expanded'
        },
        files: {
          'css/cskt.css': 'scss/cskt.scss'
        }
      },

      dist: {
        options: {
          style: 'compact'
        },
        files: {
            'css/cskt.css': 'scss/cskt_compact.scss'
        }
      }
    },

    //concat: {
    //  options: {
    //    // define a string to put between each file in the concatenated output
    //      separator: ';'
    //  },
    //  dist: {
    //    // the files to concatenate
    //    src: ['shortcodes/email/*.js', 'shortcodes/like/*.js'],
    //    // the location of the resulting JS file
    //    dest: 'shortcodes/shortcodes.js'
    //  }
    //},

    uglify: { // minify js
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: { // add different build tasks for different folders as you build out functionalities
        src: 'js/forms_js_interface.js',
        dest: 'js/forms_js_interface.min.js'
      },
      build2: {
          src: 'js/cskt-accordionmenu.js',
          dest: "js/accordionmenu.min.js"
      },
      build3: {
        src: 'js/cskt_admin.js',
        dest: 'js/cskt_admin.min.js'
      },
      build4: {
        src: 'js/fb_sdk_interface.js',
        dest: 'js/fb_sdk_interface.min.js'
      },
      build5: {
        src: 'js/cskt.js',
        dest: 'js/cskt.min.js'
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

    watch: { // watch for changes, run tasks if any changes
      tasks: ['jshint'],
      css: { // changes in css livereload
        files: ['**/*.css'],
        options: {
          livereload: 1337
        }
      },
      scss: { // changes in scss runs sass task, which translates scss to css
        files: ['**/*.scss'],
        tasks: ['sass:dev'],
        options: {
          livereload: 1337
        }
      },
      changes: { // if changes in js or php too livereload
        files: ['**/*.js', '**/*.php'],
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

  // register tasks

  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'sass']);
  grunt.registerTask('test', ['jshint']);

};