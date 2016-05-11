'use strict';

/*
R2Base Services:
- GetEnumsFactory
- PaisesDDIFactory
- PaisesFactory
- EstadosFactory
- CidadesFactory
 */

var BaseServices = angular.module('BaseServices', ['ngResource']);

BaseServices.factory('BaseEnumsFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/base/getenums/:id', { format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
            show: {
                method: 'GET',
                isArray: false,
                ignoreLoadingBar: true
            },
            save: {
                method: 'POST'
            },
            update: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }
]);

BaseServices.factory('CountriesIDDFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/base/countriesidd/:id', {}, {
            show: {
                method: 'GET',
                isArray: false
            },
            save: {
                method: 'POST'
            },
            update: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }
]);


BaseServices.factory('CountriesFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/base/countries/:id', {}, {
            show: {
                method: 'GET',
                isArray: false
            },
            save: {
                method: 'POST'
            },
            update: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }

]);

BaseServices.factory('StatesFactory', [
	'$resource',
    function($resource) {
        return $resource('/api/base/states/:id', {}, {
            show: {
                method: 'GET',
                isArray: false
            },
            save: {
                method: 'POST'
            },
            update: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }

]);

BaseServices.factory('CitiesFactory', [
	'$resource',
    function($resource) {
        return $resource('/api/base/cities/:id', {}, {
            show: {
                method: 'GET',
                isArray: false
            },
            save: {
                method: 'POST'
            },
            getByState: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }

]);