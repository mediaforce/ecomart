'use strict';

var PagseguroServices = angular.module('PagseguroServices', ['ngResource']);

PagseguroServices.factory('PagseguroFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/checkout/pagseguro/:id', { id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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