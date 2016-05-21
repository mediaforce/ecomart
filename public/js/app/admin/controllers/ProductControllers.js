'use strict';

R2Admin.controller('ProductsHomeCtrl', [
    '$scope',
    'ProductsFactory',
    'Notification',
    '_',
    'ngDialog',
    'products',
    'blockUI',
    function (
        $scope,
        ProductsFactory,
        Notification,
        _,
        ngDialog,
        products,
        blockUI
        ) {
        console.log('Products Home Ctrls');

        blockUI.start();
        $scope.productsCollection = [];
        $scope.displayedCollection = [];

        $scope.itemsByPage = 5;

        $scope.disableDeleteBtn = false;

        ProductsFactory.show(function(result) {
            console.log('PR', result);

            $scope.productsCollection = result.data;
            
            _.each($scope.productsCollection, function (product) {
                var cover = _.find(product.images, function(image) {
                    if (image.isCover) return true;
                });
                product.cover = cover;
            });
            $scope.displayedCollection = [].concat($scope.productsCollection);
            blockUI.stop();
        });



        $scope.delete = function ($id) {
            ProductsFactory.delete({id: $id}, function (result) {
                console.log(result);
                if (result.success) {
                    console.log('PRODUTO EXCLUIDO COM SUCESSO. Filter');
                    Notification.success({
                        message: 'Produto excluído com sucesso!',
                        title: 'Aviso',
                        templateUrl: '/partials/shared/notifications/generic.html'
                    });
                } else {
                    console.log('PRODUTO POSSUI DEPENDENCIAS. (Vendas). Não pode ser excluído');
                    Notification.error({
                        message: 'Não é possível excluir este produto. Possui vendas!',
                        title: 'Aviso',
                        templateUrl: '/partials/shared/notifications/generic.html'
                    });
                }
            }) 
        }

    }
]);

R2Admin.controller('ProductSaveCtrl', [
    '$scope',
    '$stateParams',
    'ProductsFactory',
    'ManufacturersFactory',
    'DepartmentsFactory',
    'FeaturesFactory',
    'Notification',
    '_',
    '$state',
    'product',
    'ngDialog',
    'Upload',
    'blockUI',
    function (
        $scope,
        $stateParams,
        ProductsFactory,
        ManufacturersFactory,
        DepartmentsFactory,
        FeaturesFactory,
        Notification,
        _,
        $state,
        product,
        ngDialog,
        Upload,
        blockUI
        ) {
        blockUI.start();

        $scope.product = {
            isHighlighted: false,
            isLaunch: false,
            store: {
                sellDiscountPrice: true,
                toSell: true
            }
        };

        $scope.uniques = {
            uniques: [{
                'title': true,
            }]
        };

        $scope.hasUpload = false;

        $scope.loadUniques = false;

        $scope.disableSaveBtn = false;
        $scope.hasProduct = false;

        $scope.options = {
            manufacturers: [],
            departments: [],
            categories: [],
            subcategories: [],
        };

        ManufacturersFactory.show(function (result) {
            $scope.options.manufacturers = result.data;
            $scope.loadManufacturers = true;
        });

        if ($stateParams.productId != undefined) {


            ProductsFactory.show({id: $stateParams.productId}, function (result) {
                    result.data.store.unitDiscountPrice = Number(result.data.store.unitDiscountPrice);
                    result.data.store.unitPrice = Number(result.data.store.unitPrice);

                    $scope.btnSaveTitle = 'SALVAR PRODUTO';
                    $scope.pageTitle = 'Produto ID: ' + $stateParams.productId;
                    $scope.product = result.data;

                    console.log('PRODUTO', $scope.product);

                    $scope.hasProduct = true;

                    blockUI.stop();

            });

        } else {
            $scope.btnSaveTitle = 'CADASTRAR PRODUTO';
            $scope.pageTitle = 'Cadastro de Novo Produto';
            blockUI.stop();
        }

        $scope.$watch('[hasProduct, loadManufacturers, loadDepartmentss]', function (newVal) {
            if (newVal[0] && newVal[1] && newVal[2]) {
                $scope.product.manufacturer = $scope.product.manufacturer.id.toString();
                $scope.product.department = $scope.product.department.id.toString();
            }
        });

        DepartmentsFactory.show(function (result) {
            $scope.options.departments = result.data;
            $scope.loadDepartmentss = true;
        });

        $scope.selectedFeaturesCollection = [];
        $scope.selectedAlternativeProductsCollection = [];
        $scope.selectedMixProductsCollection = [];

        $scope.product.features = [];
        $scope.product.alternativeProducts = [];
        $scope.product.mixProducts = [];
        $scope.product.videos = [];
        $scope.product.images = [];

        $scope.pageTitle = 'Cadastro de Produto';


        $scope.selectedCover = function (index) {
            $scope.product.coverIndex = index;
        };

        $scope.$watch('product.coverIndex', function (newVal) {
            if (newVal !== undefined) {
                $scope.product.hasCover = true;
                $scope.productForm.product_cover.$setValidity("hasCover", true);
                $scope.productForm.product_cover.$setValidity("required", true);
                
            } else {
                $scope.product.hasCover = false;
                $scope.productForm.product_cover.$setValidity("hasCover", false);
                $scope.productForm.product_cover.$setValidity("required", false);
                
            }
        });

        $scope.pageTitle = 'Cadastro de Produto';

        $scope.addFeature = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/features/modal-selectable-list.html',
                controller: 'FeaturesSelectedCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope
            }).then(function(values) {

                $scope.selectedFeaturesCollection = values;
                $scope.product.features = [].concat($scope.selectedFeaturesCollection);
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.removeFeature = function(featureId) {
            $scope.product.features = _.reject($scope.product.features, function(obj) {
                return obj.id === featureId;
            });
        }

        $scope.addAlternativeProduct = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/modal-selectable-list.html',
                controller: 'AlternativeProductSelectedCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope
            }).then(function(values) {
                $scope.selectedAlternativeProductsCollection = values;
                $scope.product.alternativeProducts = [].concat($scope.selectedAlternativeProductsCollection);
            }).catch(function(value) {
                console.log('CATCH', value);
            })
        }

        $scope.removeAlternativeProduct = function (alternativeProductId) {
            $scope.product.alternativeProducts = _.reject($scope.product.alternativeProducts, function(obj) {
                return obj.id === alternativeProductId;
            });
        }

        $scope.verifyProduct = function () {
            console.log($scope.product);
        }

        $scope.$watch('product.images', function(newVal) {
            console.log(newVal);
            if (newVal[0] !== undefined) {
                if (newVal[0].size !== undefined) {
                    $scope.hasUpload = true; 
                    console.log('FORM HAS UPLOAD');
                }                
            }
        })

        $scope.saveProduct = function () {
            if ($stateParams.productId != undefined) {

                Upload.upload({
                    url: '/api/erp/products',
                    method: 'post',
                    data: {id: $stateParams.productId, is_put: true, data: $scope.product, files: $scope.product.images, file: $scope.product.guideToUpload},
                }).then(function (resp) {
                    if (resp.data.success) {
                        Notification.success({
                            message: 'Produto atualizado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $state.go('admin.products');
                    } else {
                        console.log('RESPONSE', resp);
                    }
                }, function (resp) {
                    console.log('Error status: ', resp);
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });

                /*Upload.upload({
                    url: '/api/erp/products',
                    method: 'post',
                    data: {id: $stateParams.productId, is_put: true, data: $scope.product, files: $scope.product.images},
                }).then(function (resp) {
                    console.log('Success ', resp);
                    if (resp.data.success) {
                        Notification.success({
                            message: 'Produto atualizado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    }
                }, function (resp) {
                    console.log('Error status: ', resp);
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });*/
            } else {
                Upload.upload({
                    url: '/api/erp/products',
                    method: 'post',
                    data: {id: $stateParams.productId, data: $scope.product, files: $scope.product.images},
                }).then(function (resp) {
                    console.log('Success Criar PRODUTO', resp);
                    if (resp.data.success) {
                        Notification.success({
                            message: 'Produto salvo com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $state.go('admin.products');
                    }
                }, function (resp) {
                    console.log('Error status: ', resp);
                }, function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                });
            }
        }

        $scope.$watch('product.department', function (newVal) {
            var obj = _.find($scope.options.departments, function(cat) {
                return cat.id == newVal;
            });

            if (obj != undefined) {

                $scope.options.categories = obj.categories;

                if ($scope.hasProduct) {
                    if ($scope.product.category !== undefined) {
                        $scope.product.category = $scope.product.category.id.toString();
                    }
                }
            }
        })

    }
]);

