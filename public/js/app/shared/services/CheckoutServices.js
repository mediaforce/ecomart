'use strict';

var CheckoutServices = angular.module('CheckoutServices', ['ngResource']);

CheckoutServices.factory('BoletoBradescoFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/checkout/boleto-bradesco/:id', { id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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

CheckoutServices.factory('PagseguroFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/checkout/pagseguro/:id', { id: '@id'}, {
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

CheckoutServices.factory('TestReturnFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/checkout/testreturn/:id', { id: '@id'}, {
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

CheckoutServices.factory('CieloFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/checkout/cielo/:id', { id: '@id'}, {
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

CheckoutServices.factory('CalcFreteFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/base/calcfrete/:id', { id: '@id'}, {
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