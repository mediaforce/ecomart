'use strict';

R2Admin.controller('UsersHomeCtrl', [
    '$scope',
    'UsersFactory',
    'ngDialog',
    function (
    	$scope,
        UsersFactory,
        ngDialog

    	) {
    	console.log('USER HOME');

        $scope.itemsByPage = 10;

        UsersFactory.show(function (result) {
            console.log('USER HOME result.data', result.data);
            $scope.usersCollection = result.data;
            $scope.displayedUsersCollection = [].concat($scope.usersCollection);
        });

        $scope.gotoCustomer = function(customer) {
            $scope.customer = customer;
            ngDialog.open({
                template: 'partials/admin/pages/sales/cliente.html',
                className: 'ngdialog-theme-default',
                appendClassName: 'r2-cart-minhas-compras-dialog',
                controller: 'CustomerCtrl',
                scope: $scope
            });
        }
    }
]);

R2Admin.controller('UserSaveCtrl', [
    '$scope',
    function (
        $scope
        ) {
        
    }
]);


R2Admin.controller('UserLoginCtrl', [
    '$scope',
    '$state',
    'AuthService', // from shared\auth\AuthModule
    'AUTH_EVENTS', // from shared\auth\AuthModule
    function (
        $scope,
        $state,
        AuthService,
        AUTH_EVENTS
        ) {
        console.log('USER LOGIN CONTROLLER');

        $scope.User = {
            logged: false,
            error: null
        };

        if ($scope.User.logged == AuthService.isAuthenticated()) {
            $scope.User.name = AuthService.getUserName();
        }

        $scope.login = function() {
            AuthService.login($scope.User.user, $scope.User.password).then(
                function(authenticated) {
                    if (AUTH_EVENTS.notAuthenticated !== authenticated.result) {
                        $scope.User.error = null;
                        $scope.User.logado = true;
                        $state.go('admin', {}, {
                            reload: true
                        });
                    } else {
                        $scope.User.error = authenticated.error.data.data.result.error;
                        $scope.User.logado = authenticated.error.data.data.success;

                        $state.go($state.current, {}, {
                            reload: false
                        });
                    }
                }
            );
        };

        $scope.logout = function() {
            AuthService.logout();
            $state.go('admin.login', {}, {
                reload: true
            });
        };
    }
]);