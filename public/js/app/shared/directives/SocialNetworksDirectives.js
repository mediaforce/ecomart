'use strict';
/**
 * SocialNetworksDirectives
 * - addSocialNetworks
 * - btnAddSocialNetwork
 * - socialNetwork
 */

var SocialNetworksDirectives = angular.module('SocialNetworksDirectives', []);

// TEMPORÁRIO
SocialNetworksDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});
SocialNetworksDirectives.directive('r2baseAddSocialNetworks', [
    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/socialNetworks/r2base-add-social-networks.html',
            replace: true,
            scope: {
                socialNetworksModel: '=',
                form: '=',
                hasEntity: '=',
            }
        };
    }
]);

SocialNetworksDirectives.directive('r2baseBtnAddSocialNetwork', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                angular.element(document.getElementById('section-to-social-networks')).prepend($compile("<div data-r2base-social-network-collection></div>")(scope));
            });
        };
    }
]);

SocialNetworksDirectives.directive('r2basePopulateSocialNetworks', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.socialNetworksModel.length > 0) {
                        _.each(scope.socialNetworksModel, function(socialNetwork) {
                            angular.element(document.getElementById('section-to-social-networks')).prepend($compile("<div data-r2base-social-network-collection data-social-network-id='" + socialNetwork.id +"' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

SocialNetworksDirectives.directive('r2baseSocialNetworkCollection', [
    '_',
    function(_) {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/socialNetworks/r2base-social-network-collection.html',
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {

                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.index = scope.socialNetworksModel.indexOf(_.findWhere(scope.socialNetworksModel, {id: Number(attrs.socialNetworkId)} ) );
                } else {
                    scope.socialNetworksModel.push({
                        address: null
                    });

                    scope.index = scope.socialNetworksModel.length - 1;
                }

                scope.removeElement = function () {
                    setTimeout(function () {
                        scope.$apply(function () {
                            scope.form['social_network_address['+scope.index+']'].$setValidity('required', true);
                        });
                    }, 10);

                    scope.socialNetworksModel.splice(scope.index, 1);

                    $(element).detach();

                }

                scope.$watchCollection('socialNetworksModel', function (_newCol, _oldCol, _scope) {

                    var element = _oldCol[_scope.index];
                    var newIndex = _newCol.indexOf(element);

                    if (newIndex !== scope.index) scope.index = newIndex;
                });
            }
        };
    }
]);