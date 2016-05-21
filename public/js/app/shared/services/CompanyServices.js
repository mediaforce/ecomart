'use strict';

/*
Acl Services:
- RolesFactory
 */

var CompanyServices = angular.module('CompanyServices', ['ngResource']);

CompanyServices.factory('CompaniesFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/base/companies/:id', {id: '@id',  format: 'json', jsoncallback: 'JSON_CALLBACK' }, {
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