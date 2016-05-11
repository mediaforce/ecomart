'use strict';
/**
 * Addresses Directives
 * - adicionarEnderecos
 * - btnAddEndereco
 * - endereco
 */

var AddressesDirectives = angular.module('AddressesDirectives', [
        // shared\plugins\factories
        'underscore',

        // shared\services
        'BaseServices'
    ]);

// TEMPORÁRIO
AddressesDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});

AddressesDirectives.directive('r2baseAddAddresses', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/addresses/r2base-add-addresses.html',
            replace: true,
            scope: {
                addressesModel: '=',
                form: '=',
                hasEntity: '=',
            }
        };
    }
]);

AddressesDirectives.directive('r2baseBtnAddAddress', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                angular.element(document.getElementById('section-to-adresses')).prepend($compile("<div data-r2base-address-collection></div>")(scope));
            });
        };
    }
]);

TelephonesDirectives.directive('r2basePopulateAddresses', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.addressesModel.length > 0) {
                        _.each(scope.addressesModel, function(address) {
                            angular.element(document.getElementById('section-to-adresses')).prepend($compile("<div data-r2base-address-collection data-address-id='" + address.id +"' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

AddressesDirectives.directive('r2baseAddressCollection', [
    '_',                    // from shared\plugins\factories\underscore,
    'StatesFactory',
    'CitiesFactory',       // from shared\services\R2BaseServices
    '$http',
    '$q',
    function(_, StatesFactory, CitiesFactory, $http, $q) {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/addresses/r2base-address-collection.html',
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {

                scope.editableInputSeekCep = true;
                scope.statesLoad = false;
                scope.stateIsSelected = false;
                scope.citiesLoad = false;
                scope.loadAll = false;

                scope.options = {
                    states: [],
                    cities: [],
                };

                StatesFactory.show(function(result) {
                    _.each(
                        result.data,
                        function(state) {
                            scope.options.states.push({
                                id: state.id,
                                name: state.code,
                                ibge_code: state.ibge_code,
                            });
                        }
                    );

                    scope.statesLoad = true;

                    scope.loadAll = true;

                });

                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.$watch('loadAll', function (newVal) {
                        if(newVal) {
                            scope.index = scope.addressesModel.indexOf(_.findWhere(scope.addressesModel, {id: Number(attrs.addressId)} ) );

                            var strStateId = scope.addressesModel[scope.index].state.id.toString();
                            scope.addressesModel[scope.index].state = strStateId;
                            var promise = scope.stateSelectChange(strStateId);

                            promise.then(function () {
                                var city = _.find(scope.options.cities, function (val_city) {
                                    if (val_city.id == scope.addressesModel[scope.index].city.id) return val_city;
                                    return null;
                                });

                                if (city !== null && city !== undefined) {
                                    scope.addressesModel[scope.index].city = city.id.toString();
                                }

                                return true;

                            });

                        }
                    });
                } else {
                    scope.addressesModel.push({
                        state: null,
                        city: null,
                        neighborhood: null,
                        postcode: null,
                        address1: null,
                        address2: null,
                        number: null,
                        description: null,
                    });

                    scope.index = scope.addressesModel.length - 1;
                }


                // Populará as cidades de acordo com o estado escolhido
                scope.stateSelectChange = function(state) {

                    var deferred = $q.defer();

                    if (state > 0) {

                        scope.options.cities = [];

                        scope.citiesLoad = false;

                        scope.stateIsSelected = true;

                        CitiesFactory.getByState({
                            id: state
                        }, function(result) {
                            _.each(
                                result.data,
                                function(city) {
                                    scope.options.cities.push({
                                        id: city.id,
                                        name: city.name
                                    });

                                }
                            );

                            scope.citiesLoad = true;

                            deferred.resolve();

                        });
                    }

                    return deferred.promise;
                };

                scope.removeElement = function () {
                    setTimeout(function () {
                        scope.$apply(function () {
                            scope.form['address_postcode['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_state['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_city['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_neighborhood['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_address1['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_address2['+scope.index+']'].$setValidity('required', true);
                            scope.form['address_number['+scope.index+']'].$setValidity('required', true);
                        });
                    }, 10);

                    scope.addressesModel.splice(scope.index, 1);

                    $(element).detach();
                };

                scope.$watch('addressesModel['+scope.index+'].postcode', function (newVal, oldVal) {

                    if (newVal != undefined) {
                        scope.editableInputSeekCep = false;
                        var promise = null;

                        $http.get( "http://api.postmon.com.br/v1/cep/" + newVal )
                        .then(function(response) {
                            var endereco = response.data;

                            var state =_.find(scope.options.states, function (val_state) {
                                if (val_state.name == endereco.estado) return val_state;
                            });

                            if (state !== undefined && state !== null) {

                                scope.addressesModel[scope.index].state = state.id.toString();
                                promise = scope.stateSelectChange(state.id);
                                promise.then(function () {
                                    var city = _.find(scope.options.cities, function (val_city) {
                                        if (val_city.id == Number(endereco.cidade_info.codigo_ibge.substr(0, 6))) return val_city;
                                        return null;
                                    });

                                    if (city !== null && city !== undefined) {
                                        scope.addressesModel[scope.index].city = city.id.toString();
                                    }

                                    scope.addressesModel[scope.index].neighborhood = endereco.bairro;
                                    scope.addressesModel[scope.index].address1 = endereco.logradouro;

                                    return true;

                                }).then(function () {
                                    scope.editableInputSeekCep = true;
                                });

                            };
                        });
                    } else {
                        scope.editableInputSeekCep = true;
                    }
                });
            }
        };
    }
]);

AddressesDirectives.directive('r2baseAddressUnique', [
    '_',                    // from shared\plugins\factories\underscore
    'StatesFactory',         // from shared\services\R2BaseServices
    'CitiesFactory',        // from shared\services\R2BaseServices
    '$http',
    '$q',
    function(_, StatesFactory, CitiesFactory, $http, $q) {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/addresses/r2base-address-unique.html',
            replace: true,
            scope: {
                addressModel: '=',
                form: '=',
                hasEntity: '=',
            },
            link: function(scope, element) {
                scope.editableInputSeekCep = true;
                scope.cities = [];
                scope.stateIsSelected = false;
                scope.cities = [];
                scope.statesLoad = false;
                scope.loadAll = false;

                scope.options = {
                    states: [],
                    cities: [],
                };

                StatesFactory.show(function(result) {

                    _.each(
                        result.data,
                        function(state) {
                            scope.options.states.push({
                                id: state.id,
                                name: state.code
                            });
                        }
                    );

                    scope.statesLoad = true;

                    scope.loadAll = true;

                });

                // Populará as cidades de acordo com o estado escolhido
                scope.stateSelectChange = function(state) {
                    var deferred = $q.defer();

                    if (state > 0) {

                        scope.options.cities = [];

                        scope.citiesLoad = false;

                        scope.stateIsSelected = true;

                        CitiesFactory.getByState({
                            id: state
                        }, function(result) {
                            _.each(
                                result.data,
                                function(city) {
                                    scope.options.cities.push({
                                        id: city.id,
                                        name: city.name
                                    });

                                }
                            );

                            scope.citiesLoad = true;

                            deferred.resolve();

                        });
                    }

                    return deferred.promise;
                }


                scope.$watch('addressModel.postcode', function (newVal, oldVal) {
                    console.log('POST CODE', newVal);
                    if (newVal != undefined) {
                        scope.editableInputSeekCep = false;

                        $http.get( "http://api.postmon.com.br/v1/cep/" + newVal )
                        .then(function(response) {
                            var endereco = response.data;

                            var state =_.find(scope.options.states, function (val_state) {
                                if (val_state.name == endereco.estado) return val_state;
                            });

                            if (state !== undefined && state !== null) {

                                scope.addressModel.state = state.id.toString();
                                var promise = scope.stateSelectChange(state.id);
                                promise.then(function () {
                                    var city = _.find(scope.options.cities, function (val_city) {
                                        if (val_city.id == Number(endereco.cidade_info.codigo_ibge.substr(0, 6))) return val_city;
                                        return null;
                                    });

                                    if (city !== null && city !== undefined) {
                                        scope.addressModel.city = city.id.toString();
                                    }

                                    scope.addressModel.neighborhood = endereco.bairro;
                                    scope.addressModel.address1 = endereco.logradouro;

                                    return true;

                                }).then(function () {
                                    scope.editableInputSeekCep = true;
                                });

                            };
                        });

                    } else {
                        scope.editableInputSeekCep = true;
                    }
                })


            }
        };
    }
]);
