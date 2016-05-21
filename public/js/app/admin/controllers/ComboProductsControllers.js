'use strict';

R2Admin.controller('CombosHomeCtrl', [
    '$scope',
    function (
    	$scope
    	) {

        console.log('CombosHomeCtrl');
    	
    }
]);

R2Admin.controller('ComboSaveCtrl', [
    '$scope',
    '$stateParams',
    'CombosFactory',
    'StoresFactory',
    'Notification',
    '_',
    '$state',
    'combo',
    'ngDialog',
    'Upload',
    'blockUI',
    function (
        $scope,
        $stateParams,
        CombosFactory,
        StoresFactory,
        Notification,
        _,
        $state,
        combo,
        ngDialog,
        Upload,
        blockUI
        ) {
        blockUI.start();

        $scope.hasCombo = false;

        $scope.uniques = {
            uniques: [{
                'title': true,
            }]
        };

        $scope.combo = {
            comboStore: {
                sellDiscountPrice: true,
                storeStatus: true
            }
        };

        if ($stateParams.comboId != undefined) {
            if (combo.success) {
                CombosFactory.show({id: $stateParams.comboId}, function (result) {
                    $scope.pageTitle = 'Combo ID: ' + $stateParams.productId;
                    $scope.btnSave = 'Salvar Combo';
                    $scope.combo = result.data;

                    $scope.hasCombo = true;

                });
            } else {
                Notification.error({
                    message: 'Produto ID não encontrado!',
                    title: 'Aviso',
                    templateUrl: '/partials/shared/notifications/generic.html'
                });

                $state.go('admin.products');
            }
            blockUI.stop();
        } else {
            $scope.hasDepartment = false;
            $scope.pageTitle = 'Cadastro de Novo Produto';
            $scope.btnSave = 'Cadastrar Combo';
            blockUI.stop();

        }

        $scope.selectedComboProductsCollection = [];

        $scope.addComboProducts = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/modal-selectable-list.html',
                controller: 'ComboProductsSelectedCtrl',
                className: 'ngdialog-theme-default',
                appendClassName: 'r2-cart-select-product',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope
            }).then(function(values) {
                $scope.selectedComboProductsCollection = values;
                $scope.combo.products = [].concat($scope.selectedComboProductsCollection);
            }).catch(function(value) {
                console.log('CATCH', value);
            })
        };

        $scope.$watch('combo.products', function (newVal) {
            if (_.size(newVal) < 2) {
                $scope.combo.hasProducts = false;
                $scope.comboForm.combo_hasProducts.$setValidity("hasProducts", false);
                $scope.comboForm.combo_hasProducts.$setValidity("required", false);
                
            } else {
                $scope.combo.hasProducts = true;
                $scope.comboForm.combo_hasProducts.$setValidity("hasProducts", true);
                $scope.comboForm.combo_hasProducts.$setValidity("required", true);
                
            }
        });

        $scope.$watch('combo.thumbnail', function (newVal) {
            if (newVal !== undefined) {
                $scope.combo.hasThumbnail = true;
                $scope.comboForm.combo_hasThumbnail.$setValidity("hasThumbnail", true);
                $scope.comboForm.combo_hasThumbnail.$setValidity("required", true);
                
            } else {
                $scope.combo.hasThumbnail = false;
                $scope.comboForm.combo_hasThumbnail.$setValidity("hasThumbnail", false);
                $scope.comboForm.combo_hasThumbnail.$setValidity("required", false);
                
            }
        });

        $scope.removeComboStore = function (comboStoreId) {
            $scope.combo.products = _.reject($scope.combo.products, function(obj) {
                return obj.id === comboStoreId;
            });
        };

        $scope.saveCombo = function () {
            if ($stateParams.productId != undefined) {
                console.log('UPDATE COMBO');
            } else {
                Upload.upload({
                    url: '/api/erp/comboproducts',
                    method: 'post',
                    data: {data: $scope.combo, file: $scope.combo.thumbnail},
                }).then(function (resp) {
                    console.log('Success Criar COMBO', resp);
                    if (resp.data.success) {
                        Notification.success({
                            message: 'Produto salvo com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $state.go('admin.products.combostores');
                    }
                }, function (resp) {
                    console.log('Error status: ', resp);
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });
                /*CombosFactory.save($scope.combo, function(result) {


                    if (result.success) {
                        Notification.success({
                            message: 'Combo cadastrado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                    } else {
                        console.log('ERROR', result);
                    }

                    $scope.disableSaveBtn = false;

                }, function(result) {
                    console.log('ERRO');
                });*/
            }
        }
    }
]);

R2Admin.controller('ComboProductsSelectedCtrl', [
    '$scope',
    'ProductsFactory',
    'bsLoadingOverlayService',
    function ($scope, ProductsFactory, bsLoadingOverlayService) {

        bsLoadingOverlayService.start({
          referenceId: 'loadProducts'
        });
        $scope.selectedProducts = [];
        $scope.itemsByPage = 6;

        $scope.productsSelectedCollection = [];
        $scope.displayedProductsSelectedCollection = [];

        $scope.loadedProducts = false;

        ProductsFactory.show(function(result) {
            console.log('RESULT PRODUCTS');
            if (result.success) {
                $scope.productsSelectedCollection = result.data;
                $scope.displayedProductsSelectedCollection = [].concat($scope.productsSelectedCollection);
                $scope.loadedProducts = true;
            }

            bsLoadingOverlayService.stop({
              referenceId: 'loadProducts'
            });

        });

        $scope.$watch('loadedProducts', function(newVal) {
            if (newVal) {
                $scope.displayedProductsSelectedCollection.filter(function(r) {
                    if (_.find($scope.combo.products, {
                        id: r.id
                    })) {
                        r.isSelected = true;
                    } else {
                        r.isSelected = false;
                    }
                })
            }
        })

        $scope.$watch('displayedProductsSelectedCollection', function(row) {
          row.filter(function(r) {
             if (r.isSelected) {
                var obj = _.find($scope.selectedProducts, {
                    id: r.id
                });

                if (obj == undefined) {
                    $scope.selectedProducts.push(r);
                }
             } else {
                $scope.selectedProducts = _.reject($scope.selectedProducts, function(obj) {
                    return obj.id === r.id;
                });
             }
          });
        }, true);

        $scope.getSelectedProducts = function () {
            $scope.confirm($scope.selectedProducts);
        }
    }
])