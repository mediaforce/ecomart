'use strict';
/**
 * Documentos Directives
 * - adicionarDocumentos
 * - btnAddDocumento
 * - documentoCpf
 * - documentoRg
 * - documentoPassaporte
 */
var DocumentsDirectives = angular.module('DocumentsDirectives', ['BaseServices']);

// TEMPORÁRIO
DocumentsDirectives.run(function($templateCache) {
    $templateCache.removeAll();
});

DocumentsDirectives.directive('r2baseAddDocuments', [
    'BaseEnumsFactory',
    function(BaseEnumsFactory) {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/documents/r2base-add-documents.html',
            replace: true,
            scope: {
                documentsModel: '=',
                form: '=',
                hasEntity: '='
            },
            link: function(scope, element, attrs) {
                var documentInterface = attrs.documentInterface;
                scope.options = {
                    documentTypes: []
                };
                scope.documentTypesLoad = false;
                BaseEnumsFactory.show(function(result) {
                    console.log('BaseEnumsFactory', result);
                    if (documentInterface == 'physical') {
                        _.each(
                            result.data.physicalDocumentType,
                            function(documentType) {
                                scope.options.documentTypes.push({
                                    name: documentType
                                });
                            }
                        );
                    } else if (documentInterface == 'legal') {
                        _.each(
                            result.data.legalDocumentType,
                            function(documentType) {
                                scope.options.documentTypes.push({
                                    name: documentType
                                });
                            }
                        );
                    } else {
                        _.each(
                            result.data.physicalDocumentType,
                            function(documentType) {
                                scope.options.documentTypes.push({
                                    name: documentType
                                });
                            }
                        );
                        _.each(
                            result.data.legalDocumentType,
                            function(documentType) {
                                scope.options.documentTypes.push({
                                    name: documentType
                                });
                            }
                        );
                    }

                    scope.documentTypesLoad = true;

                });
            }
        };
    }
]);

DocumentsDirectives.directive('r2baseBtnAddDocument', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {

            element.bind("click", function() {
                if (typeof(scope.selectedDocumentType) != "undefined") {
                    angular.element(document.getElementById('section-to-documents')).prepend($compile("<div data-r2base-document-collection data-document-type='" + scope.selectedDocumentType.toUpperCase() + "'></div>")(scope));
                }
            });
        };
    }
]);

DocumentsDirectives.directive('r2basePopulateDocuments', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.documentsModel.length > 0) {
                        _.each(scope.documentsModel, function(doc) {
                            angular.element(document.getElementById('section-to-documents')).prepend($compile("<div data-r2base-document-collection data-document-id='" + doc.id + "' data-document-type='" + doc.document_type + "' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

DocumentsDirectives.directive('r2baseDocumentCollection', [
    function () {
        return {
            restrict: 'A',
            templateUrl: function(elem, attr) {
                return 'partials/shared/directives/documents/r2base-document-' + attr.documentType.toLowerCase() + '-collection.html';
            },
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {
                scope.loadAll = false;

                scope.formNames = {
                    'RG': ['doc_rg_nome', 'doc_rg_numero', 'doc_rg_orgao'],
                    'CPF': ['doc_cpf_nome', 'doc_cpf_numero'],
                    'PASSPORT': ['doc_passport_name', 'doc_passport_number']
                };

                scope.loadAll = true;

                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.$watch('loadAll', function (newVal) {
                        if(newVal) {

                            scope.index = scope.documentsModel.indexOf(_.findWhere(scope.documentsModel, {id: Number(attrs.documentId)} ) );

                            scope.documentsModel[scope.index].fields = [];
                            scope.documentsModel[scope.index].sameName = false;
                            switch(attrs.documentType) {
                                case 'RG':
                                    scope.documentsModel[scope.index].fields[0] = scope.documentsModel[scope.index].field1;
                                    scope.documentsModel[scope.index].fields[1] = scope.documentsModel[scope.index].field2;
                                    scope.documentsModel[scope.index].fields[2] = scope.documentsModel[scope.index].field3;
                                    break;
                                case 'CPF':
                                    scope.documentsModel[scope.index].fields[0] = scope.documentsModel[scope.index].field1;
                                    scope.documentsModel[scope.index].fields[1] = scope.documentsModel[scope.index].field2;
                                    break;
                            }
                        }

                    });
                } else {
                    scope.documentsModel.push({
                        documentType: attrs.documentType,
                        sameName: false,
                        fields: []
                    });

                    scope.index = scope.documentsModel.length - 1;
                }

                scope.removeElement = function() {
                    setTimeout(function() {
                        scope.$apply(function() {
                            for(i = 0; scope.formNames[attrs.documentType]; i++) {
                                scope.form[ scope.formNames[attrs.documentType][i] + '[' + scope.index + ']'].$setValidity('required', true);
                            }
                        });
                    }, 10);

                    scope.documentsModel.splice(scope.index, 1);

                    $(element).detach();
                }

                scope.$watch('documentsModel[' + scope.index + '].sameName', function(newVal, oldVal) {
                    var name_field = scope.formNames[attrs.documentType][0];
                    if (newVal) {
                        if (scope.form[name_field + '[' + scope.index + ']'] != undefined) {
                            scope.form[name_field + '[' + scope.index + ']'].$setValidity('required', true);
                            scope.documentsModel[scope.index].fields[0] = 'NOME IGUAL AO DO CADASTRO!';
                        }
                    } else {
                        if (scope.form[name_field + '[' + scope.index + ']'] != undefined) {
                            scope.form[name_field + '[' + scope.index + ']'].$setValidity('required', false);
                            scope.documentsModel[scope.index].fields[0] = '';
                        }
                    }
                });

                scope.$watchCollection('documentsModel', function(_newCol, _oldCol, _scope) {

                    var element = _oldCol[_scope.index];
                    var newIndex = _newCol.indexOf(element);

                    if (newIndex !== scope.index) scope.index = newIndex;
                });
            }
        }
    }
]);
