'use strict';

R2Site.controller('ComprarProdutoCtrl',[
    '$scope',
    'ngCart',
    '$state',
    function ($scope, ngCart, $state) {
        $scope.comprarProduto = function (store, isCombo) {

            if (ngCart.getItemById(store.id.toString()) === false) {
                console.log('IS COMBO', isCombo);
                if (isCombo !== undefined) {
                    var id = store.id + '-C';
                    var name = store.comboProduct.title;
                    var price = store.unitDiscountPrice;
                    var quantity = 1;

                    var data = {
                            img: store.comboProduct.thumbnail.path, 
                            product: store.comboProduct,
                            isCombo: true
                    };

                    ngCart.addItem(id, name, price, quantity, data);
                } else {
                    var id = store.id;
                    var name = store.product.title;
                    var price = store.unitDiscountPrice;
                    var quantity = 1;
                    var data = {
                            img: store.cover.path, 
                            product: store.product
                    };

                    ngCart.addItem(id, name, price, quantity, data);
                }
            }            

            $state.go('root.checkout');
        }
    }
]);
R2Site.controller('CheckoutCtrl', [
    '$scope',
    'AuthService',
    'ngDialog',
    'ngCart',
    '$rootScope',
    'PagSeguroDirectPayment',
    'BoletoBradescoFactory',
    'PagseguroFactory',
    '$sce',
    '_',
    'sessionPagseguroId',
    'StatesFactory',
    'CitiesFactory',
    '$http',
    '$q',
    'CieloFactory',
    'CalcFreteFactory',
    '$window',
    'Notification',
    'CouponsFactory',
    function(
        $scope,
        AuthService,
        ngDialog,
        ngCart,
        $rootScope,
        PagSeguroDirectPayment,
        BoletoBradescoFactory,
        PagseguroFactory,
        $sce,
        _,
        sessionPagseguroId,
        StatesFactory,
        CitiesFactory,
        $http,
        $q,
        CieloFactory,
        CalcFreteFactory,
        $window,
        Notification,
        CouponsFactory) {      

        $scope.transactionModel = {
            card: {
                notSameCpf: false,
                notSameAddress: false,
                invoiceaddress: {}
            }
        };

        $scope.transaction = angular.copy($scope.transactionModel);

        console.log('CheckoutCtrl');

        $scope.checkoutChoice = 0;

        $scope.userLogged = false;
        $scope.hasBoleto = false;
        $scope.editableInputSeekCep = true;
        $scope.statesLoad = false;
        $scope.stateIsSelected = false;
        $scope.citiesLoad = false;
        $scope.valorTotal = ngCart.totalCost();
        $scope.totalItems = ngCart.getTotalItems();
        $scope.installmentsLoad = false;

        $scope.pagseguroSession = false;

        $scope.servicoFrete = "40010";
        $scope.hasFrete = false;
        $scope.hasCoupon = false;

        $scope.sessionPagseguroId = sessionPagseguroId.data;

        PagSeguroDirectPayment.setSessionId($scope.sessionPagseguroId);

        $scope.coupon = {};

        $scope.calcFrete = function () {

            var userId = AuthService.getUserId();
            var items = ngCart.getItems();
            var servicoFrete = $scope.servicoFrete;
            if ( _.size(items) > 0 ) {

                CalcFreteFactory.save({_userId: userId, _items: items, _servico: servicoFrete}, function (result) {
                    console.log('CALC FRETE', result);
                    if (result.success) {
                       $scope.hasFrete = true;
                        ngCart.setShipping(result.data);
                    }
                    
                });
                
            }
        }

        $scope.calcCoupon = function () {
            console.log($scope.coupon);
            CouponsFactory.show(function(result) {
                console.log(result);
                var coupons = result.data;
                
                _.each(coupons, function(coupon) {
                    console.log('COUPON', coupon);
                    if (coupon.coupon === $scope.coupon.coupon) {
                        var totalDiscount = 0;
                        if (coupon.couponType === 'DEPARTMENT') {
                            if (coupon.toAll) {


                                var items = ngCart.getItems();
                                
                                _.each(items, function(item) {
                                    console.log(item);
                                    var discount = item._price * (coupon.discount/100);
                                    totalDiscount += discount * item._quantity;

                                });
                                ngCart.setCoupon(coupon.coupon);
                                ngCart.setDiscount(totalDiscount);
                            } else {
                                var items = ngCart.getItems();
                                
                                _.each(items, function(item) {
                                    console.log(item);
                                    var discount = item._price * (coupon.discount/100);
                                    totalDiscount += discount * item._quantity;

                                });
                                ngCart.setCoupon(coupon.coupon);
                                ngCart.setDiscount(totalDiscount);
                            }


                        }
                    }
                })
            })
        }

        $scope.changeShipping = function () {
            ngCart.setShipping(0);
            $scope.hasFrete = false;
        }

        if (AuthService.isAuthenticated()) {
            $scope.userLogged = true;
            ngCart.setUser(AuthService.getUserId());
            ngCart.setUser(AuthService.getUserId());
            // ngCart.setShipping(23.53);
            // ngCart.setCoupon(1);
            // ngCart.setDiscount(10);
        }

        

        $scope.options = {
            states: [],
            cities: [],
            installments: []
        };

        StatesFactory.show(function(result) {
            _.each(
                result.data,
                function(state) {
                    $scope.options.states.push({
                        id: state.id,
                        name: state.code,
                        ibge_code: state.ibge_code,
                    });
                }
            );

            $scope.statesLoad = true;

        });

        $scope.stateSelectChange = function(state) {

            var deferred = $q.defer();

            if (state > 0) {

                $scope.options.cities = [];

                $scope.citiesLoad = false;

                $scope.stateIsSelected = true;

                CitiesFactory.show({
                    stateId: state
                }, function(result) {
                    console.log('CIDADES', result);
                    _.each(
                        result.data,
                        function(city) {
                            $scope.options.cities.push({
                                id: city.id,
                                name: city.name
                            });

                        }
                    );

                    $scope.citiesLoad = true;

                    deferred.resolve();

                });
            }

            return deferred.promise;
        };

        $scope.$watch('transaction.card.invoiceaddress.postcode', function (newVal, oldVal) {

            if (newVal != undefined) {
                console.log('CEP', newVal);
                $scope.editableInputSeekCep = false;
                var promise = null;
                var callCep = 'http://api.postmon.com.br/v1/cep/' + newVal;
                console.log('callCep', callCep);
                $http.jsonp(callCep + '?callback=JSON_CALLBACK')
                .then(function(response) {
                    console.log('CEP', response);
                    var endereco = response.data;

                    var state =_.find($scope.options.states, function (val_state) {
                        if (val_state.name == endereco.estado) return val_state;
                    });

                    if (state !== undefined && state !== null) {

                        $scope.transaction.card.invoiceaddress.state = state.id.toString();
                        promise = $scope.stateSelectChange(state.id);
                        promise.then(function () {
                            var city = _.find($scope.options.cities, function (val_city) {
                                if (val_city.id == Number(endereco.cidade_info.codigo_ibge.substr(0, 6))) return val_city;
                                return null;
                            });

                            if (city !== null && city !== undefined) {
                                $scope.transaction.card.invoiceaddress.city = city.id.toString();
                            }

                            $scope.transaction.card.invoiceaddress.neighborhood = endereco.bairro;
                            $scope.transaction.card.invoiceaddress.address1 = endereco.logradouro;

                            return true;

                        }).then(function () {
                            $scope.editableInputSeekCep = true;
                        });

                    };
                });
            } else {
                $scope.editableInputSeekCep = true;
            }
        });

        $scope.$watch('transactionForm.transction_cardNumber.$ccType', function (newVal) {
            if (newVal !== undefined) {
                if (newVal.toLowerCase() == 'maestro') {
                    newVal = 'elo';
                }

                if (newVal.toLowerCase() == 'american express') {
                    newVal = 'amex';
                }

                if (newVal.toLowerCase() == 'diners club') {
                    newVal = 'diners';
                }
                PagSeguroDirectPayment.getInstallments({
                    amount: ngCart.totalCost(),
                    brand: newVal.toLowerCase(),
                    maxInstallmentNoInterest: 10,
                    success: function(result) {
                        $scope.transaction.card.holder = newVal.toLowerCase();
                        $scope.options.installments = result.installments[newVal.toLowerCase()];
                        $scope.installmentsLoad = true;
                    },
                    error: function(result) {
                        console.log('ERROR getInstallments', result);
                        $scope.installmentsLoad = false;
                    },
                    complete: function(result) {
                        console.log('COMPLETE getInstallments', result);
                    }
                });
            }
        })

        $scope.$watch('transaction.card.notSameCpf', function(newVal) {
            $scope.transaction.card.otherCpf = '';
        })

        $scope.loginShow = function() {
            ngDialog.openConfirm({
                template: '/partials/site/pages/user/login/form.html',
                controller: 'LoginCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true
            }).then(function(value) {
                
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        };

        $scope.chooseCielo = function() {
            $scope.checkoutChoice = 1;
        }

        $scope.choosePagseguro = function() {
            $scope.checkoutChoice = 2;
        }

        $scope.chooseAgain = function() {
            $scope.checkoutChoice = 0;
        }

        $scope.checkoutBoleto = function() {
            console.log("CHECKOUT");
            ngDialog.openConfirm({
                template: '/template/dialogs/boleto-print.html',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                console.log('value BOLETO BRADESCO', value);
                BoletoBradescoFactory.save(
                {
                    customer: ngCart.getUser(), 
                    items: ngCart.getItems(), 
                    coupon: ngCart.getCoupon(), 
                    discount: ngCart.getDiscount(),
                    shipping: ngCart.getShipping(),
                    totalAmount: ngCart.totalCost(),
                    servicoFrete: $scope.servicoFrete
                }, function (result) {
                    console.log('CHECKOUT BOLETO BRADESCO', result);
                    if (result.success) {

                        function gerarBoleto() {
                            $scope.boleto = {};
                            $scope.boleto.valorTotal = ngCart.totalCost();
                            $scope.boleto.nossoNumero = result.pedidoId;
                            $scope.boleto.clienteNome = result.customer.person.name;
                            $scope.boleto.clienteDocumento = '';

                            if (result.customer.person.documents[1] !== undefined) {
                                $scope.boleto.clienteDocumento = result.customer.person.documents[1].field1;
                            } else {

                                $scope.boleto.clienteDocumento = result.customer.person.documents[0].field1;
                                var v = $scope.boleto.clienteDocumento;
                                v = v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
                                v = v.replace(/(\d{3})(\d)/,"$1.$2")    //Coloca ponto entre o terceiro e o quarto dígitos
                                v = v.replace(/(\d{3})(\d)/,"$1.$2")    //Coloca ponto entre o setimo e o oitava dígitos
                                v = v.replace(/(\d{3})(\d)/,"$1-$2");
                                $scope.boleto.clienteDocumento = v;
                            }
                            $scope.boleto.clienteEndereco1 = result.customer.person.addresses[0].address1 + ' - N° : ' + result.customer.person.addresses[0].number;                            
                                
                            if (result.customer.person.addresses[0].address2 !== undefined && result.customer.person.addresses[0].address2 !== null) {
                                $scope.boleto.clienteEndereco1 += ' / ' + result.customer.person.addresses[0].address2;
                            }
                            var cep = result.customer.person.addresses[0].postcode;
                            cep = cep.replace(/\D/g,"");
                            cep = cep.replace(/(\d{5})(\d)/,"$1-$2");
                            $scope.boleto.clienteEndereco2 = result.customer.person.addresses[0].city.name + ' / ' + result.customer.person.addresses[0].state.code + ' - CEP: ' + cep;

                            var demonstrativo3 = 'Produtos Adquiridos: ';
                            _.each(ngCart.getItems(), function (item) {
                                demonstrativo3 += item._name + ' - R$ ' + item._price + ' - Qtde.: ' + item._quantity + '; ';
                            });
                            $scope.boleto.demonstrativo3 = demonstrativo3;

                            $scope.boleto.produtosQtde = ngCart.getTotalItems();
                            

                            setTimeout(function() {
                                $('#form-boleto')[0].submit();
                            }, 500);
      
                            ngCart.empty();
                            $scope.totalItems = 0;
                            $scope.pedidoId = result.pedidoId;
                            $scope.vendaFinalizada = true;
                        }

                        ngDialog.openConfirm({
                            template: '\
                            <p>O Número do Seu Pedido: ' + result.pedidoId + '</p>\
                            <div class="ngdialog-buttons">\
                                <button type="button" class="button success" ng-click="closeThisDialog(0)">OK</button>\
                            </div>',
                            className: 'ngdialog-theme-default',
                            plain: true,
                            closeByEscape: true, // Assuming you want the same closing abilities.
                            closeByDocument: true,
                            scope: $scope,
                        }).then(function(value) {
                            gerarBoleto();
                        }).catch(function(value) {
                            gerarBoleto();
                        });                   
                    }
                });
            }).catch(function(value) {

            });            
        }

        $scope.checkoutCielo = function() {
            CieloFactory.save(
                {
                    customer: ngCart.getUser(), 
                    transaction: $scope.transaction, 
                    items: ngCart.getItems(), 
                    coupon: ngCart.getCoupon(), 
                    discount: ngCart.getDiscount(),
                    shipping: ngCart.getShipping(),
                    servicoFrete: $scope.servicoFrete
                }, function (result) {
                if (result.success) {
                    ngCart.empty();
                    $scope.totalItems = 0;
                    $scope.pedidoId = result.pedidoId;
                    $scope.vendaFinalizada = true;
                    Notification.success({
                        message: 'Compra efetuada com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    $scope.transaction = angular.copy($scope.transactionModel);
                    $scope.transactionForm.$setPristine();

                } else {
                    console.log(result);
                    Notification.error({
                        message: result.code + ' | Motivo: ' + result.msg,
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    $scope.transaction = angular.copy($scope.transactionModel);
                    $scope.transactionForm.$setPristine();
                }
            });
        }

        $scope.checkoutPagseguro = function() {
            ngDialog.openConfirm({
                template: '/template/dialogs/pagseguro-url.html',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                PagseguroFactory.save(
                {
                    customer: ngCart.getUser(), 
                    items: ngCart.getItems(), 
                    coupon: ngCart.getCoupon(), 
                    discount: ngCart.getDiscount(),
                    shipping: ngCart.getShipping(),
                    totalAmount: ngCart.totalCost(),
                    servicoFrete: $scope.servicoFrete
                }, function (result) {
                    console.log('CHECKOUT PAGSEGURO', result);
                    if (result.success) {
                        ngCart.empty();
                        $scope.totalItems = 0;
                        $scope.pedidoId = result.pedidoId;
                        $scope.vendaFinalizada = true;
                        window.open(result.data, '_self');
                    }
                });
            }).catch(function(value) {

            });            
        }

        $scope.testeA = function() {
            console.log('getItems', ngCart.getItems());

            var peso = [];
            var altura = [];
            var largura = [];
            var comprimento = [];

            _.each(ngCart.getItems(), function(item) {
                console.log('ITEM', item);
                if (!_.isUndefined(item._data.isCombo)) {
                    console.log('É COMBO!!!');
                    _.each(item._data.products, function(product) {
                        peso.push(product.weight);
                        altura.push(product.dimensionHeight);
                        largura.push(product.dimensionLength);
                        comprimento.push(product.dimensionWidth);
                    });
                } else {
                    peso.push(item._data.product.weight);
                    altura.push(item._data.product.dimensionHeight);
                    largura.push(item._data.product.dimensionLength);
                    comprimento.push(item._data.product.dimensionWidth);
                }
            });

            console.log('peso', peso);
            console.log('altura', altura);
            console.log('largura', largura);
            console.log('comprimento', comprimento);
        };

        $scope.testeB = function() {
            console.log('getItems', ngCart.getItems());
            console.log('getCoupon', ngCart.getCoupon());
            console.log('getDiscount', ngCart.getDiscount());

            ngCart.empty();
        }

        $scope.testeC = function() {
            console.log('transaction', $scope.transaction);
            console.log('cart', ngCart.getItems());
        }



/*        $scope.testeD = function () {
            TestReturnFactory.save({data1: 'teste 1', data2: 'teste 2'}, function (result) {
                console.log('SHIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIT TestReturnFactory', result);
            })
        }*/

        $rootScope.$on('ngCart:checkout_succeeded', function(event, args) {
            console.log('BROADCAST', args.data);
            /*console.log('BROADCAST', args.data);

            PagSeguroDirectPayment.setSessionId(args.data);

            PagSeguroDirectPayment.getPaymentMethods({
                success: function (result) {
                    console.log('SUCCESS getPaymentMethods', result);
                },
                error: function (result) {
                    console.log('ERROR getPaymentMethods', result);
                },
                complete: function (result) {
                    console.log('COMPLETE getPaymentMethods',result);
                }
            });

            PagSeguroDirectPayment.getBrand({
                cardBin: '4111111111111111',
                success: function (result) {
                    console.log('SUCCESS getBrand', result);
                },
                error: function (result) {
                    console.log('ERROR getBrand', result);
                },
                complete: function (result) {
                    console.log('COMPLETE getBrand',result);
                }
            });

            var param = {
                cardNumber: '4111111111111111',
                brand: 'visa',
                cvv: '123',
                expirationMonth: '12',
                expirationYear: '2030',
                success: function (result) {
                    console.log('SUCCESS createCardToken', result);
                },
                error: function (result) {
                    console.log('ERROR createCardToken', result);
                },
                complete: function (result) {
                    console.log('COMPLETE createCardToken',result);
                }
            };

            PagSeguroDirectPayment.createCardToken(param);

            PagSeguroDirectPayment.getInstallments({
                amount: '1532.65',
                brand: 'visa',
                maxInstallmentNoInterest: 6,
                success: function (result) {
                    console.log('SUCCESS getInstallments', result);
                },
                error: function (result) {
                    console.log('ERROR getInstallments', result);
                },
                complete: function (result) {
                    console.log('COMPLETE getInstallments',result);
                }
              });*/

        });

        $rootScope.$on('ngCart:change', function(event, args) {
            $scope.valorTotal = ngCart.totalCost();
            $scope.totalItems = ngCart.getTotalItems();
            if ($scope.totalItems === 0) {
                ngCart.setShipping(0);
                ngCart.setCoupon(null);
                ngCart.setDiscount(0);
            }
            $scope.hasFrete = false;
        });

        $scope.renderHtml = function(htmlCode) {
            return $sce.trustAsHtml(htmlCode);
        };
    }

])


R2Site.controller('PagseguroCompraFinalizadaCtrl', [
    '$scope',
    '$location',
    'NotificationPagseguroFactory',
    function ($scope, $location, NotificationPagseguroFactory) {
        console.log($location.search().transaction_id);

        NotificationPagseguroFactory.show({id: $location.search().transaction_id}, function (result) {
            console.log('RESULT', result);
            if (result.success) {
                $scope.pedidoId = result.order.id;    
            }
            
        })


    }

]);