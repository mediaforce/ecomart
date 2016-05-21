'use strict';
/**
 * Users Controllers
 * - SharedUserCreateCtrl
 * - SharedUsersLoginCtrl
 */
var UsersControllers = angular.module('UsersControllers', [
    // shared\plugins\factories
    'underscore',

    // shared\auth\AuthModule
    'AuthModule',

    // shared\services
    'BaseServices',
    'UserServices',
    'AclServices'
]);

UsersControllers.controller('UserSaveCtrl', [
    '$scope',
    '_', // from shared\plugins\factories\underscore
    'UsersFactory', // from shared\services\UserServices
    'RolesFactory', // from shared\services\AclServices
    '$stateParams',
    'Notification',
    function (
        $scope,
        _,
        UsersFactory,
        RolesFactory,
        $stateParams,
        Notification
    ) {

        $scope.pageTitle = null;
        $scope.hasUser = false;
        $scope.originalUser = null;

        $scope.user = {
            id: null,
            user: null,
            password: null,
            confpassword: null,
            notes: null,

            person: {
                name: null,
                surname: null,
                gender: null,
                nationality: null,
                birthDate: null,
                teste: null,
                photo: null,
                description: null,
                documents: [],
                socialNetworks: [],
                emails: [],
                telephones: [],
                creditCards: [],
                addresses: []
            },

        };

        if ($stateParams.id == undefined) {
            $scope.pageTitle = 'Criar Novo Usuário';
        } else {
            $scope.pageTitle = 'Usuário ID: ' + $stateParams.id;

            UsersFactory.show({id: $stateParams.id},
                function (result) {
                    $scope.user = result.data;
                    $scope.user.person.socialNetworks = $scope.user.person.social_networks;
                    $scope.user.person.creditCards = $scope.user.person.credit_cards;
                    $scope.hasUser = true;

                    console.log('USUÁRIO', $scope.user);
                }
            );
        }

        $scope.verifyUser = function() {
            console.log('USUARIO', $scope.user);
        };

        $scope.saveUser = function() {
            if ($scope.hasUser) {
                UsersFactory.update({id: $scope.user.id, user: $scope.user}, function(result) {
                    console.log('RESULTADO UPDATE', result);
                });
            } else {
                UsersFactory.save($scope.user, function(result) {
                    console.log('RESULTADO SAVE', result);
                });
            }

        };

    }
]);

UsersControllers.controller('UserListCtrl', [
    '$scope',
    '_', // from shared\plugins\factories\underscore
    'BaseEnumsFactory', // from shared\services\BaseServices
    'StatesFactory', // from shared\services\BaseServices
    'UsersFactory', // from shared\services\UserServices
    'RolesFactory', // from shared\services\AclServices
    'CheckUniqueUserFactory', // from shared\services\UserServices
    function (
        $scope,
        _,
        BaseEnumsFactory,
        StatesFactory,
        UsersFactory,
        RolesFactory,
        CheckUniqueUserFactory
    ) {
        //console.log('USER LIST');
    }
]);



UsersControllers.controller('UsersLoginCtrl', [

    '$scope',
    '$state',
    'AuthService', // from shared\auth\AuthModule
    'AUTH_EVENTS', // from shared\auth\AuthModule

    function(
        $scope,
        $state,
        AuthService,
        AUTH_EVENTS
    ) {

        $scope.User = {
            logged: false,
            error: null
        };

        if ($scope.User.logged == AuthService.isAuthenticated()) {
            $scope.User.name = AuthService.getUserNomeCompleto();
        }

        $scope.logarUser = function(User, redirect) {
            AuthService.login(User.User, User.password).then(
                function(authenticated) {
                    if (AUTH_EVENTS.notAuthenticated !== authenticated.result) {
                        $scope.User.error = null;
                        $scope.User.logado = true;
                        $state.go('redirect', {
                            to: redirect
                        }, {
                            reload: true
                        });
                    } else {
                        $scope.User.error = authenticated.error.data.data.result.error;
                        $scope.User.logado = authenticated.error.data.data.success;

                        $state.go($state.current, {}, {
                            reload: false
                        });
                    }
                }
            );
        };

        $scope.deslogarUser = function(redirect) {
            AuthService.logout();
            $state.go('redirect', {
                to: redirect
            }, {
                reload: true
            });
        };
    }
]);





























































































































