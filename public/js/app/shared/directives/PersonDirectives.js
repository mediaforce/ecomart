'use strict';
/**
 * Addresses Directives
 * - adicionarEnderecos
 * - btnAddEndereco
 * - endereco
 */
var PeopleDirectives = angular.module('PeopleDirectives', [
        // shared\plugins\factories
        'underscore',

        // shared\services
        'BaseServices'
    ]);

// TEMPORÁRIO
PeopleDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});

PeopleDirectives.directive('r2basePersonUnique', [
    '_',
    'BaseEnumsFactory',
    function(_, BaseEnumsFactory) {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/people/r2base-person-unique.html',
            replace: true,
            scope: {
                personModel: '=',
                form: '=',
                hasEntity: '=',
            },
            link: function(scope, element) {
                scope.options = {
                    genders: []
                };

                scope.$watch('hasEntity', function (newVal) {
                    if(newVal) {
                        if (scope.personModel.birth_date !== null) {
                            scope.personModel.birthDate = new Date(Date.parse( scope.personModel.birth_date.date.replace('-', '/', 'g') ) );
                        }
                    }
                });

                BaseEnumsFactory.show(function(result) {

                    // Popular as opções de sexo
                    _.each(
                        result.data.genders,
                        function(gender) {
                            scope.options.genders.push({
                                name: gender
                            });
                        }
                    );
                    scope.gendersLoad = true;

                });
            }
        };
    }
]);
