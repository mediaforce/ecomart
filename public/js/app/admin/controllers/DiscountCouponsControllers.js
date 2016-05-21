'use strict';

R2Admin.controller('CouponsHomeCtrl', [
    '$scope',
    'DiscountCouponsFactory',
    'Notification',
    '_',
    'ngDialog',
    'coupons',
    'blockUI',
    function (
        $scope,
        DiscountCouponsFactory,
        Notification,
        _,
        ngDialog,
        coupons,
        blockUI
        ) {
        blockUI.start();

        $scope.couponsCollection = [];
        $scope.displayedCouponsCollection = [];
        $scope.itemsByPage = 5;
        $scope.disableDeleteBtn = false;

        DiscountCouponsFactory.show(function(result) {
            console.log('CUPONS', result);
            $scope.couponsCollection = result.data;
            $scope.displayedCouponsCollection = [].concat($scope.couponsCollection);
            blockUI.stop();
        });

        $scope.editCoupon = function () {

        }

        $scope.newProductCoupon = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/coupons/save-product.html',
                controller: 'ProductCouponSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
            }).then(function(value) {
                console.log('PORDUCT COUPON');
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.newDepartmentCoupon = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/coupons/save-department.html',
                controller: 'DepartmentCouponSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
            }).then(function(value) {
                console.log('DEPARTMENT COUPON');
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope._deleteCoupon = function(departmentId) {
            $scope.disableDeleteBtn = true;

            ngDialog.openConfirm({
                template: '<p>Excluir o departamento ID: ' + departmentId + '?</p>' +
                    '<div class="ngdialog-buttons">' +
                    '<button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog(0)">Não</button>' +
                    '<button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm(1)">Sim</button>' +
                    '</div>',
                plain: true,
                className: 'ngdialog-theme-default',
            }).then(function(value) {
                DepartmentsFactory.delete({
                    id: departmentId
                }, function(result) {

                    if (result.success) {
                        $scope.departmentsCollection = _.reject($scope.departmentsCollection, function(row) {
                            return row.id === departmentId
                        });
                        Notification.success({
                            message: 'Departamento excluido com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                    } else {
                        console.log('ERRO delete', result);
                    }

                    $scope.disableDeleteBtn = false;
                }, function(result) {
                    console.log('ERRO result', result);
                });
            }, function(value) {
                $scope.disableDeleteBtn = false;
            });
        }
    }
]);



R2Admin.controller('ProductCouponSaveCtrl', [
    '$scope',
    function ($scope) {
        $scope.pageTitle = 'Novo Cupom Para Produto';
    }
]);

R2Admin.controller('DepartmentCouponSaveCtrl', [
    '$scope',
    'DepartmentsFactory',
    'DiscountCouponsFactory',
    'blockUI',
    function ($scope, DepartmentsFactory, DiscountCouponsFactory, blockUI) {
        blockUI.start();
        $scope.coupon = {};
        $scope.coupon.department = 'ALL';
        $scope.pageTitle = 'Novo Cupom Para Departamento';

        $scope.options = {
            departments: []
        };

        DepartmentsFactory.show(function (result) {
            console.log('DEPARTAMENTOS', result);
            $scope.options.departments = result.data;
            blockUI.stop();
        });

        function getCoupon () {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for( var i=0; i < 12; i++ )
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        $scope.generateCoupon = function () {

            $scope.coupon.coupon = getCoupon();

            DiscountCouponsFactory.show({uniques: ['coupon']}, function (result) {
                console.log('uniques', result);
            });
        }

        $scope.saveCoupon = function () {
            DiscountCouponsFactory.save($scope.coupon, function(result) {
                console.log('SALVANDO...', result);
            });
        }
    }
]);
