'use strict';

var messages = {
    required: "Este campo é obrigatório",
    minlength: "Muito curto! Tamanho mínimo de @value@ caracteres.",
    pattern: "Não é um valor válido",
    "email": "Não é um email válido",
    "number": "Insira apenas números",
    "r2CompareTo": "A senha e confirmação de senha precisam ser iguais.",
    "r2UniqueUser": "Este usuário já está sendo utilizado.",
    "cpf": "Número de cpf inválido.",
    "cnpj": "Número de cnpj inválido.",
    "brPhoneNumber ": "Número de telefone inválido(coloque o DDD).",
    "cep ": "Cep inválido.",
};


var R2Site = angular.module('R2Site', [
    // Modules
    'AuthModule',
    // 'TrackerModule',

    // Plugins
    'underscore',
    'PagSeguroDirectPayment',

    // Resources
    'ngResource',
    'ngCookies',
    'ui.router',
    'ngMessages',
    'favicon',
    'ui.utils.masks',
    'ncy-angular-breadcrumb',
    'ui-notification',
    'ngCart',
    'ngDialog',
    'ngAnimate',
    'ngTouch',
    'ngFloatingLabels',
    'ezplus',
    'youtube-embed',
    'vcRecaptcha',
    'credit-cards',
    'slugifier',
    'blockUI',
    'smart-table',

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
    'PeopleDirectives',
    'UsersDirectives',

    // Controlles

    // Services
    'BaseServices',
    'AclServices',
    'UserServices',
    'LocaleServices',
    'InventoriesServices',
    'CheckoutServices',
    'NotificationServices',
    'CouponServices',

    // Filters
    'StringFilters'

]).constant('LOCALES', {
    'locales': {
        'pt_BR': 'Portuguese',
        'en_US': 'English',
    },
    'preferredLocale': 'pt_BR'
});



