'use strict';

R2Site.controller('LoginCtrl', [
    '$scope',
    '$state',
    'AuthService',
    'AUTH_EVENTS',
    '$rootScope',
    'ForgotPassFactory',
    function (
        $scope,
        $state,
        AuthService,
        AUTH_EVENTS,
        $rootScope,
        ForgotPassFactory
        ) {

        console.log('LOGIN CTRL');

        $scope.user = {};

        $scope.senhaErrada = false;

        $scope.forgotPassword = function () {
            ForgotPassFactory.get({user: $scope.user.user}, function (result) {
                
            })
        }


        $scope.login = function() {
            AuthService.login($scope.user.user, $scope.user.password).then(
                function(authenticated) {
                    if (AUTH_EVENTS.notAuthenticated !== authenticated.result) {
                        $scope.confirm(authenticated);
                        $state.go('root', {}, {
                            reload: true
                        });
                    }
                }
            );
        };

        $rootScope.$on('notLogged', function (args) {
            console.log('1', args);
            $scope.senhaErrada = true;
        });
    }
]);

R2Site.controller('CreateUserCtrl', [
    '$scope',
    '$state',
    'BaseEnumsFactory',
    'StatesFactory',
    'CitiesFactory',
    '$http',
    '$q',
    'UsersFactory',
    'Notification',
    'ngDialog',
    function (
        $scope,
        $state,
        BaseEnumsFactory,
        StatesFactory,
        CitiesFactory,
        $http,
        $q,
        UsersFactory,
        Notification,
        ngDialog
        ) {
        $scope.options = {
            telephoneTypes: [],
            states: [],
            cities: [],
        };
        
        $scope.editableInputSeekCep = true;
        $scope.statesLoad = false;
        $scope.stateIsSelected = false;
        $scope.citiesLoad = false;
        $scope.loadAll = false;

        $scope.user = {
            customerType: 'PHYSICAL',
            person: {
                name: '',
                surname: '',
                documents: [
                    {
                        documentType: 'CPF',
                        field1: ''
                    },
                    {
                        documentType: 'CNPJ',
                        field1: ''
                    }

                ],
                telephones: [
                    {}
                ],
                addresses: [
                    {}
                ]
            }
        };

        var oriUser = angular.copy($scope.user);

        BaseEnumsFactory.show(function(result) {
            // Popular as opções de tipos de tipos de telefone
            _.each(
                result.data.telephoneTypes,
                function(telephoneType) {
                    $scope.options.telephoneTypes.push({
                        name: telephoneType
                    });
                }
            );
        });

        StatesFactory.show(function(result) {
                    _.each(
                        result.data,
                        function(state) {
                            $scope.options.states.push({
                                id: state.id,
                                name: state.code,
                                ibge_code: state.ibge_code,
                            });
                        }
                    );

            $scope.statesLoad = true;

        });

        $scope.stateSelectChange = function(state) {

            var deferred = $q.defer();

            if (state > 0) {

                $scope.options.cities = [];

                $scope.citiesLoad = false;

                $scope.stateIsSelected = true;

                CitiesFactory.show({
                    stateId: state
                }, function(result) {
                    console.log('CIDADES', result);
                    _.each(
                        result.data,
                        function(city) {
                            $scope.options.cities.push({
                                id: city.id,
                                name: city.name
                            });

                        }
                    );

                    $scope.citiesLoad = true;

                    deferred.resolve();

                });
            }

            return deferred.promise;
        };

        $scope.nextStep = function (step) {
            $scope.stepForm = step;

            switch(step) {
                case 2:
                    $state.go('root.userregister.personal');
                    break;
                case 3:
                    $state.go('root.userregister.contact');
                    break;
                case 4:
                    $state.go('root.userregister.address');
                    break;
                case 5:
                    $state.go('root.userregister.register');
                    break;
            }
        }

        $scope.$watch('user.customerType', function (newVal) {
            if (newVal == 'PHYSICAL' ) {
                $scope.user.person.name = '';
                $scope.user.person.surname = '';
                $scope.user.person.documents[0].field1 = '';
                $scope.user.person.documents[1].field1 = '';
                $scope.phPersonName = 'Nome Completo';
                $scope.phPersonDocument = 'CPF';

                if ($scope.userForm.person_surname != undefined) {
                     $scope.userForm.person_surname.$setValidity("required", true);
                     $scope.userForm.person_document_cnpj.$setValidity("required", true);
                     $scope.userForm.person_document_cnpj.$setValidity("cnpj", true);
                     $scope.userForm.person_document_cpf.$setValidity("required", false);
                     $scope.userForm.person_document_cpf.$setValidity("cpf", false);
                }
            } else if (newVal == 'LEGAL') {
                $scope.user.person.name = '';
                $scope.user.person.surname = '';
                $scope.user.person.documents[0].field1 = '';
                $scope.user.person.documents[1].field1 = '';
                $scope.phPersonName = 'Nome Completo';
                $scope.phPersonSurname = 'Razão Social';
                $scope.phPersonDocument = 'CNPJ';
                $scope.userForm.person_surname.$setValidity("required", false);
                $scope.userForm.person_document_cnpj.$setValidity("required", false);
                $scope.userForm.person_document_cnpj.$setValidity("cnpj", false);
                $scope.userForm.person_document_cpf.$setValidity("required", true);
                $scope.userForm.person_document_cpf.$setValidity("cpf", true);
            }
        });

        $scope.$watchCollection('userForm.person_surname', function(newVal) {
            if (newVal != undefined && $scope.user.customerType == 'PHYSICAL') {
                $scope.userForm.person_surname.$setValidity("required", true);
                $scope.userForm.person_document_cnpj.$setValidity("required", true);
                $scope.userForm.person_document_cnpj.$setValidity("cnpj", true);
                $scope.userForm.person_document_cpf.$setValidity("required", false);
                $scope.userForm.person_document_cpf.$setValidity("cpf", false);
            }
        });

        $scope.$watch('user.person.addresses[0].postcode', function (newVal, oldVal) {

            if (newVal != undefined) {
                $scope.editableInputSeekCep = false;
                var promise = null;

                var callCep = 'https://api.postmon.com.br/v1/cep/' + newVal;
                $http.jsonp(callCep + '?callback=JSON_CALLBACK')
                    .then(function(response) {
                    var endereco = response.data;

                    var state =_.find($scope.options.states, function (val_state) {
                        if (val_state.name == endereco.estado) return val_state;
                    });

                    if (state !== undefined && state !== null) {

                        $scope.user.person.addresses[0].state = state.id.toString();
                        promise = $scope.stateSelectChange(state.id);
                        promise.then(function () {
                            var city = _.find($scope.options.cities, function (val_city) {
                                if (val_city.id == Number(endereco.cidade_info.codigo_ibge.substr(0, 6))) return val_city;
                                return null;
                            });

                            if (city !== null && city !== undefined) {
                                $scope.user.person.addresses[0].city = city.id.toString();
                            }

                            $scope.user.person.addresses[0].neighborhood = endereco.bairro;
                            $scope.user.person.addresses[0].address1 = endereco.logradouro;

                            return true;

                        }).then(function () {
                            $scope.editableInputSeekCep = true;
                        });

                    };
                });
            } else {
                $scope.editableInputSeekCep = true;
            }
        });

        $scope.userRegister = function () {
            UsersFactory.save($scope.user, function (result) {
                if (result.success) {
                    Notification.success({
                        message: 'Você está apto a realizar a sua identifação em nosso site.',
                        title: 'Cliente Cadastrado Com Sucesso!',
                        templateUrl: '/partials/shared/notifications/generic.html'
                    });
                    $scope.userReset();
                    $state.go('root.checkout');
                    //ngDialog.open({ template: '/partials/site/pages/user/login/form.html', className: 'ngdialog-theme-default', controller: 'LoginCtrl', scope: $scope });
                }
            });
        }

        $scope.goToSetOne = function () {
            $scope.stepForm = 1;
            $state.go('root.userregister.access');
        }

        $scope.userReset = function () {
            $scope.user = angular.copy(oriUser);
            $scope.userForm.$setPristine();
        }

        $scope.goToSetOne();
    }
]);

