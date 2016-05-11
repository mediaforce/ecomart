'use strict';

var messages = {
    required: "Este campo é obrigatório",
    minlength: "Muito curto! Tamanho mínimo de @value@ caracteres.",
    pattern: "Não é um valor válido",
    "email": "Não é um email válido",
    "number": "Insira apenas números",
};


var R2Admin = angular.module('R2Admin', [
    // Modules
    'AuthModule',
    // 'TrackerModule',

    // Plugins
    'underscore',

    // Resources
    'ngResource',
    'ngCookies',
    'ui.router',
    'ngMessages',
    'favicon',
    'ui.utils.masks',
    'ncy-angular-breadcrumb',
    'ui-notification',
    'ngWYSIWYG',
    'ngDialog',
    'smart-table',
    'ngFileUpload',
    'ngFloatingLabels',
    'blockUI',
    'bsLoadingOverlay',

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
    'LabelDirectives',
    'CompanyDirectives',
    'VideosDirectives',

    // Services
    'BaseServices',
    'AclServices',
    'UserServices',
    'LocaleServices',
    'CompanyServices',
    'InventoriesServices',
    'NotificationServices',

    // Filters
    'StringFilters',
    'TableFilters'
]);

R2Admin.config([
    '$locationProvider', '$stateProvider', '$urlRouterProvider',
    function($locationProvider, $stateProvider, $urlRouterProvider) {

        $locationProvider.html5Mode({
            enabled: true
        });

        //$urlRouterProvider.otherwise('/404');

        $stateProvider.
        state('admin', {
            url: '/admin/',
            views: {
                'header': {
                    templateUrl: '/partials/admin/layout/header.html',
                    controller: 'HeaderCtrl'
                },
                'sidebar_left': {
                    templateUrl: '/partials/admin/layout/menu-sidebar.html'
                },
                'content': {
                    templateUrl: '/partials/admin/pages/home.html'
                },
                'footer': {
                    templateUrl: '/partials/admin/layout/footer.html'
                },
            },
            ncyBreadcrumb: {
                label: 'Home'
            }
        }).
        state('admin.login', {
            url: 'login/',
            views: {
                'header@': {
                    template: '',
                },
                'sidebar_left@': {
                    template: ''
                },
                'content@': {
                    templateUrl: '/partials/admin/pages/login/form.html',
                    controller: 'UserLoginCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Login'
            }
        }).
        state('admin.users', {
            url: 'usuarios/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/users/home.html',
                    controller: 'UsersHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Usuários'
            }
        }).
        state('admin.users.create', {
            url: 'criar/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/users/save.html',
                    controller: 'UserCreateCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Usuário'
            }
        }).
        state('admin.users.save', {
            url: 'salvar/:userId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/users/save.html',
                    controller: 'UserSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Usuário'
            }
        }).
        state('admin.manufacturers', {
            url: 'fabricantes/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/manufacturers/home.html',
                    resolve: {
                        // A string value resolves to a service
                        ManufacturersFactory: 'ManufacturersFactory',

                        // A function value resolves to the return
                        // value of the function
                        manufacturers: function(ManufacturersFactory){
                            return ManufacturersFactory.show().$promise;
                        }
                    },
                    controller: 'ManufacturersHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Fabricantes'
            }
        }).
        state('admin.products', {
            url: 'produtos/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/home.html',
                    resolve: {

                        ProductsFactory: 'ProductsFactory',

                        products: function(ProductsFactory){
                            return ProductsFactory.show().$promise;
                        }
                    },
                    controller: 'ProductsHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Produtos'
            }
        }).
        state('admin.products.create', {
            url: 'criar/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/save.html',
                    resolve: {
                        product: function() { return {}; },
                    },
                    controller: 'ProductSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Produto'
            }
        }).
        state('admin.products.save', {
            url: 'salvar/:productId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/save.html',
                    resolve: {
                        ProductsFactory: 'ProductsFactory',

                        product: function(ProductsFactory, $stateParams){
                            var productId = $stateParams.productId;
                            return ProductsFactory.show({id: productId}).$promise;
                        }
                    },
                    controller: 'ProductSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Produto'
            }
        }).
        state('admin.products.features', {
            url: 'caracteristicas/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/features/home.html',
                    resolve: {

                        FeaturesFactory: 'FeaturesFactory',
                        FeatureGroupsFactory: 'FeatureGroupsFactory',

                        features: function(FeaturesFactory){
                            return FeaturesFactory.show().$promise;
                        },

                        groups: function(FeatureGroupsFactory){
                            return FeatureGroupsFactory.show().$promise;
                        }
                    },
                    controller: 'FeaturesHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Características'
            }
        }).
        state('admin.products.departments', {
            url: 'departamentos/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/departments/home.html',
                    resolve: {

                        DepartmentsFactory: 'DepartmentsFactory',

                        departments: function(DepartmentsFactory){
                            return DepartmentsFactory.show().$promise;
                        }
                    },
                    controller: 'DepartmentsHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Departamentos'
            }
        }).
        state('admin.products.departments.create', {
            url: 'criar/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/departments/save.html',
                    resolve: {
                        department: function() { return {}; },
                    },
                    controller: 'DepartmentSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Departamento'
            }
        }).
        state('admin.products.departments.save', {
            url: 'salvar/:departmentId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/departments/save.html',
                    resolve: {
                        // A string value resolves to a service
                        DepartmentsFactory: 'DepartmentsFactory',

                        // A function value resolves to the return
                        // value of the function
                        department: function(DepartmentsFactory, $stateParams){
                            var departmentId = $stateParams.departmentId;
                            return DepartmentsFactory.show({id: departmentId}).$promise;
                        }
                    },
                    controller: 'DepartmentSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Departamento'
            }
        }).
        state('admin.products.combostores', {
            url: 'combos/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/combos/home.html',
                    resolve: {

                        CombosFactory: 'CombosFactory',

                        combos: function(CombosFactory){
                            return CombosFactory.show().$promise;
                        }
                    },
                    controller: 'CombosHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Combos'
            }
        }).
        state('admin.products.combostores.create', {
            url: 'criar/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/combos/save.html',
                    resolve: {
                        combo: function() { return {}; },
                    },
                    controller: 'ComboSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Combo'
            }
        }).
        state('admin.products.combostores.save', {
            url: 'salvar/:comboId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/products/combos/save.html',
                    resolve: {
                        combo: function() { return {}; },
                    },
                    controller: 'ComboSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Combo'
            }
        }).
        state('admin.coupons', {
            url: 'cupons-de-desconto/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/coupons/home.html',
                    resolve: {

                        DiscountCouponsFactory: 'DiscountCouponsFactory',

                        coupons: function(DiscountCouponsFactory){
                            return DiscountCouponsFactory.show().$promise;
                        }
                    },
                    controller: 'CouponsHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Cupons de Desconto'
            }
        }).
        state('admin.ordersale', {
            url: 'pedido-venda/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/sales/home.html',
                    controller: 'SaleOrdersHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Pedidos de venda'
            }
        }).
        state('admin.ordersale.save', {
            url: 'salvar/:saleOrderId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/sales/save.html',
                    controller: 'SaleOrderSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Pedido'
            }
        }).
        state('admin.customers', {
            url: 'clientes/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/customers/home.html',
                    controller: 'CustomersHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Clientes'
            }
        }).
        state('admin.customers.create', {
            url: 'criar/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/customers/save.html',
                    controller: 'CustomerCreateCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Criar Cliente'
            }
        }).
        state('admin.customers.save', {
            url: 'salvar/:customerId',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/customers/save.html',
                    controller: 'CustomerSaveCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Salvar Cliente'
            }
        }).
        state('admin.inventories', {
            url: 'estoque/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/inventories/home.html',
                    controller: 'InventoriesHomeCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'Estoque'
            }
        }).
         state('admin.test', {
            url: 'teste/',
            views: {
                'content@': {
                    templateUrl: '/partials/admin/pages/test.html',
                    controller: 'TestCtrl'
                }
            },
            ncyBreadcrumb: {
                label: 'TESTE'
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

R2Admin.run(
[
    '$rootScope',
    '$state',
    'AuthService',
    'AUTH_EVENTS',
    '$templateCache',
    '$window',
    'Notification',
    function($rootScope, $state, AuthService, AUTH_EVENTS, $templateCache, $window, Notification) {

        
        $rootScope.$on('$stateChangeStart', function (event, next, nextParams, fromState) {

            var accessDenied = true;

            if (!AuthService.isAuthenticated()) {
                if (next.name !== 'admin.login' && next.name !== 'redirect') {
                    event.preventDefault();
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                    Notification.error({
                            message: 'Você precisa realizar o seu login administrativo para acessar esta área do site!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    $state.go('admin.login', {}, {reload: true});
                }
            } else {
                var authorizedRoles = ['Admin'];
                if (!AuthService.isAuthorized(authorizedRoles) ) {
                    if (next.name !== 'admin.login' && next.name !== 'redirect') {
                        event.preventDefault();
                        $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                        Notification.error({
                            message: 'O seu usuário não possui permissões para acessar esta área do site!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $state.go('admin.login', {}, {reload: true});
                    }

                }
            }
        });
    }
]);