R2Site.config([
    '$locationProvider', 
    '$stateProvider', 
    '$urlRouterProvider', 
    '$provide',
    '$httpProvider',
    function(
        $locationProvider, 
        $stateProvider, 
        $urlRouterProvider, 
        $provide,
        $httpProvider) {

        /*$provide.factory('MyHttpInterceptor', function ($q) {
            return {
              // On request success
              request: function (config) {
                console.log('request', config); // Contains the data about the request before it is sent.

                // Return the config or wrap it in a promise if blank.
                return config || $q.when(config);
              },

              // On request failure
              requestError: function (rejection) {
                console.log('requestError', rejection); // Contains the data about the error on the request.
                
                // Return the promise rejection.
                return $q.reject(rejection);
              },

              // On response success
              response: function (response) {
                console.log('response', response); // Contains the data from the response.
                
                // Return the response or promise.
                return response || $q.when(response);
              },

              // On response failture
              responseError: function (rejection) {
                console.log('responseError', rejection); // Contains the data about the error.
                
                // Return the promise rejection.
                return $q.reject(rejection);
              }
            };
          });

          // Add the interceptor to the $httpProvider.
          $httpProvider.interceptors.push('MyHttpInterceptor');*/

        $locationProvider.html5Mode({
            enabled: true
        });

        $httpProvider.defaults.withCredentials = true;

        $urlRouterProvider.otherwise("/");

        $stateProvider.
        state('root', {
            url: '/',
            views: {
                'header': {
                    templateUrl: '/partials/site/layout/header.html',
                    controller: 'HeaderCtrl'
                },
                'banner': {
                    templateUrl: '/partials/site/layout/banner.html',
                    controller: 'BannerCtrl'
                },
                'content': {
                    templateUrl: '/partials/site/pages/home/home.html',
                    controller: 'HomeCtrl'
                },
                'footer': {
                    templateUrl: '/partials/site/layout/footer.html'
                },
            },
            ncyBreadcrumb: {
                label: 'Home'
            }
        }).
        state('root.checkout', {
            url: 'meu-carrinho',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/checkout/home.html',
                    resolve: {
                        PagseguroFactory: 'PagseguroFactory',

                        sessionPagseguroId: function(PagseguroFactory){
                            return PagseguroFactory.show().$promise;
                        }
                    },
                    controller: 'CheckoutCtrl',
                }
            },
            ncyBreadcrumb: {
                label: 'Meu Carrinho'
            }
        }).
        state('root.quemsomos', {
            url: 'pagina/quem-somos/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/quem-somos.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Quem Somos'
            }
        }).
        state('root.assistencia', {
            url: 'pagina/assistencia-tecnica/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/assistencia.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Assisténcia Técnica'
            }
        }).
        state('root.politicas', {
            url: 'pagina/politicas/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/politicas.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Políticas'
            }
        }).
        state('root.faq', {
            url: 'pagina/faq/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/faq.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Faq'
            }
        }).
        state('root.faleconosco', {
            url: 'pagina/fale-conosco/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/contato.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Fale Conosco'
            }
        }).
        state('root.informacoes', {
            url: 'pagina/informacoes/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/informacoes.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Informações'
            }
        }).
        state('root.revendedores', {
            url: 'pagina/revendedores/',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/singles/revendedores.html',
                }
            },
            ncyBreadcrumb: {
                label: 'Informações'
            }
        }).
        state('root.productsdetails', {
            url: 'produto/:storeId/:slug',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/product/detail.html',
                    resolve: {
                        StoresFactory: 'StoresFactory',

                        store: function(StoresFactory, $stateParams){
                            var storeId = $stateParams.storeId;
                            return StoresFactory.show({id: storeId}).$promise;
                        }
                    },
                    controller: 'StoreDetailCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Detalhe Produto'
            }
        }).
        state('root.combodetails', {
            url: 'combo/:comboStoreId/:slug',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/combos/detail.html',
                    resolve: {
                        ComboStoresFactory: 'ComboStoresFactory',

                        comboStore: function(ComboStoresFactory, $stateParams){
                            var comboStoreId = $stateParams.comboStoreId;
                            return ComboStoresFactory.show({id: comboStoreId}).$promise;
                        }
                    },
                    controller: 'ComboStoreDetailCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Detalhe Produto'
            }
        }).
        state('root.departments', {
            url: 'departamentos/:departmentName',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/departments/home.html',
                    controller: 'DepartmentsCtrl'
                }
            },
            ncyBreadcrumb: {
                label: '{{departmentName}}'
            }
        }).
        state('root.searchProducts', {
            url: 'procurar-produto/:search',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/search/home.html',
                    controller: 'SearchProductsCtlr'
                }
            },
            ncyBreadcrumb: {
                label: '{{departmentName}}'
            }
        }).
        state('root.launchs', {
            url: 'lancamentos',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/launchs/home.html',
                    controller: 'LaunchsCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Lançamentos'
            }
        }).
        state('root.combos', {
            url: 'combos',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/combos/home.html',
                    controller: 'CombosCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Combos'
            }
        }).
        state('root.pagsegurocomprafinalizada', {
            url: 'pagseguro/compra-finalizada',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/checkout/compra-finalizada.html',
                    controller: 'PagseguroCompraFinalizadaCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Compra Finalizada'
            }
        }).
        state('root.userregister', {
            url: 'usuario/registro',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/user/register/form.html',
                    controller: 'CreateUserCtrl'
                },
            },
            ncyBreadcrumb: {
                label: 'Cadastro de Cliente'
            }
        }).
        state('root.usercompras', {
            url: 'usuario/pagina/minhas-compras',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/user/minhas-compras/home.html',
                    controller: 'ComprasUserCtrl'
                },
            },
            ncyBreadcrumb: {
                label: 'Minhas Compras'
            }
        }).
        state('root.userconta', {
            url: 'usuario/pagina/minha-conta',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/user/minha-conta/home.html',
                    controller: 'ContaUserCtrl'
                },
            },
            ncyBreadcrumb: {
                label: 'Minha Conta'
            }
        }).
        state('root.userchangepassword', {
            url: 'recadastrar-senha/:key',
            views: {
                'banner@': {
                    template: '<img src="/img/barra-verde.png" width="100%">',
                },
                'content@': {
                    templateUrl: '/partials/site/pages/user/recadastrar-senha/home.html',
                    controller: 'RecadastrarSenhaCtrl'
                },
            },
            ncyBreadcrumb: {
                label: 'Minha Conta'
            }
        }).
        state('root.userregister.access', {
            url: '/acesso',
            views: {
                'form_user@root.userregister': {
                    templateUrl: '/partials/site/pages/user/register/form-access.html',
                }
            }
        }).
        state('root.userregister.personal', {
            url: '/dados-pessoais',
            views: {
                'form_user@root.userregister': {
                    templateUrl: '/partials/site/pages/user/register/form-personal.html',
                }
            }
        }).
        state('root.userregister.contact', {
            url: '/contatos',
            views: {
                'form_user@root.userregister': {
                    templateUrl: '/partials/site/pages/user/register/form-contacts.html',
                }
            }
        }).
        state('root.userregister.address', {
            url: '/endereco',
            views: {
                'form_user@root.userregister': {
                    templateUrl: '/partials/site/pages/user/register/form-address.html',
                }
            }
        }).
        state('root.userregister.register', {
            url: '/registrar',
            views: {
                'form_user@root.userregister': {
                    templateUrl: '/partials/site/pages/user/register/form-register.html',
                }
            }
        }).
        state('redirect', {
            url: 'redirect/:to',
            controller: function($state, $stateParams, $scope) {
                $state.go($stateParams.to, null, {reload: true});
            }
        });
    }
]);

R2Site.run([
    '$rootScope',
    '$templateCache',
    '$state',
    function($rootScope, $templateCache, $state) {

        console.log('nav', navigator);

        if(navigator.appName.indexOf("Internet Explorer")!=-1){     //yeah, he's using IE
            var badBrowser=(
                navigator.appVersion.indexOf("MSIE 9")==-1 &&   //v9 is ok
                navigator.appVersion.indexOf("MSIE 1")==-1  //v10, 11, 12, etc. is fine too
            );

            if(badBrowser){
                console.log('IE < 9');
                $rootScope.$broadcast('badNavigator', false);
            }
        }

/*        $rootScope.$on('$routeChangeStart', function(event, next, current) {
            if (typeof(current) !== 'undefined'){
                $templateCache.remove(current.templateUrl);
            }
        });*/
        $rootScope.$on('$viewContentLoaded', function() {
          $templateCache.removeAll();
       });

    }
]);