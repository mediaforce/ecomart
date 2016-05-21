'use strict';
/**
 * Addresses Directives
 * - adicionarEnderecos
 * - btnAddEndereco
 * - endereco
 */
var UsersDirectives = angular.module('UsersDirectives', [
    // shared\plugins\factories
    'underscore',

    // shared\services
    'BaseServices'
]);

// TEMPORÁRIO
UsersDirectives.run(function($templateCache) {
    $templateCache.removeAll();
});

UsersDirectives.directive('r2userUserUnique', [
    '_',
    'BaseEnumsFactory',
    'CheckUniqueUserFactory',
    function(_, BaseEnumsFactory, CheckUniqueUserFactory) {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/users/r2user-user-unique.html',
            replace: true,
            scope: {
                userModel: '=',
                form: '=',
                hasEntity: '=',
            },
            link: function(scope, element, attrs) {
                scope.changePassword = true;

                scope.showChangePassword = function() {
                    scope.changePassword = true;
                };

                scope.$watch('hasEntity', function(newVal) {
                    if (newVal) {
                        scope.changePassword = false;
                        scope.originalUser = scope.userModel.user;
                        scope.userModel.password = '';
                        scope.userModel.confpassword = '';
                    }
                });

                scope.$watch('[userModel.user,hasEntity]', function(newVal) {
                    var RE_EMAIL = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
                    var validateUser = true;

                    if (newVal[0] && newVal[1]) {
                        validateUser = newVal[0] != scope.originalUser;
                    }
                    console.log()
                    if (RE_EMAIL.test(newVal[0]) && validateUser) {
                        CheckUniqueUserFactory.show({
                            'user': newVal[0]
                        }, function(result) {
                            if (result.data) {
                                scope.form.access_user.$setValidity("unique", false);
                            } else {
                                scope.form.access_user.$setValidity("unique", true);
                            }
                        });
                    }
                });

            }
        };
    }
]);