'use strict';

R2Erp.controller('MyBusinessCtrl', [
	'$scope',
	function ($scope) {
		console.log('MyBusinessCtrl');
	}
]);

R2Erp.controller('MyBusinessMatrixCtrl', [
	'$scope',
	'ConfigFactory',
	'CompaniesFactory',
	function ($scope, ConfigFactory, CompaniesFactory) {
		$scope.addressesModel = [];
		$scope.index = 0;
		$scope.matrix = {
			emails: null,
		};

		$scope.options = {
            legalDocumentType: [],
            states: [],
        };

		$scope.matrixId = ConfigFactory.show({id: 1});

		$scope.matrixId.$promise.then(function (result) {
			$scope.matrixId = result.data.id;
			return CompaniesFactory.show({id: $scope.matrixId});
		}).then(function (result) {
			result.$promise.then(function (matrix) {
				$scope.matrix = matrix.data;
				_.each($scope.matrix, function (elem, key) {
					if (typeof $scope.matrix[key] === 'object') {
						$scope.matrix[key] = _(elem).values();
					}
				});


				console.log('MATRIX', $scope.matrix);
			});
		});


		/*$scope.matrix.$promise.then(function (result) {
			console.log('RESULT', result);
			$scope.matrix = result.data[$scope.matrixId];

			console.log('MATRIX', $scope.matrix);

			var socialNetworks = [];
			if (typeof $scope.matrix.socialNetworks === 'object') {
                for (var key in $scope.matrix.socialNetworks) {
                    socialNetworks.push(key);
                }

                $scope.matrix.socialNetworks = socialNetworks;
            }

            var addresses = [];

            if ('null' != $scope.matrix.address) {
            	addresses.push($scope.matrix.address);
            }

            $scope.addressesModel.push(addresses);
		});*/

		$scope.verifyMatrix = function () {
			console.log($scope.matrix);
		}
	}
]);

R2Erp.controller('MyBusinessSubsidiariesListCtrl', [
	'$scope',
	function ($scope) {
		console.log('MyBusinessSubsidiariesListCtrl');
	}
]);

R2Erp.controller('MyBusinessSubsidiariesCreateCtrl', [
	'$scope',
	function ($scope) {
		console.log('MyBusinessSubsidiariesCreateCtrl');
	}
]);

R2Erp.controller('MyBusinessSubsidiariesSaveCtrl', [
	'$scope',
	function ($scope) {
		console.log('MyBusinessSubsidiariesSaveCtrl');
	}
]);