module.exports = function(config) {
  config.set({
    // base path, that will be used to resolve files and exclude
    basePath: '',

    // testing framework to use (jasmine/mocha/qunit/...)
    frameworks: ['jasmine'],

    // list of files / patterns to load in the browser
    files: [
      'public/js/ng/angular.js',
      'public/bower_components/angular-mocks/angular-mocks.js',
      'public/js/app/**/*.js',
      'public/js/spec/**/*.js'
    ],

    plugins: [
        'karma-htmlfile-reporter',
        'karma-firefox-launcher',
        'karma-jasmine'
    ],

    reporters: ['progress', 'html'],
 
    htmlReporter: {
      outputFile: 'tests/scriptTests.html',
            
      // Optional 
      pageTitle: 'R2 Turismo Script Tests',
      subPageTitle: 'Projeto de Site de Turismo'
    },

    // list of files / patterns to exclude
    exclude: [],

    // web server port
    port: 8090,

    // level of logging
    // possible values: LOG_DISABLE || LOG_ERROR || LOG_WARN || LOG_INFO || LOG_DEBUG
    logLevel: config.LOG_INFO,

    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,

    // Start these browsers, currently available:
    // - Chrome
    // - ChromeCanary
    // - Firefox
    // - Opera
    // - Safari (only Mac)
    // - PhantomJS
    // - IE (only Windows)
    browsers: ['Firefox'],


    // Continuous Integration mode
    // if true, it capture browsers, run tests and exit
    singleRun: false
  });
};
