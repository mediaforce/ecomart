'use strict';

R2Admin.factory('ManufacturersFactory', [
    '$resource',
    function($resource) {
        function resourceErrorHandler(response) {
            console.log('ERRO', response);
        }

        return $resource('/api/erp/manufacturers/:id', { id: '@id'}, {
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