'use strict';

R2Admin.controller('ManufacturersHomeCtrl', [
    '$scope',
    'ManufacturersFactory',
    'Notification',
    '_',
    'ngDialog',
    'manufacturers',
    'blockUI',
    function (
    	$scope,
        ManufacturersFactory,
        Notification,
        _,
        ngDialog,
        manufacturers,
        blockUI
    	) {

        blockUI.start();

        $scope.manufacturersCollection = [];
        $scope.displayedCollection = [];
        $scope.itemsByPage = 5;
        $scope.disableDeleteBtn = false;

        if (manufacturers.success != undefined) {
            if (manufacturers.success) {
                ManufacturersFactory.show(function (result) {
                    $scope.manufacturersCollection = result.data;
                    $scope.displayedCollection = [].concat($scope.manufacturersCollection);
                    blockUI.stop();
                });
            }
        } else {
            ManufacturersFactory.show(function (result) {
                $scope.manufacturersCollection = result.data;
                $scope.displayedCollection = [].concat($scope.manufacturersCollection);
                blockUI.stop();
            });
        }

        $scope.new = function() {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/manufacturers/save.html',
                controller: 'ManufacturerSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
            }).then(function(value) {
                $scope.manufacturersCollection.push(value);
            }).catch(function(value) {
                console.log('CATCH', value);
            });

        };

        $scope.edit = function(manufacturer) {
            $scope.editManufacturer = manufacturer;
            ngDialog.openConfirm({
                template: '/partials/admin/pages/manufacturers/save.html',
                controller: 'ManufacturerSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                var obj = _.find($scope.manufacturersCollection, {
                    id: value.id
                })
                var index = _.indexOf($scope.manufacturersCollection, obj);
                $scope.manufacturersCollection[index] = value;;
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        };

        $scope.delete = function (manufacturerId) {
            $scope.disableDeleteBtn = true;
            $scope.entity = {id: manufacturerId};

            ngDialog.openConfirm({
                template:
                '<p>Excluir o fabricante ID: ' + manufacturerId + '?</p>' +
                '<div class="ngdialog-buttons">' +
                    '<button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog(0)">Não</button>' +
                    '<button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm(1)">Sim</button>' +
                '</div>',
                plain: true,
                className: 'ngdialog-theme-default',
            }).then(function (value) {
                ManufacturersFactory.delete({id: manufacturerId}, function (result) {

                    if (result.success) {
                        $scope.manufacturersCollection = _.reject($scope.manufacturersCollection, function (row) {return row.id === manufacturerId} ); 
                        Notification.success({
                            message: 'Fabricante excluido com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    } else {
                        console.log('RESULT', result);
                    }

                    $scope.disableDeleteBtn = false;
                }, function (result) {console.log('ERRO');});
            }, function (value) {
                $scope.disableDeleteBtn = false;
            });

        }
    }
]);

R2Admin.controller('ManufacturerSaveCtrl', [
    '$scope',
    '$stateParams',
    'ManufacturersFactory',
    'Notification',
    '_',
    '$state',
    'CompaniesFactory',
    function (
        $scope,
        $stateParams,
        ManufacturersFactory,
        Notification,
        _,
        $state,
        CompaniesFactory
        ) {

        $scope.uniques = {
            uniques: [{
                'companyName': true,
                'website': true,
            }]
        };

        $scope.loadUniques = false;

        CompaniesFactory.show($scope.uniques, function(result) {
            $scope.uniques = result.data;
            $scope.loadUniques = true;
        });

        $scope.manufacturer = {
            company: {}
        };
        $scope.disableSaveBtn = false;
        $scope.hasManufacturer = false;

        if ($scope.editManufacturer != undefined) {

            $scope.pageTitle = 'Fabricante ID: ' + $scope.editManufacturer.id;
            $scope.btnSave = 'Salvar';
            $scope.manufacturer = $scope.editManufacturer;
            $scope.originalCompanyName = $scope.editManufacturer.company.companyName;
            $scope.originalWebsite = $scope.editManufacturer.company.website;
            $scope.hasManufacturer = true;

        } else {
            $scope.hasManufacturer = false;
            $scope.pageTitle = 'Cadastro de Novo Fabricante';
            $scope.btnSave = 'Cadastrar';

        }

        $scope.$watch('[loadUniques,hasManufacturer]', function(newVal) {
            if (newVal[0]) {
                $scope.$watch('manufacturer.company.companyName', function(companyName) {

                    var validateCompanyName = true;

                    if ($scope.hasManufacturer && companyName) {
                        $scope.manufacturerForm.company_name.$setValidity("unique", true);
                        validateCompanyName = companyName.toLowerCase() != $scope.originalCompanyName.toLowerCase();
                    }

                    if (validateCompanyName) {
                        var hasCompanyName = $scope.uniques['companyName'].some(function(elem) {
                            if (elem != undefined && companyName != undefined) {
                                if (elem.toLowerCase() == companyName.toLowerCase()) return true;
                            }

                            return false;
                        });

                        if (hasCompanyName) {
                            $scope.manufacturerForm.company_name.$setValidity("unique", false);
                        } else {
                            $scope.manufacturerForm.company_name.$setValidity("unique", true);
                        }
                    }
                });

                $scope.$watch('manufacturer.company.website', function (website) {

                            var validateWebsite = true;

                            if ($scope.hasManufacturer && website != undefined) {
                                $scope.manufacturerForm.website.$setValidity("unique", true);
                                if ($scope.originalWebsite != undefined) {
                                    validateWebsite = website != $scope.originalWebsite;
                                }
                            }

                            if (validateWebsite && website != undefined) {
                                var hasWebsite = $scope.uniques['website'].some(function (elem) {
                                    if (elem == website) return true;
                                    return false;
                                });

                                if (hasWebsite) {
                                    $scope.manufacturerForm.website.$setValidity("unique", false);
                                } else {
                                    $scope.manufacturerForm.website.$setValidity("unique", true);
                                }
                            }
                        })
            }
        });

        $scope.save = function() {
            $scope.disableSaveBtn = true;
            if ($scope.editManufacturer != undefined) {
                ManufacturersFactory.update($scope.manufacturer, function(result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Fabricante atualizado com sucesso!',
                            title: 'Fabricante Atualizado com Sucesso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data);
                    } else {
                        console.log('ERROR', result);
                    }

                    $scope.disableSaveBtn = false;
                }, function(result) {
                    console.log('ERRO');
                })
            } else {
                ManufacturersFactory.save($scope.manufacturer, function(result) {
                    console.log('RESULTADO DEPART SAVE', result);

                    if (result.success) {
                        Notification.success({
                            message: 'Fabricante cadastrado com sucesso!',
                            title: 'Fabricante Cadastrado com Sucesso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data);

                    } else {
                        console.log('ERROR', result);
                    }

                    $scope.disableSaveBtn = false;

                }, function(result) {
                    console.log('ERRO');
                });
            }
        }

    }
]);

