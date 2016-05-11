'use strict';
/**
 * TelephonesDirectives
 * - addTelephones
 * - btnAddTelephone
 * - telephone
 */

var TelephonesDirectives = angular.module('TelephonesDirectives', ['BaseServices']);

// TEMPORÁRIO
TelephonesDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});

TelephonesDirectives.directive('r2baseAddTelephones', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/telephones/r2base-add-telephones.html',
            replace: true,
            scope: {
                telephonesModel: '=',
                form: '=',
                hasEntity: '=',
            }
        };
    }
]);

TelephonesDirectives.directive('r2baseBtnAddTelephone', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                angular.element(document.getElementById('section-to-telephones')).prepend($compile("<div data-r2base-telephone-collection></div>")(scope));
            });
        };
    }
]);

TelephonesDirectives.directive('r2basePopulateTelephones', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.telephonesModel.length > 0) {
                        _.each(scope.telephonesModel, function(telephone) {
                            angular.element(document.getElementById('section-to-telephones')).prepend($compile("<div data-r2base-telephone-collection data-telephone-id='" + telephone.id +"' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

TelephonesDirectives.directive('r2baseTelephoneCollection', [
    'BaseEnumsFactory',
    function(BaseEnumsFactory) {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/telephones/r2base-telephone-collection.html',
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {

                scope.options = {
                    telephoneTypes: [],
                    mobileMNOs: []
                };

                scope.loadAll = false;

                BaseEnumsFactory.show(function(result) {
                    // Popular as opções de tipos de tipos de telefone
                    _.each(
                        result.data.telephoneTypes,
                        function(telephoneType) {
                            scope.options.telephoneTypes.push({
                                name: telephoneType
                            });
                        }
                    );
                    scope.telephoneTypesLoad = true;

                    _.each(
                        result.data.mobileMNOs,
                        function(mobileMNO) {
                            scope.options.mobileMNOs.push({
                                name: mobileMNO
                            });
                        }
                    );
                    scope.mobileMNOsLoad = true;

                    scope.loadAll = true;
                });

                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.$watch('loadAll', function (newVal) {
                        if(newVal) {
                            scope.index = scope.telephonesModel.indexOf(_.findWhere(scope.telephonesModel, {id: Number(attrs.telephoneId)} ) );
                            scope.telephonesModel[scope.index].telephoneType = scope.telephonesModel[scope.index].telephone_type;
                            scope.telephonesModel[scope.index].mobileMNO = scope.telephonesModel[scope.index].mobile_mno;
                        }

                    });
                } else {
                    scope.telephonesModel.push({
                        telephoneType: null,
                        countryIDD: null,
                        region: null,
                        number: null,
                        mobileMNO: null,
                        extension: null
                    });


                    scope.index = scope.telephonesModel.length - 1;
                }

                scope.removeElement = function () {
                    setTimeout(function () {
                        scope.$apply(function () {
                            scope.form['tel_telephoneType['+scope.index+']'].$setValidity('required', true);
                            scope.form['tel_number['+scope.index+']'].$setValidity('required', true);
                        });
                    }, 10);

                    scope.telephonesModel.splice(scope.index, 1);

                    $(element).detach();

                }

                scope.$watchCollection('telephonesModel', function (_newCol, _oldCol, _scope) {

                    var element = _oldCol[_scope.index];
                    var newIndex = _newCol.indexOf(element);

                    if (newIndex !== scope.index) scope.index = newIndex;
                });

            }
        };
    }
]);
