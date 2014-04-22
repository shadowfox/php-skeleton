module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
      cssmin: {
        combine: {
          files: {
            './style.min.css': [
              './assets/css/style.css'
            ]
          }
        }
      },
      uglify: {
        options: {
          sourceMap: true,
        },
        main: {
          files: {
            'app.min.js': [
              './assets/js/app.js'
            ]
          }
        }
      },
      watch: {
        css: {
          files: './assets/css/*.css',
          tasks: ['cssmin'],
          options: {
            debounceDelay: 250
          }
        },
        js: {
          files: './assets/js/*.js',
          tasks: ['uglify'],
          options: {
            debounceDelay: 250
          }
        },
        // Reload the watcher when this config file changes
        grunt: {
          files: ['Gruntfile.js'],
          options: {
            reload: true
          }
        }
      }
  });

  // Load all required tasks
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['cssmin', 'uglify', 'copy']);

  // Runs tasks when files change
  grunt.registerTask('dev', ['watch']);
};