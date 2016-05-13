'use strict';

R2Site.controller('StoreDetailCtrl', [
    '$scope',
    'store',
    '$stateParams',
    '$sce',
    'Slug',
    function (
        $scope,
        store,
        $stateParams,
        $sce,
        Slug
        ) {

        $scope.renderHtml = function (htmlCode) {
            return $sce.trustAsHtml(htmlCode);
        };

        $scope.store = {};

        $scope.videoTeste = '';

        if (store.success) {
            console.log('store', store);

            $scope.store = store.data;

            $scope.store.slug = Slug.slugify($scope.store.product.title);

            var cover = _.find($scope.store.product.images, function(image) {
                if (image.isCover) return true;
            });

            $scope.store.cover = cover;
            $scope.selectedImage = cover.path;

            if ($scope.store.product.videos[0] != undefined) {
                $scope.videoUrl = $scope.store.product.videos[0].address;
                $scope.videoTitle = 'Veja o vídeo deste produto';
                $scope.showVideo = true;
            } else {
                $scope.videoUrl = '';
                $scope.videoTitle = 'Em breve um novo video deste produto';
                $scope.showVideo = false;
            }
        }

        $scope.setSelectedImage = function(image) {
            $scope.selectedImage = image;
        }
    }
]);

R2Site.controller('DepartmentsCtrl', [
    '$scope',
    '$stateParams',
    'StoresFactory',
    '_',
    'Slug',
    function (
        $scope,
        $stateParams,
        StoresFactory,
        _,
        Slug
        ) {

        $scope.departmentName = $stateParams.departmentName.toUpperCase();

        StoresFactory.show({departmentName: $scope.departmentName, toSell:true}, function (result) {
            console.log(result);

            if (result.success) {
                $scope.storesCollection = result.data;

                _.each($scope.storesCollection, function (store) {
                    store.slug = Slug.slugify(store.product.title);
                    var cover = _.find(store.product.images, function(image) {
                        if (image.isCover) return true;
                    });
                    store.cover = cover;
                })
            }

            console.log($scope.storesCollection);

        })
    }
]);

R2Site.controller('LaunchsCtrl', [
    '$scope',
    'StoresFactory',
    '_',
    'Slug',
    function (
        $scope,
        StoresFactory,
        _,
        Slug
        ) {

        StoresFactory.show({launchs: true, toSell:true}, function (result) {
            console.log(result);

            if (result.success) {
                $scope.storesCollection = result.data;

                _.each($scope.storesCollection, function (store) {
                    store.slug = Slug.slugify(store.product.title);
                    var cover = _.find(store.product.images, function(image) {
                        if (image.isCover) return true;
                    });
                    store.cover = cover;
                })
            }

            console.log($scope.storesCollection);

        })
    }
]);

R2Site.controller('CombosCtrl', [
    '$scope',
    'ComboStoresFactory',
    '_',
    'Slug',
    function (
        $scope,
        ComboStoresFactory,
        _,
        Slug
        ) {

        $scope.loadCombo = false;

        ComboStoresFactory.show({toSell:true}, function (result) {

            if (result.success) {
                $scope.comboStoresCollection = result.data;
                
                _.each($scope.comboStoresCollection, function (store) {
                    store.slug = Slug.slugify(store.comboProduct.title);
                })

                console.log('C.OMBOS...', $scope.comboStoresCollection);

                $scope.loadCombo = true;
            }


        })
    }
]);

R2Site.controller('ComboStoreDetailCtrl', [
    '$scope',
    'comboStore',
    '$stateParams',
    '$sce',
    'Slug',
    function (
        $scope,
        comboStore,
        $stateParams,
        $sce,
        Slug
        ) {

        $scope.renderHtml = function (htmlCode) {
            return $sce.trustAsHtml(htmlCode);
        };

        $scope.comboStore = {};

        $scope.videoTeste = '';

        $scope.selectProduct = function(product) {
            $scope.selectedProduct = product;

            $scope.selectedImage = product.images[0].path;

            if (product.videos[0] != undefined) {
                $scope.videoUrl = product.videos[0].address;
                $scope.videoTitle = 'Veja o vídeo deste produto';
                $scope.showVideo = true;
            } else {
                $scope.videoUrl = '';
                $scope.videoTitle = 'Em breve um novo video deste produto';
                $scope.showVideo = false;
            }
        }

        if (comboStore.success) {
            console.log('COMBO STORE', comboStore)            ;

            $scope.comboStore = comboStore.data;

            $scope.products = $scope.comboStore.comboProduct.products;

            var firstProduct = $scope.comboStore.comboProduct.products[0];

            $scope.selectProduct(firstProduct);

            /*var cover = _.find($scope.store.product.images, function(image) {
                if (image.isCover) return true;
            });
            $scope.store.cover = cover;
            $scope.selectedImage = $scope.store.product.images[0].path;

            if ($scope.store.product.videos[0] != undefined) {
                $scope.videoUrl = $scope.store.product.videos[0].address;
                $scope.videoTitle = 'Veja o vídeo deste produto';
                $scope.showVideo = true;
            } else {
                $scope.videoUrl = '';
                $scope.videoTitle = 'Em breve um novo video deste produto';
                $scope.showVideo = false;
            }*/
        }

        $scope.setSelectedImage = function(image) {
            $scope.selectedImage = image;
        }
    }
]);


R2Site.controller('SearchProductsCtlr', [
    '$scope',
    'StoresFactory',
    'ComboStoresFactory',
    '_',
    'Slug',
    '$stateParams',
    function ($scope, StoresFactory, ComboStoresFactory, _, Slug, $stateParams) {
        
        $scope.hasInStore = false;

        StoresFactory.show({title: $stateParams.search}, function (result) {
            if (result.success) {
                $scope.storesCollection = result.data;

                

                if ($scope.storesCollection.length > 0) {
                    $scope.hasInStore = true;
                   _.each($scope.storesCollection, function (store) {
                        store.slug = Slug.slugify(store.product.title);
                        var cover = _.find(store.product.images, function(image) {
                            if (image.isCover) return true;
                        });
                        store.cover = cover;
                    }); 
                }
            }
        })
    }
]);