R2Site.controller('ComprasUserCtrl', [
    '$scope',
    'OrderSalesFactory',
    'AuthService',
    'Notification',
    'ngDialog',
    function (
        $scope,
        OrderSalesFactory,
        AuthService,
        Notification,
        ngDialog
        ) {

        $scope.itemsByPage = 5;

        if (!AuthService.isAuthenticated()) {
            Notification.error({
                message: 'Você precisa estar logado para ver as suas compras.',
                title: 'Aviso!',
                templateUrl: '/partials/shared/notifications/generic.html'
            });
        } else {
            OrderSalesFactory.show({customerId: AuthService.getUserId()}, function (result) {
                console.log('ORDERS', result);
                $scope.comprasCollection = result.data;
                $scope.displayedCollection = [].concat($scope.comprasCollection);
            }); 
        }
        $scope.verCarrinho = function(sales) {
            $scope.sales = sales;
            ngDialog.open({
                template: 'partials/site/pages/user/minhas-compras/carrinho.html',
                className: 'ngdialog-theme-default',
                appendClassName: 'r2-cart-minhas-compras-dialog',
                controller: 'MeuCarrinhoUserCtrl',
                scope: $scope
            });
        }
        
    }
]);

R2Site.controller('MeuCarrinhoUserCtrl', [
    '$scope',
    'UsersFactory',
    '_',
    function (
        $scope,
        UsersFactory,
        _
        ) {
        
        _.each($scope.sales, function(sale) {
            if (sale.store !== undefined) {
                console.log('STORE...');
                var cover = _.find(sale.store.product.images, function(image) {
                    if (image.isCover) return true;
                });
                sale.cover = cover;
                sale.title = sale.store.product.title;
            } else if (sale.comboStore !== undefined) {
                console.log('COMBO STORE...');
                sale.cover = sale.comboStore.comboProduct.thumbnail;
                sale.title = sale.comboStore.comboProduct.title;
            }
        })
        console.log('SALES', $scope.sales);
        $scope.displayedCollection = $scope.sales;
    }
]);

