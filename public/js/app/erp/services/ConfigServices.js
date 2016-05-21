'use strict'

R2Erp.factory('ConfigFactory', [
	'$resource',
	function ($resource) {
		return $resource('/api/erp/configs/:id', {}, {
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
])