'use strict';

R2Admin.controller('FeaturesHomeCtrl', [
    '$scope',
    'FeaturesFactory',
    'FeatureGroupsFactory',
    'Notification',
    '_',
    'ngDialog',
    'features',
    'groups',
    'blockUI',
    function (
    	$scope,
        FeaturesFactory,
        FeatureGroupsFactory,
        Notification,
        _,
        ngDialog,
        features,
        groups,
        blockUI
    	) {

        blockUI.start();

        $scope.featuresCollection = [];
        $scope.displayedFeatureCollection = [];

        $scope.featureGroupsCollection = [];
        $scope.displayedGroupsCollection = [];

        $scope.itemsByPage = 5;

        $scope.disableDeleteBtnGroup = false;
        $scope.disableDeleteBtnFeature = false;


        if (features.success != undefined && groups.success != undefined) {
            if (features.success) {
                FeaturesFactory.show(function(result) {
                    $scope.featuresCollection = result.data;
                    $scope.displayedFeatureCollection = [].concat($scope.featuresCollection);
                    blockUI.stop();
                });
            } else {
                blockUI.stop();
            }

            if (groups.success) {
                FeatureGroupsFactory.show(function(result) {
                    $scope.featureGroupsCollection = result.data;
                    $scope.displayedGroupsCollection = [].concat($scope.featureGroupsCollection);
                    blockUI.stop();
                });
            } else {
                blockUI.stop();
            }
        } else {
            Notification.error({
                    message: 'Desculpe! Houve um erro no carregamento. Caso ocorra novamente, aperte em "F5" no seu teclado para atualizar a página.',
                    title: 'Erro!',
                    templateUrl: '/partials/admin/notifications/generic.html'
                });
            $state.go('admin.products.features');
        }

        $scope.newGroup = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/features/group-save.html',
                controller: 'FeatureGroupSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
            }).then(function(value) {
                FeatureGroupsFactory.show({
                    id: value
                }, function(result) {
                    if (result.success) {
                        $scope.featureGroupsCollection.push(result.data);
                    }
                });
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.newFeature = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/features/save.html',
                controller: 'FeatureSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
            }).then(function(value) {
                FeaturesFactory.show({
                    id: value
                }, function(result) {
                    if (result.success) {
                        $scope.featuresCollection.push(result.data);
                    }
                });
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.deleteGroup = function(editGroupId) {
            $scope.disableDeleteBtn = true;

            ngDialog.openConfirm({
                template: '<p>Excluir o grupo de características ID: ' + editGroupId + '?</p>' +
                    '<div class="ngdialog-buttons">' +
                    '<button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog(0)">Não</button>' +
                    '<button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm(1)">Sim</button>' +
                    '</div>',
                plain: true,
                className: 'ngdialog-theme-default',
            }).then(function(value) {
                FeatureGroupsFactory.delete({
                    id: editGroupId
                }, function(result) {

                    if (result.success) {
                        $scope.featureGroupsCollection = _.reject($scope.featureGroupsCollection, function(row) {
                            return row.id === editGroupId
                        });
                        Notification.success({
                            message: 'Grupo de características excluido com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    } else {
                        console.log('RESULT', result);
                    }

                    $scope.disableDeleteBtn = false;
                }, function(result) {
                    console.log('ERRO');
                });
            }, function(value) {
                $scope.disableDeleteBtn = false;
            });
        }

        $scope.deleteFeature = function(editFeatureId) {
            $scope.disableDeleteBtn = true;

            ngDialog.openConfirm({
                template: '<p>Excluir o características ID: ' + editFeatureId + '?</p>' +
                    '<div class="ngdialog-buttons">' +
                    '<button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog(0)">Não</button>' +
                    '<button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm(1)">Sim</button>' +
                    '</div>',
                plain: true,
                className: 'ngdialog-theme-default',
            }).then(function(value) {
                FeaturesFactory.delete({
                    id: editFeatureId
                }, function(result) {

                    if (result.success) {
                        $scope.featuresCollection = _.reject($scope.featuresCollection, function(row) {
                            return row.id === editFeatureId
                        });
                        Notification.success({
                            message: 'Característica excluida com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    } else {
                        console.log('RESULT', result);
                    }

                    $scope.disableDeleteBtn = false;
                }, function(result) {
                    console.log('ERRO');
                });
            }, function(value) {
                $scope.disableDeleteBtn = false;
            });
        }

        $scope.editGroup = function (editGroupId) {
            $scope.editGroupId = editGroupId;
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/features/group-save.html',
                controller: 'FeatureGroupSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                FeaturesFactory.show({
                    id: value
                }, function(result) {
                    if (result.success) {
                        var obj = _.find($scope.featuresCollection, {
                            id: value
                        });
                        var index = _.indexOf($scope.featuresCollection, obj);
                        $scope.featuresCollection[index] = result.data;
                    }
                });
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.editFeature = function (editFeatureId) {
            $scope.editFeatureId = editFeatureId;
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/features/save.html',
                controller: 'FeatureSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                FeaturesFactory.show({
                    id: value
                }, function(result) {
                    if (result.success) {
                        var obj = _.find($scope.featureGroupsCollection, {
                            id: value
                        })
                        var index = _.indexOf($scope.featureGroupsCollection, obj);
                        $scope.featureGroupsCollection[index] = result.data;
                    }
                });
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }
    }
]);

R2Admin.controller('FeatureSaveCtrl', [
    '$scope',
    '$stateParams',
    'FeaturesFactory',
    'FeatureGroupsFactory',
    'Notification',
    '_',
    '$state',
    function (
        $scope,
        $stateParams,
        FeaturesFactory,
        FeatureGroupsFactory,
        Notification,
        _,
        $state
        ) {

        $scope.feature = {};
        $scope.disableSaveBtn = false;
        $scope.hasFeature = false;

        $scope.options = {
            groups: []
        };

        FeatureGroupsFactory.show(function(result) {
            $scope.options.groups = result.data;
        });

        if ($scope.editFeatureId != undefined) {
            FeaturesFactory.show({
                id: $scope.editFeatureId
            }, function(result) {
                $scope.pageTitle = 'Característica ID: ' + $scope.editFeatureId;
                $scope.btnSave = 'Salvar';
                $scope.feature = result.data;
                $scope.feature.group = result.data.group.id;
                $scope.hasFeature = true;

            });
        } else {
            $scope.hasFeature = false;
            $scope.pageTitle = 'Cadastro de Nova Característica';
            $scope.btnSave = 'Cadastrar';

        }

        $scope.save = function() {
            $scope.disableSaveBtn = true;
            if ($scope.editFeatureId != undefined) {
                FeaturesFactory.update($scope.feature, function(result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Característica atualizada com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data.entityId);
                    } else {
                        console.log('ERROR', result);
                    }

                    $scope.disableSaveBtn = false;
                }, function(result) {
                    console.log('ERRO');
                })
            } else {
                FeaturesFactory.save($scope.feature, function(result) {

                    if (result.success) {
                        Notification.success({
                            message: 'Característica cadastrada com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data.entityId);

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

R2Admin.controller('FeatureGroupSaveCtrl', [
    '$scope',
    '$stateParams',
    'FeatureGroupsFactory',
    'Notification',
    '_',
    '$state',
    function (
        $scope,
        $stateParams,
        FeatureGroupsFactory,
        Notification,
        _,
        $state
        ) {

        $scope.uniques = {
            uniques: [{
                'name': true,
            }]
        };
        $scope.loadUniques = false;

        FeatureGroupsFactory.show($scope.uniques, function(result) {
            $scope.uniques = result.data;
            $scope.loadUniques = true;
        });

        $scope.group = {};
        $scope.disableSaveBtn = false;
        $scope.hasGroup = false;

        if ($scope.editGroupId != undefined) {
            FeatureGroupsFactory.show({
                id: $scope.editGroupId
            }, function(result) {
                $scope.pageTitle = 'Grupo de Características ID: ' + $scope.editId;
                $scope.btnSave = 'Salvar';
                $scope.group = result.data;
                $scope.originalName = result.data.name;
                $scope.hasGroup = true;

            });
        } else {
            $scope.hasGroup = false;
            $scope.pageTitle = 'Cadastro de Novo Grupo de Características';
            $scope.btnSave = 'Cadastrar';
        }

        $scope.$watch('[loadUniques,hasGroup]', function(newVal) {
            if (newVal[0]) {
                $scope.$watch('group.name', function(newName) {

                    var validateName = true;

                    if ($scope.hasGroup && newName) {
                        $scope.featureGroupForm.feature_group_name.$setValidity("unique", true);
                        validateName = newName.toLowerCase() != $scope.originalName.toLowerCase();
                    }

                    if (validateName) {
                        var hasName = $scope.uniques['name'].some(function(elem) {
                            if (elem != undefined && newName != undefined) {
                                if (elem.toLowerCase() == newName.toLowerCase()) return true;
                            }

                            return false;
                        });

                        if (hasName) {
                            $scope.featureGroupForm.feature_group_name.$setValidity("unique", false);
                        } else {
                            $scope.featureGroupForm.feature_group_name.$setValidity("unique", true);
                        }
                    }
                });
            }
        });


        $scope.save = function() {
            $scope.disableSaveBtn = true;
            if ($scope.editGroupId != undefined) {
                FeatureGroupsFactory.update($scope.group, function(result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Grupo de Características atualizado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data.entityId);
                    } else {
                        console.log('ERROR', result);
                    }

                    $scope.disableSaveBtn = false;
                }, function(result) {
                    console.log('ERRO');
                })
            } else {
                FeatureGroupsFactory.save($scope.group, function(result) {

                    if (result.success) {
                        Notification.success({
                            message: 'Grupo de Características cadastrado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.confirm(result.data.entityId);

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

