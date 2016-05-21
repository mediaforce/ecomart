'use strict';
/**
 * Cartoes Credito Directives
 * - adicionarCartoesCredito
 * - btnAddCartaoCredito
 * - cartaoCredito
 */

var CreditCardsDirectives = angular.module('CreditCardsDirectives', []);

// TEMPORÁRIO
CreditCardsDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});


CreditCardsDirectives.directive('r2baseAddCreditCards', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials//çdirectives/creditCards/r2base-add-creditCards.html',
            replace: true,
            scope: true,
            link: function (scope, element) {
                scope.$watch('user.person.creditCards.length', function (newVal, oldVal) {
                    scope.qtdeItems = newVal;
                });
            }
        };
    }
]);

CreditCardsDirectives.directive('r2baseBtnAddCreditCard', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                angular.element(document.getElementById('section-to-credit-cards')).prepend($compile("<div data-r2base-credit-card-collection></div>")(scope));
            });
        };
    }
]);

CreditCardsDirectives.directive('r2baseCreditCardCollection', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/creditCards/r2base-credit-card.html',
            replace: true,
            scope: true,
            link: function(scope, element) {

                scope.user.person.creditCards.push({
                    brand: null,
                    holder: null,
                    number: null,
                    validade: null,
                });

            }
        };
    }
]);