R2Site.controller('ContaUserCtrl', [
    '$scope',
    'UsersFactory',
    'AuthService',
    'Notification',
    '$state',
    function (
        $scope,
        UsersFactory,
        AuthService,
        Notification,
        $state
        ) {

        console.log('CONTA USER');


        $scope.user = {
            password: '',
        };

        $scope.hasUser = false;

        if (AuthService.isAuthenticated()) {
            console.log(AuthService.getUserId());
            UsersFactory.show({id: AuthService.getUserId()}, function (result) {
                console.log('USUÁRIO', result);
                $scope.user = result.data;
                $scope.user.password = '';
                $scope.hasUser = true;
            })
        } else {
           Notification.error({
                message: 'Você precisa estar logado para ver a sua conta.',
                title: 'Aviso!',
                templateUrl: '/partials/shared/notifications/generic.html'
            }); 
        }

        $scope.updatePassword = function () {
            

            if (AuthService.isAuthenticated()) {
                UsersFactory.update( {id: $scope.user.id, data: $scope.user, onlyPassword: true } , function (result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Senha alterada com sucesso.',
                            title: 'Aviso!',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $scope.user.password = '';
                        $scope.user.confPassword = '';
                        console.log('UPDATE PASSWORD SUCCESS', result);

                        //ngDialog.open({ template: '/partials/site/pages/user/login/form.html', className: 'ngdialog-theme-default', controller: 'LoginCtrl', scope: $scope });
                    } else {
                        console.log('UPDATE PASSWORD ERROR', result);
                    }

                });
            }
        }

        $scope.updateAddress = function () {
            if (AuthService.isAuthenticated()) {
                UsersFactory.update( {id: $scope.user.id, data: $scope.user, onlyAddress: true } , function (result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Endereço alterado com sucesso.',
                            title: 'Aviso!',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $scope.user.password = '';
                        $scope.user.confPassword = '';
                        console.log('UPDATE PASSWORD SUCCESS', result);

                        //ngDialog.open({ template: '/partials/site/pages/user/login/form.html', className: 'ngdialog-theme-default', controller: 'LoginCtrl', scope: $scope });
                    } else {
                        console.log('UPDATE PASSWORD ERROR', result);
                    }

                });
            }
        }


    }
]);


R2Site.controller('RecadastrarSenhaCtrl', [
    '$scope',
    'UsersFactory',
    'AuthService',
    'Notification',
    '$state',
    '$stateParams',
    function (
        $scope,
        UsersFactory,
        AuthService,
        Notification,
        $state,
        $stateParams
        ) {

        console.log('RecadastrarSenhaCtrl');

        console.log('KEY', $stateParams.key);

        $scope.updatePassword = function () {
            
            UsersFactory.update( {id: $scope.user.id, data: $scope.user, activationKey: $stateParams.key, recadastrarSenha: true } , function (result) {
                if (result.success) {
                    Notification.success({
                        message: 'Senha alterada com sucesso.',
                        title: 'Aviso!',
                        templateUrl: '/partials/shared/notifications/generic.html'
                    });
                    $scope.user.password = '';
                    $scope.user.confPassword = '';
                    console.log('UPDATE PASSWORD SUCCESS', result);

                    //ngDialog.open({ template: '/partials/site/pages/user/login/form.html', className: 'ngdialog-theme-default', controller: 'LoginCtrl', scope: $scope });
                } else {
                    console.log('UPDATE PASSWORD ERROR', result);
                }

            });
        }


    }
]);