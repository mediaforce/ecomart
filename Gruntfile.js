'use strict';

module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // clean configs
        clean: ['build', '.tmp'],

        // useminPrepare configs
        useminPrepare: {
            htmlSite: 'module/R2SiteApp/view/layout/layout.phtml',
/*            htmlAdmin: 'build/module/R2AdminApp/view/layout/layout.phtml',*/
            options: {
                dest: 'build/module/sitelayout/'
            }
        },

        // usemin configs
        usemin: {
            htmlSite: [
                'module/R2SiteApp/view/layout/layout.phtml', 
                'module/R2SiteApp/view/**/*.phtml'],
/*            htmlAdmin: [
                'build/module/R2AdminApp/view/layout/layout.phtml', 
                'build/module/R2AdminApp/view/*.phtml'], */
            options: {
                basedir: 'public',
                dirs: ['build/module/sitelayout/**']
            }
        },

        // concat configs
        concat: {
            options: {
                separator: ';'
            },
            base_css: {
                src: [
                    'public/css/screen.css',
                    'public/css/print.css'
                ],
                dest: '.tmp/concat/basesite.css'
            },

            site_main_css: {
                src: [
                    'public/css/main.css'
                ],
                dest: '.tmp/concat/sitemain.css'
            },

            site_vendors_css: {
                src: [
                    'public/bower_components/angular-loading-bar/build/loading-bar.css',
                    'public/bower_components/angular-ui-notification/dist/angular-ui-notification.css',
                    'public/bower_components/ng-dialog/css/ngDialog.css',
                    'public/bower_components/ng-dialog/css/ngDialog-theme-default.css',
                    'public/css/angular-photo-slider.css',
                    'public/bower_components/ngFloatingLabels/src/ng-floating-labels.css',
                    'public/css/easyzoom.css',
                    'public/css/barousel.css',
                    'public/bower_components/angular-block-ui/dist/angular-block-ui.css'
                ],
                dest: '.tmp/concat/sitevendors.css'
            },

            site_plugins_js: {
                src: [
                    'public/bower_components/jquery/dist/jquery.js',
                    'public/js/plugins/jquery.sticky.js',
                    'public/bower_components/foundation-sites/dist/foundation.js',
                    'public/js/plugins/foundation/foundation.core.js',
                    'public/js/plugins/foundation/foundation.util.triggers.js',
                    'public/js/plugins/foundation/foundation.util.motion.js',
                    'public/js/plugins/foundation/foundation.util.mediaQuery.js',
                    'public/js/plugins/foundation/foundation.util.box.js',
                    'public/js/plugins/foundation/foundation.util.keyboard.js',
                    'public/js/plugins/foundation/foundation.util.nest.js',
                    'public/js/plugins/foundation/foundation.responsiveToggle.js',
                    'public/js/plugins/foundation/foundation.responsiveMenu.js',
                    'public/js/plugins/foundation/foundation.dropdownMenu.js',
                    'public/js/plugins/foundation/foundation.offcanvas.js',
                    'public/js/plugins/foundation/foundation.accordion.js',
                    'public/js/plugins/underscore.js',
                    'public/js/plugins/polyfiller.js',
                    'public/bower_components/string/dist/string.js',
                    'public/js/plugins/TweenMax.min.js',
                    'public/js/plugins/imagesloaded.pkgd.js',
                    'public/js/plugins/jquery-imagefill.js',
                    'public/bower_components/ez-plus/src/jquery.ez-plus.js',
                    'public/js/plugins/jquery.barousel.js'
                ],
                dest: '.tmp/concat/siteplugins.js'
            },


            site_angular_and_resources_js: {
                src: [
                    'public/bower_components/angular/angular.js',
                    'public/bower_components/angular-animate/angular-animate.js',
                    'public/bower_components/angular-touch/angular-touch.js',
                    'public/bower_components/angular-breadcrumb/dist/angular-breadcrumb.js',
                    'public/bower_components/angular-resource/angular-resource.js',
                    'public/bower_components/angular-ui-router/release/angular-ui-router.js',
                    'public/bower_components/angular-cookies/angular-cookies.js',
                    'public/bower_components/angular-messages/angular-messages.js',
                    'public/bower_components/angular-favicon/angular-favicon.js',
                    'public/bower_components/angular-i18n/angular-locale_pt-br.js',
                    'public/bower_components/angular-input-masks/angular-input-masks-standalone.js',
                    'public/bower_components/angular-ui-notification/dist/angular-ui-notification.js',
                    'public/bower_components/ngCart/dist/ngCart.js',
                    'public/bower_components/ng-dialog/js/ngDialog.js',
                    'public/bower_components/ngFloatingLabels/src/ngFloatingLabels.js',
                    'public/bower_components/angular-ez-plus/js/angular-ezplus.js',
                    'public/bower_components/angular-youtube-embed/dist/angular-youtube-embed.min.js',
                    'public/bower_components/angular-recaptcha/release/angular-recaptcha.js',
                    'public/bower_components/angular-credit-cards/release/angular-credit-cards.js',
                    'public/bower_components/angular-slugify/angular-slugify.js',
                    'public/bower_components/angular-block-ui/dist/angular-block-ui.js',
                    'public/bower_components/angular-smart-table/dist/smart-table.js'
                ],
                dest: '.tmp/concat/ng/siteangularandresources.js'
            },

            R2SiteApp_js: {
                src: [
                    'public/js/app/shared/auth/AuthModule.js',
                    'public/js/app/shared/auth/TrackerModule.js',
                    'public/js/app/shared/plugins/factories/underscore.js',
                    'public/js/app/shared/plugins/factories/string.js',
                    'public/js/app/shared/plugins/factories/PagSeguroDirectPayment.js',
                    'public/js/app/shared/filters/StringFilters.js',
                    'public/js/app/shared/directives/PluginsDirectives.js',
                    'public/js/app/shared/directives/DocumentsDirectives.js',
                    'public/js/app/shared/directives/SocialNetworksDirectives.js',
                    'public/js/app/shared/directives/EmailsDirectives.js',
                    'public/js/app/shared/directives/CreditCardsDirectives.js',
                    'public/js/app/shared/directives/TelephonesDirectives.js',
                    'public/js/app/shared/directives/AddressesDirectives.js',
                    'public/js/app/shared/directives/LaguageSelectDirectives.js',
                    'public/js/app/shared/directives/ValidationDirectives.js',
                    'public/js/app/shared/directives/InputDirectives.js',
                    'public/js/app/shared/directives/UsersDirectives.js',
                    'public/js/app/shared/services/BaseServices.js',
                    'public/js/app/shared/services/UserServices.js',
                    'public/js/app/shared/services/AclServices.js',
                    'public/js/app/shared/services/LocaleServices.js',
                    'public/js/app/shared/services/InventoriesServices.js',
                    'public/js/app/shared/services/CheckoutServices.js',
                    'public/js/app/shared/services/NotificationServices.js',
                    'public/js/app/shared/services/CouponServices.js',
                    'public/js/app/site/R2Site.js',
                    'public/js/app/site/controllers/LayoutControllers.js',
                    'public/js/app/site/controllers/UsersControllers.js',
                    'public/js/app/site/controllers/StoresControllers.js',
                    'public/js/app/site/controllers/CheckoutControllers.js'
                ],
                dest: '.tmp/concat/ng/R2SiteApp.js'
            }
        },

        // cssmin configs
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    'public/minified/css/base.site.min.css': ['.tmp/concat/basesite.css'],
                    'public/minified/css/main.site.min.css': ['.tmp/concat/sitemain.css'],

                    'public/minified/css/vendors.min.css': ['.tmp/concat/sitevendors.css'],

                    'public/minified/css/vendors.min.css': ['.tmp/concat/adminvendors.css']

                }
            }
        },

        // uglify configs
        uglify: {
            options: {
              mangle: false
            },
            my_target: {
                files: {
                    'public/minified/js/site_plugins.min.js': ['.tmp/concat/siteplugins.js'],
                    'public/minified/js/site_angular_and_resources.min.js': ['.tmp/concat/ng/siteangularandresources.js'],
                    'public/minified/js/R2SiteApp.min.js': ['.tmp/concat/ng/R2SiteApp.js']                    

                }
            }
        },

        // karma configs
        karma: {
            unit: {
                configFile: 'karma.conf.js'
            }
        },

        // phpunit configs
        phpunit: {
            classes: {
                dir: 'C:/desenvolvimento/sites/testes/zf_skeleton_test01/module/Application/test'
            },
            options: {
                bin: 'phpunit',
                configuration: 'C:/desenvolvimento/sites/testes/zf_skeleton_test01/module/Application/test/phpunit.xml.dist',
                convertErrorsToExceptions: true,
                convertNoticesToExceptions: true,
                convertWarningsToExceptions: true,
                printerClass: 'PHPUnit_TextUI_ResultPrinter',
                processIsolation: false,
                stopOnError: false,
                stopOnFailure: false,
                stopOnIncomplete: false,
                stopOnSkipped: false,
                testSuiteLoaderClass: 'PHPUnit_Runner_StandardTestSuiteLoader',
                verbose: true
            }
        },

        compass: {
            dist: {
                options: {
                    config: 'config.rb'
                }
            }
        },

        // watch configs
        watch: {
            phpunit: {
                files: [
                    'module/Application/test/ApplicationTest/**/*.php',
                    'module/Application/src/Application/**/*.php'
                ],
                tasks: ['phpunit', 'karma']
            }
        }

    });

    // Load the plugin that provides the 'uglify' task.
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-usemin');
    grunt.loadNpmTasks('grunt-ngmin');

    // Tests ('karma start karma.conf.js')
    grunt.loadNpmTasks('grunt-karma');

    // 'grunt watch:phpunit'
    grunt.loadNpmTasks('grunt-phpunit');

    // 'compass watch'
    grunt.loadNpmTasks('grunt-contrib-compass');

    // WATCH
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Default task(s).
    grunt.registerTask('default', ['clean']);
    grunt.registerTask('css', ['compass']);
    grunt.registerTask('tests', ['phpunit', 'karma']);
    grunt.registerTask('prep', ['clean', 'concat', 'cssmin', 'uglify' ]);


};
