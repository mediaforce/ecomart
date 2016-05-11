'use strict';

R2Admin.controller('HeaderCtrl', [
    '$scope',
    'AuthService',
    function (
    	$scope,
    	AuthService
    	) {
    	console.log('LAYOUT CONTROLLER');
    	$scope.logout = function() {
            AuthService.logout();
            $state.go('admin.login', {}, {
                reload: true
            });
        };
    }
]);