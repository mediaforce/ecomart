'use strict';

var CouponServices = angular.module('CouponServices', ['ngResource']);

CouponServices.factory('CouponsFactory', [
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