'use strict';

R2Admin.factory('OrderProductStoresFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/order/product-stores/:id', { id: '@id'}, {
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