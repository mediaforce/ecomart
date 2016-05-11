'use strict';

R2Admin.controller('DepartmentsHomeCtrl', [
    '$scope',
    'DepartmentsFactory',
    'Notification',
    '_',
    'ngDialog',
    'departments',
    'blockUI',
    function (
    	$scope,
        DepartmentsFactory,
        Notification,
        _,
        ngDialog,
        departments,
        blockUI
    	) {

        blockUI.start();
        $scope.departmentsCollection = [];
        $scope.displayedCollection = [];
        $scope.itemsByPage = 5;
        $scope.disableDeleteBtn = false;

        if (departments.success != undefined) {
            if (departments.success) {
                DepartmentsFactory.show(function(result) {
                    $scope.departmentsCollection = result.data;
                    $scope.displayedCollection = [].concat($scope.departmentsCollection);
                    blockUI.stop();
                });
            }
        } else {
            blockUI.stop();
            // redirect...
        }

        $scope.viewCats = function (departmentId) {
            var obj = _.find($scope.departmentsCollection, function(dept) {
                return dept.id == departmentId;
            });

            $scope.departmentTitle = obj.name;
            $scope.categories = obj.categories;

            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/departments/show-categories.html',
                controller: 'CategoriesShowCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {

            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.delete = function(departmentId) {
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

R2Admin.controller('DepartmentSaveCtrl', [
    '$scope',
    '$stateParams',
    'DepartmentsFactory',
    'Notification',
    '_',
    '$state',
    'department',
    'ngDialog',
    function (
    	$scope,
        $stateParams,
        DepartmentsFactory,
        Notification,
        _,
        $state,
        department,
        ngDialog
    ) {

        $scope.categoriesCollection = [];
        $scope.displayedCategoriesCollection = [];
        $scope.disableSaveBtn = false;
        $scope.hasDepartment = false;

        if ($stateParams.departmentId != undefined) {
            if (department.success) {
                DepartmentsFactory.show({id: $stateParams.departmentId}, function (result) {
                    $scope.pageTitle = 'Departamento ID: ' + $stateParams.departmentId;
                    $scope.btnSave = 'Salvar';
                    $scope.department = result.data;
                    $scope.categoriesCollection = $scope.department.categories;

                    $scope.hasDepartment = true;

                });
            } else {
                Notification.error({
                    message: 'Departamento ID não encontrado!',
                    title: 'Aviso',
                    templateUrl: '/partials/shared/notifications/generic.html'
                });

                $state.go('admin.products.departments');
            }
        } else {
            $scope.hasDepartment = false;
            $scope.pageTitle = 'Cadastro de Novo Departamento';
            $scope.btnSave = 'Cadastrar';

        }

        $scope.addCategory = function () {
            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/departments/save-category.html',
                controller: 'CategoriesSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                console.log('THEN', value);

                $scope.categoriesCollection.push(value);
                /*DepartmentsFactory.show({
                    id: value
                }, function(result) {
                    console.log('RESULT', result);
                    if (result.success) {
                        $scope.departmentsCollection.push(result.data);
                    }

                    //$scope.departmentsCollection = result.data;
                    //$scope.displayedCollection = [].concat($scope.departmentsCollection);
                });*/
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.editCategory = function (categoryToEdit) {
            $scope.categoryToEdit = categoryToEdit;

            ngDialog.openConfirm({
                template: '/partials/admin/pages/products/departments/save-category.html',
                controller: 'CategoriesSaveCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true,
                scope: $scope,
            }).then(function(value) {
                console.log('THEN', value);

                if (value.id == undefined) {
                    $scope.categoriesCollection.push(value);
                }
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        }

        $scope.deleteCategory = function (categoryId) {

            ngDialog.openConfirm({
                template: '<p>Excluir a categoria ID: ' + categoryId + '?</p>' +
                    '<div class="ngdialog-buttons">' +
                    '<button type="button" class="ngdialog-button ngdialog-button-secondary" ng-click="closeThisDialog(0)">Não</button>' +
                    '<button type="button" class="ngdialog-button ngdialog-button-primary" ng-click="confirm(1)">Sim</button>' +
                    '</div>',
                plain: true,
                className: 'ngdialog-theme-default',
            }).then(function(value) {
                $scope.categoriesCollection = _.reject($scope.categoriesCollection, function(row) {
                    return row.id === categoryId;
                });
            });
        }

        $scope.save = function () {
            $scope.disableSaveBtn = true;

            $scope.department.categories = $scope.categoriesCollection;

            if ($stateParams.departmentId != undefined) {
                DepartmentsFactory.update($scope.department, function(result) {
                    if (result.success) {
                        Notification.success({
                            message: 'Departamento atualizada com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });
                        $state.go('admin.products.departments');
                    } else {
                        console.log('ERROR update', result);
                    }

                    $scope.disableSaveBtn = false;
                }, function (result) { console.log('ERRO response', result);})
            } else {
                DepartmentsFactory.save($scope.department, function (result) {

                    if (result.success) {
                        Notification.success({
                            message: 'Departamento cadastrado com sucesso!',
                            title: 'Aviso',
                            templateUrl: '/partials/shared/notifications/generic.html'
                        });

                        $scope.department = {};
                        $scope.categoriesCollection = [];

                        $scope.departmentForm.$setPristine();
                    } else {
                        console.log('ERROR save', result);
                    }

                    $scope.disableSaveBtn = false;

                }, function (result) { console.log('ERRO response', result);});
            }
        }
    }
]);



R2Admin.controller('CategoriesSaveCtrl', [
    '$scope',
    'Notification',
    '_',
    function(
        $scope,
        Notification,
        _
    ) {

        $scope.disableSaveBtn = false;

        if ($scope.categoryToEdit != undefined) {
            $scope.pageTitle = 'Categoria ID: ' + $scope.categoryToEdit.id;
            $scope.btnSave = 'Salvar';
            $scope.category = $scope.categoryToEdit;

        } else {
            $scope.pageTitle = 'Cadastro de Nova Subcategoria';
            $scope.btnSave = 'Cadastrar';
        }

        $scope.save = function() {
            $scope.confirm($scope.category);
        }

    }
]);

R2Admin.controller('CategoriesShowCtrl', [
    '$scope',
    'Notification',
    '_',
    function(
        $scope,
        Notification,
        _
    ) {
        $scope.displayCategories = $scope.categories;

    }
]);