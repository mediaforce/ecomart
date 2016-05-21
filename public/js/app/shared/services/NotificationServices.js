'use strict';

var NotificationServices = angular.module('NotificationServices', ['ngResource']);

NotificationServices.factory('NotificationPagseguroFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/notification/pagseguro/:id', { id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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

NotificationServices.factory('NotificationCieloFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/notification/cielo/:id', { id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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