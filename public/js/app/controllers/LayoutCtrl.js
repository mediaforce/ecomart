'use strict';

R2TuApp.controller('LayoutCtrl', ['$scope', '$location', function($scope, $location) {
	$scope.teste = 'Teste';
	$scope.greeting = 'Hello world!';

	$scope.isActive = function (path) {

		if ($location.path() === path) {
			return 'active';
		} else {
			return '';
		}
	}
	
}]);
