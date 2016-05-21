'use strict';

/*
R2User Services:
- UsuariosFactory
 */

var UserServices = angular.module('UserServices', ['ngResource']);

UserServices.factory('UsersFactory', [
    '$resource',
    function($resource) {
        function resourceErrorHandler(response) {
            console.log('ERRO', response);
        }

        return $resource('/api/user/users/:id', { id: '@id'}, {
            show: {
                method: 'GET',
                isArray: false,
                interceptor : {responseError : resourceErrorHandler}
            },
            save: {
                method: 'POST',
                interceptor : {responseError : resourceErrorHandler}
            },
            update: {
                method: 'PUT',
                params: {
                    id: '@id'
                },
                interceptor : {responseError : resourceErrorHandler}
            },
            delete: {
                method: 'DELETE',
                params: {
                    id: '@id'
                },
                interceptor : {responseError : resourceErrorHandler}
            }
        });
    }

]);


UserServices.factory('CheckUniqueUserFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/user/uniqueuser/:user', {}, {
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

UserServices.factory('ForgotPassFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/user/forgot-password/:user', {}, {
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