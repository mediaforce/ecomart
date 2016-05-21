'use strict';

var ValidationDirectives = angular.module('ValidationDirectives', []);

ValidationDirectives.directive('r2CompareTo', function() {
	return {
		require: 'ngModel',
		replace: false,
		scope: false,
		link: function (scope, element, attributes, ngModel) {
			ngModel.$validators.r2CompareTo = function(modelValue) {
				return modelValue === scope.formCtrl.user_password.$modelValue;

			};

			scope.$watch("formCtrl.user_password.$modelValue", function() {
				ngModel.$validate();
			});

		}
	};
});

ValidationDirectives.directive('r2UniqueUser', [
	'CheckUniqueUserFactory',
	'$q',
	function(CheckUniqueUserFactory, $q) {
		return {
			require: 'ngModel',
			link: function (scope, element, attributes, ngModel) {
				var RE_EMAIL = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;

				ngModel.$asyncValidators.r2UniqueUser = function(modelValue) {

					if (RE_EMAIL.test(modelValue)) {
						var defObj = $q.defer();
	                    return CheckUniqueUserFactory.show({user: modelValue}).$promise.then(function(result) {
	                    	if (result.data) {
	                    		return $q.reject();
	                    	} else {
	                    		return true;
	                    	}
	                    });
					}

				};
			}
		};
	}
]);

ValidationDirectives.directive('dynAttr', [
	'$compile',
	function($compile) {
	    return {
	        link: function(scope, elem, attrs){
	        	elem.attr('ui-br-cpf-mask');
	        }
	    };
	}
]);