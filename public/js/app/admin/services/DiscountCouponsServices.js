'use strict';

R2Admin.factory('DiscountCouponsFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/erp/product/discountcoupons/:id', { id: '@id'}, {
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