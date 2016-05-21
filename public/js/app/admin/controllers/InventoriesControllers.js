'use strict';

R2Admin.controller('InventoriesHomeCtrl', [
    '$scope',
    'StoresFactory',
    'SalesFactory',
    'Notification',
    '_',
    'ngDialog',
    'blockUI',
    function (
    	$scope,
        StoresFactory,
        SalesFactory,
        Notification,
        _,
        ngDialog,
        blockUI
    	) {

        blockUI.start();

        $scope.storesCollection = [];
        $scope.displayedStoresCollection = [];

        $scope.itemsByPage = 10;

        $scope.disableDeleteBtn = false;

        StoresFactory.show(function(result) {

            $scope.storesCollection = result.data;

            console.log('RESULT STORES', result);


            $scope.storeIds = {};
            var arrIds = _.map($scope.storesCollection, function(store) {return store.id});

            for (var i = 0; i < arrIds.length; i++) {
                $scope.storeIds[i] = arrIds[i];
            }

            SalesFactory.show({_storeIds: $scope.storeIds, _getQtde: true}, function (result) {

                console.log('RESULT SALES', result);

                var itemVendas = result.data;

                _.each($scope.storesCollection, function (store) {
                    var item = _.findWhere(itemVendas, {'id': store.id});
                    store.qtdeVendida = item.qtdeVendida;
                    store.qtdeRestante = store.quantity - store.qtdeVendida;

                    var cover = _.find(store.product.images, function(image) {
                        if (image.isCover) return true;
                    });

                    store.cover = cover;
                });

                $scope.displayedStoresCollection = [].concat($scope.storesCollection);

                console.log('SSAS',  $scope.displayedStoresCollection );

                blockUI.stop();
            });
            
        });


    }
]);