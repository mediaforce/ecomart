'use strict';

var InventoriesServices = angular.module('InventoriesServices', ['ngResource']);

InventoriesServices.factory('StoresFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/order/stores/:id', { id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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

InventoriesServices.factory('ComboStoresFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/order/combostores/:id', { id: '@id'}, {
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

InventoriesServices.factory('OrderSalesFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/order/sale-orders/:id', { id: '@id'}, {
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


InventoriesServices.factory('SalesFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/order/sales/:id', { id: '@id'}, {
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