'use strict';
/**
 * EmailsDirectives
 * - addEmails
 * - btnAddEmail
 * - email
 */
var EmailsDirectives = angular.module('EmailsDirectives', []);

// TEMPORÁRIO
EmailsDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});


EmailsDirectives.directive('r2baseAddEmails', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/emails/r2base-add-emails.html',
            replace: true,
            scope: {
                emailsModel: '=',
                form: '=',
                hasEntity: '=',
            },
        };
    }
]);

EmailsDirectives.directive('r2baseBtnAddEmail', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                angular.element(document.getElementById('section-to-emails')).prepend($compile("<div data-r2base-email-collection></div>")(scope));
            });
        };
    }
]);

EmailsDirectives.directive('r2basePopulateEmails', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.emailsModel.length > 0) {
                        _.each(scope.emailsModel, function(email) {
                            angular.element(document.getElementById('section-to-emails')).prepend($compile("<div data-r2base-email-collection data-email-id='" + email.id +"' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

EmailsDirectives.directive('r2baseEmailCollection', [

    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/emails/r2base-email-collection.html',
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {
                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.index = scope.emailsModel.indexOf(_.findWhere(scope.emailsModel, {id: Number(attrs.emailId)} ) );
                } else {
                    scope.emailsModel.push({
                        address: null
                    });

                    scope.index = scope.emailsModel.length - 1;
                }


                

                scope.removeElement = function () {
                    setTimeout(function () {
                        scope.$apply(function () {
                            scope.form['email_address['+scope.index+']'].$setValidity('required', true);
                        });
                    }, 10);

                    scope.emailsModel.splice(scope.index, 1);

                    $(element).detach();

                }

                scope.$watchCollection('emailsModel', function (_newCol, _oldCol, _scope) {

                    var element = _oldCol[_scope.index];
                    var newIndex = _newCol.indexOf(element);

                    if (newIndex !== scope.index) scope.index = newIndex;
                });
            }
        };
    }
]);