R2Admin.controller('FeaturesSelectedCtrl', [
    '$scope',
    'FeaturesFactory',
    'blockUI',
    'bsLoadingOverlayService',
    function ($scope, FeaturesFactory, blockUI, bsLoadingOverlayService) {
        bsLoadingOverlayService.start({
          referenceId: 'loadFeatures'
        });

        $scope.selectedFeatures = [];
        $scope.itemsByPage = 6;

        $scope.featuresCollection = [];
        $scope.displayedCollection = [];

        $scope.loadedFeatures = false;

        FeaturesFactory.show(function(result) {
            console.log('RESULTADO CARACT', result);
            if (result.success) {
                $scope.featuresCollection = result.data;
                $scope.displayedCollection = [].concat($scope.featuresCollection);
                $scope.loadedFeatures = true;

            }
            bsLoadingOverlayService.stop({
              referenceId: 'loadFeatures'
            });

        });

        $scope.$watch('loadedFeatures', function(newVal) {
            if (newVal) {
                $scope.displayedCollection.filter(function(r) {
                    if (_.find($scope.product.features, {
                        id: r.id
                    })) {
                        r.isSelected = true;
                    } else {
                        r.isSelected = false;
                    }
                })
            }
        })

        $scope.$watch('displayedCollection', function(row) {
          row.filter(function(r) {
             if (r.isSelected) {
                var obj = _.find($scope.selectedFeatures, {
                    id: r.id
                });

                if (obj == undefined) {
                    $scope.selectedFeatures.push(r);
                }
             } else {
                $scope.selectedFeatures = _.reject($scope.selectedFeatures, function(obj) {
                    return obj.id === r.id;
                });
             }
          });
        }, true);

        $scope.getSelectedFeatures = function () {
            $scope.confirm($scope.selectedFeatures);
        }
    }
])

R2Admin.controller('AlternativeProductSelectedCtrl', [
    '$scope',
    'ProductsFactory',
    'blockUI',
    function ($scope, ProductsFactory, blockUI) {
        blockUI.start();
        $scope.selectedProducts = [];
        $scope.itemsByPage = 10;

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
            blockUI.stop();

        });

        $scope.$watch('loadedProducts', function(newVal) {
            if (newVal) {
                $scope.displayedProductsSelectedCollection.filter(function(r) {
                    if (_.find($scope.product.alternativeProducts, {
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