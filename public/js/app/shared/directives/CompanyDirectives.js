'use strict';
/**
 * Addresses Directives
 * - adicionarEnderecos
 * - btnAddEndereco
 * - endereco
 */

var CompanyDirectives = angular.module('CompanyDirectives', [
        // shared\plugins\factories
        'underscore',

        // shared\services
        'BaseServices'
    ]);

// TEMPORÁRIO
CompanyDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});

CompanyDirectives.directive('r2baseCompanyUnique', [

    function() {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/companies/r2base-company-unique.html',
            replace: true,
            scope: {
                companyModel: '=',
                form: '=',
                hasEntity: '=',
            },
            link: function(scope, element) {

            }
        };
    }
]);


CompanyDirectives.directive('r2baseCompanyBriefUnique', [
    'CompaniesFactory',
    function(CompaniesFactory) {
        return {

            restrict: 'A',
            templateUrl: 'partials/shared/directives/companies/r2base-company-brief-unique.html',
            replace: true,
            scope: {
                companyModel: '=',
                form: '=',
                hasEntity: '=',
            },
            link: function(scope, element) {

                scope.companyModel = {};
                scope.uniques = {
                    uniques: [{
                        'companyName': true,
                        'website': true,
                    }]
                };

                CompaniesFactory.show(scope.uniques, function (result) {
                    scope.uniques = result.data;
                    scope.loadUniques = true;
                });

                var populate = false;
                scope.$watch('[hasEntity, companyModel.id]', function(newVal) { 
                    if (newVal[0] && newVal[1] && !populate) {
                        scope.originalCompanyName = scope.companyModel.companyName;
                        scope.originalWebsite = scope.companyModel.website;
                        populate = true;
                    } else {
                        console.log('SHIIIIIIIIIIIIIIIIIIIIIIIIIIIT!');
                    }
                });

                scope.$watch('[loadUniques,hasEntity]', function(newVal) {
                    if (newVal[0]) {
                        scope.$watch('companyModel.companyName', function (companyName) {

                            var validateCompanyName = true;

                            if (scope.hasEntity && companyName) {
                                scope.form.company_name.$setValidity("unique", true);
                                validateCompanyName = companyName.toLowerCase() != scope.originalCompanyName.toLowerCase();
                            }

                            if (validateCompanyName) {
                                var hasCompanyName = scope.uniques['companyName'].some(function (elem) {
                                    if (elem != undefined && companyName != undefined) {
                                        if (elem.toLowerCase() == companyName.toLowerCase()) return true;
                                    }

                                    return false;
                                });

                                if (hasCompanyName) {
                                    scope.form.company_name.$setValidity("unique", false);
                                } else {
                                    scope.form.company_name.$setValidity("unique", true);
                                }
                            }
                        });

                        scope.$watch('companyModel.website', function (website) {

                            var validateWebsite = true;

                            if (scope.hasEntity && website != undefined) {
                                scope.form.website.$setValidity("unique", true);
                                if (scope.originalWebsite != undefined) {
                                    validateWebsite = website != scope.originalWebsite;
                                }
                            }

                            if (validateWebsite && website != undefined) {
                                var hasWebsite = scope.uniques['website'].some(function (elem) {
                                    if (elem == website) return true;
                                    return false;
                                });

                                if (hasWebsite) {
                                    scope.form.website.$setValidity("unique", false);
                                } else {
                                    scope.form.website.$setValidity("unique", true);
                                }
                            }
                        })
                    }
                });
            }
        };
    }
]);
