'use strict';



R2Admin.controller('SaleOrdersHomeCtrl', [

    '$scope',

    'OrderSalesFactory',

    'blockUI',

    '_',

    'NotificationPagseguroFactory',

    'NotificationCieloFactory',

    'ngDialog',

    function (

        $scope,

        OrderSalesFactory,

        blockUI,

        _,

        NotificationPagseguroFactory,

        NotificationCieloFactory,

        ngDialog

    ) {

        blockUI.start();



        $scope.itemsByPage = 6;



        OrderSalesFactory.show(function (result) {

            

            if (result.success) {

                $scope.saleOrdersCollection = result.data;

                

                console.log('RESULT ORDERS', $scope.saleOrdersCollection);

                _.each($scope.saleOrdersCollection, function(saleOrder) {

                    if (saleOrder.paymentType == 'BOLETO') {

                        saleOrder.isBoleto = true;

                    } else if (saleOrder.paymentType == 'CIELO') {

                        saleOrder.isCielo = true;

                    } else if (saleOrder.paymentType == 'PAGSEGURO') {

                        saleOrder.isPagseguro = true;

                    }

                })



                $scope.displayedSaleOrdersCollection = [].concat($scope.saleOrdersCollection);

                blockUI.stop();

            } else {

                console.log('RESULT', result);

                blockUI.stop();    

            }



        });



        $scope.gotoCart = function(sales) {

            $scope.sales = sales;

            ngDialog.open({

                template: 'partials/admin/pages/sales/carrinho.html',

                className: 'ngdialog-theme-default',

                appendClassName: 'r2-cart-minhas-compras-dialog',

                controller: 'MeuCarrinhoUserCtrl',

                scope: $scope

            });

        }



        $scope.gotoCustomer = function(customer) {

            $scope.customer = customer;

            ngDialog.open({

                template: 'partials/admin/pages/sales/cliente.html',

                className: 'ngdialog-theme-default',

                appendClassName: 'r2-cart-minhas-compras-dialog',

                controller: 'CustomerCtrl',

                scope: $scope

            });

        }







        $scope.updateCieloPayment = function (tid) {

            NotificationCieloFactory.show({id: tid}, function (result) {

                console.log('CIELO NOTIFICATION', result)

                $scope.updateOrder(result.order);

            });

        }



        $scope.updateOrder = function (orderToUpdate) {

            _.each($scope.saleOrdersCollection, function (order) {

                console.log('ORDER ID', order.id);

                console.log('ORDER TO UPDATE', orderToUpdate.id);

                if (order.id === orderToUpdate.id) {

                    order = orderToUpdate;

                }

            })

        }



        $scope.updatePagseguroPayment = function (tid) {

            NotificationPagseguroFactory.show({id: tid}, function (result) {

                console.log('PAGSEGURO NOTIFICATION', result)

                $scope.updateOrder(result.order);

            });

        }



        $scope.updateBoletoPayment = function (id) {

            console.log('ATUALIZAR PAGTO BOLETO');

            $scope.orderId = id;

            //$scope.updateOrder(result.order);

            ngDialog.openConfirm({

                template: '/partials/admin/pages/sales/boleto-status.html',

                controller: 'BoletoSaveCtrl',

                className: 'ngdialog-theme-default',

                closeByEscape: true, // Assuming you want the same closing abilities.

                closeByDocument: true,

                scope: $scope,

            }).then(function(value) {

                console.log('THEN', value);

                $scope.updateOrder(value);

                

            }).catch(function(value) {

                console.log('CATCH', value);

            });

        }



        $scope.deleteOrder = function(id) {

            OrderSalesFactory.delete({'id': id}, function (result) {

                console.log(result);



                $scope.saleOrdersCollection = _.reject($scope.saleOrdersCollection, function (order) {

                    return order.id === id;

                })

            })

        }



        $scope.cancelarCielo = function (_id) {

            NotificationCieloFactory.delete({id: _id}, function (result) {

                console.log(result);

                if (result.success) {

                    $scope.updateOrder(result.order);    

                }

                

            })

        }



        $scope.gotoDateDelivery = function(id) {

            $scope.orderId = id;

            ngDialog.openConfirm({

                template: '/partials/admin/pages/sales/date-delivery.html',

                controller: 'DateDeliveryUpdateCtrl',

                className: 'ngdialog-theme-default',

                closeByEscape: true, // Assuming you want the same closing abilities.

                closeByDocument: true,

                scope: $scope,

            }).then(function(value) {

                console.log('THEN', value);

                $scope.updateOrder(value);

                

            }).catch(function(value) {

                console.log('CATCH', value);

            });

        }   

    }

]);



R2Admin.controller('DateDeliveryUpdateCtrl', [

    '$scope',

    'OrderSalesFactory',

    function (

        $scope,

        OrderSalesFactory

        ) {



        $scope.updateDateDelivery = function () {

            OrderSalesFactory.update({id: $scope.orderId, data: { order:  $scope.order, dateDelivery: true } }, function(result) {

                console.log(result);

                if (result.success) {
                    $scope.confirm(result.order);
                } else {
                    $scope.closeThisDialog();
                }

                

            })

        }



    }

]);



R2Admin.controller('CustomerCtrl', [

    '$scope',

    function (

        $scope

        ) {

        console.log($scope.customer);

    }

])



R2Admin.controller('BoletoSaveCtrl', [

    '$scope',

    'OrderSalesFactory',

    function (

        $scope,

        OrderSalesFactory

        ) {



        $scope.options = {

            paymentStatus : []

        };



        $scope.boleto = {};



        $scope.options.paymentStatus.push({name: 'Aguardando pagamento'});

        $scope.options.paymentStatus.push({'name': 'Paga'});

        $scope.options.paymentStatus.push({'name': 'Cancelada'});



        $scope.updateBoletoStatus = function() {

            OrderSalesFactory.update({id: $scope.orderId, data: {boleto: $scope.boleto, updateBoleto: true} }, function(result) {

                $scope.confirm(result.order);

            })

        }

    }

])



R2Admin.controller('MeuCarrinhoUserCtrl', [

    '$scope',

    'UsersFactory',

    function (

        $scope,

        UsersFactory

        ) {

        //$scope.displayedCollection = $scope.sales;

        console.log('SALES', $scope.sales);



    }

]);