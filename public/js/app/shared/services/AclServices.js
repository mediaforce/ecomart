'use strict';

/*
Acl Services:
- RolesFactory
 */

var AclServices = angular.module('AclServices', ['ngResource']);

AclServices.factory('RolesFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/acl/roles/:id', { format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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