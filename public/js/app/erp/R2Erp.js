'use strict';

var R2Erp = angular.module('R2Erp', [
    // Modules
    'AuthModule',
    'TrackerModule',

    // Plugins
    'underscore',

    // Resources
    'ui-notification',
    'ngResource',
    'ngCookies',
    'ui.router',
    'ngMessages',
    'favicon',
    'ui.utils.masks',
    'ncy-angular-breadcrumb',

    // Translate Resources
    'pascalprecht.translate',
    'tmh.dynamicLocale',

    // Directives
    'PluginsDirectives',
    'DocumentsDirectives',
    'SocialNetworksDirectives',
    'EmailsDirectives',
    'CreditCardsDirectives',
    'TelephonesDirectives',
    'AddressesDirectives',
    'LanguageSelectDirective',
    'ValidationDirectives',
    'InputDirectives',
    'CompanyDirectives',

    // Controlles
    'LayoutControllers',
    'UsersControllers',

    // Services
    'BaseServices',
    'AclServices',
    'UserServices',
    'LocaleServices',
    'CompanyServices',

    // Filters
    'StringFilters'

]).constant('LOCALES', {
    'locales': {
        'pt_BR': 'Portuguese',
        'en_US': 'English',
    },
    'preferredLocale': 'pt_BR'
});

R2Erp.run([
    '$rootScope',
    '$templateCache',
    '$state',
    'AuthService',
    function($rootScope, $templateCache, $state, AuthService) {
        // TEMPORÁRIO
        // AuthService.run();

        $rootScope.$on('$routeChangeStart', function(event, next, current) {
            if (typeof(current) !== 'undefined'){
                $templateCache.remove(current.templateUrl);
            }
        });
    }
]);

R2Erp.config(['$locationProvider', '$stateProvider', '$urlRouterProvider', '$translateProvider', 'tmhDynamicLocaleProvider', 'NotificationProvider',
    function($locationProvider, $stateProvider, $urlRouterProvider, $translateProvider, tmhDynamicLocaleProvider, NotificationProvider) {

        $locationProvider.html5Mode({
            enabled: true
        });

        $translateProvider.useSanitizeValueStrategy('escape');
        $translateProvider.useMissingTranslationHandlerLog();
        $translateProvider.useStaticFilesLoader({
            prefix: 'locale/locale-',// path to translations files
            suffix: '.json'// suffix, currently- extension of the translations
        });
        $translateProvider.preferredLanguage('pt_BR');// is applied on first load
        $translateProvider.useLocalStorage();// saves selected language to localStorage
        tmhDynamicLocaleProvider.localeLocationPattern('bower_components/angular-i18n/angular-locale_{{locale}}.js');


        $urlRouterProvider.otherwise("/");

        $stateProvider.
        state('root', {
            url: '/',
            views: {
                'header': {
                    templateUrl: '/partials/erp/layout/header.html',
                    //controller: 'HeaderCtrl'
                },
                'notification': {
                    templateUrl: '/partials/erp/layout/notification.html',
                    //controller: 'HeaderCtrl'
                },
                'sidebar_left': {
                    templateUrl: '/partials/erp/layout/sidebar-left.html'
                },
                'sidebar_right': {
                    templateUrl: '/partials/erp/layout/sidebar-right.html'
                },
                'footer': {
                    templateUrl: '/partials/erp/layout/footer.html'
                },
                'content': {
                    templateUrl: '/partials/erp/pages/home.html'
                }
            },
            ncyBreadcrumb: {
                label: 'Home Admin'
            }
        }).
        state('root.register', {
            url: 'cadastro/',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register',
                    controller: 'MyBusinessCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Cadastro'
            }
        }).
        // MY BUSINESS -> MyBusinessControllers
        state('root.register.my_business', {
            url: 'minha-empresa/',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/my-business/home.html',
                    controller: 'MyBusinessCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Minha Empresa'
            }
        }).
        state('root.register.my_business.matrix', {
            url: 'matriz/',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/my-business/matrix/save.html',
                    controller: 'MyBusinessMatrixCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Matriz'
            }
        }).
        state('root.register.my_business.subsidiaries_list', {
            url: 'filiais/listar',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/my-business/subsidiaries/list.html',
                    controller: 'MyBusinessSubsidiariesListCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Listar Filiais'
            }
        }).
        state('root.register.my_business.subsidiaries_create', {
            url: 'filiais/novo',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/my-business/subsidiaries/save.html',
                    controller: 'MyBusinessSubsidiariesCreateCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Filial'
            }
        }).
        state('root.register_my_business.subsidiaries_update', {
            url: 'filiais/atualizar',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/my-business/subsidiaries/save.html',
                    controller: 'MyBusinessSubsidiariesSaveCtrl'
                }
            }
        }).
        // SUPPLIERS - SupplierControllers
        state('root.register_suppliers_list', {
            url: 'cadastro/fornecedores/listar',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/suppliers/list.html',
                    controller: 'SupplierCreateCtrl'
                }
            }
        }).
        state('root.register_suppliers_create', {
            url: 'cadastro/fornecedores/novo',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/suppliers/save.html',
                    controller: 'SupplierCreateCtrl'
                }
            }
        }).
        state('root.register_suppliers_update', {
            url: 'cadastro/fornecedores/atualizar',
            views: {
                'content@': {
                    templateUrl: '/partials/erp/register/suppliers/save.html',
                    controller: 'SupplierCreateCtrl'
                }
            }
        }).
        // 
        state('redirect', {
            url: 'redirect/:to',
            controller: function($state, $stateParams, $scope) {
                $state.go($stateParams.to, null, {reload: true});
            }
        });
    }
]);