UsersControllers.controller('UserCreateCtrl', [
    '$scope',
    '_', // from shared\plugins\factories\underscore
    'BaseEnumsFactory', // from shared\services\BaseServices
    'StatesFactory', // from shared\services\BaseServices
    'UsersFactory', // from shared\services\UserServices
    'RolesFactory', // from shared\services\AclServices
    'CheckUniqueUserFactory', // from shared\services\UserServices

    function(
        $scope,
        _,
        BaseEnumsFactory,
        StatesFactory,
        UsersFactory,
        RolesFactory,
        CheckUniqueUserFactory
    ) {

        /* VARIÁVEIS INIT */
        // Pre-carregando variáveis para uso do REST de 'R2User'. Objeto que será enviado pelo formulário para inserções e updates...
        $scope.user = {
            user: null,
            password: null,
            confpassword: null,
            notes: null,

            person: {
                name: null,
                surname: null,
                gender: null,
                nationality: null,
                birthDate: null,
                teste: null,
                photo: null,
                description: null,
                documents: [],
                socialNetworks: [],
                emails: [],
                telephones: [],
                creditCards: [],
                addresses: []
            },

        };

        // Variáveis para popular as opções do formulário através das factories
        $scope.options = {
            genders: [],
            roles: [],
            physicalDocumentType: [],
            legalDocumentType: [],
            states: [],
            cardBrands: [],
            mobileMNOs: [],
            telephoneTypes: [],
        };

        /* FACTORIES POPULATE */
        BaseEnumsFactory.show(function(result) {

            // Popular as opções de sexo
            _.each(
                result.data.genders,
                function(gender) {
                    $scope.options.genders.push({
                        name: gender
                    });
                }
            );
            $scope.gendersLoad = true;

            // Popular as opções de tipos de documento
            _.each(
                result.data.physicalDocumentType,
                function(documentType) {
                    $scope.options.physicalDocumentType.push({
                        name: documentType
                    });
                }
            );

            _.each(
                result.data.legalDocumentType,
                function(documentType) {
                    $scope.options.legalDocumentType.push({
                        name: documentType
                    });
                }
            );

            $scope.documentTypesLoad = true;

            // Popular as opções de tipos de bandeiras de cartão
            _.each(
                result.data.cardBrands,
                function(cardBrand) {
                    $scope.options.cardBrands.push({
                        name: cardBrand
                    });
                }
            );
            $scope.cardBrandsLoad = true;

            // Popular as opções de tipos de tipos de telefone
            _.each(
                result.data.telephoneTypes,
                function(telephoneType) {
                    $scope.options.telephoneTypes.push({
                        name: telephoneType
                    });
                }
            );
            $scope.telephoneTypesLoad = true;

            // Popular as opções de tipos de operadoras (vivo, claro, oi, etc...)
            _.each(
                result.data.mobileMNOs,
                function(mobileMNO) {
                    $scope.options.mobileMNOs.push({
                        name: mobileMNO
                    });
                }
            );
            $scope.mobileMNOsLoad = true;
        });

        RolesFactory.show(function(result) {

            _.each(
                result.data,
                function(role) {
                    $scope.options.roles.push({
                        id: role.id,
                        name: role.name
                    });
                }
            );

            $scope.rolesLoad = true;
        });

        $scope.$watch('user.user', function(newVal) {
            var RE_EMAIL = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
            if (RE_EMAIL.test(newVal)) {
                CheckUniqueUserFactory.show({
                    'user': $scope.user.user
                }, function(result) {
                    if (result.data) {
                        $scope.userForm.access_user.$setValidity("unique", false);
                    } else {
                        $scope.userForm.access_user.$setValidity("unique", true);
                    }
                });
            }
        })

        /* SCOPE METHODS*/

        // Methods for TEST!!!!!!!!!!!!!!!!!!!
        $scope.verifyUser = function() {
            console.log('USUARIO', $scope.user);
        };

        $scope.createUser = function() {
            UsersFactory.save($scope.user, function(result) {
                console.log('RESULTADO', result);
            });
        };
    }
]);