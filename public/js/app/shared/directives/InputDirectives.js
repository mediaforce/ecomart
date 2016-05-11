'use strict';

var InputDirectives = angular.module('InputDirectives', []);

InputDirectives.directive("r2InputDisabled", function(){
  return function(scope, element, attrs){
  	console.log('R2 INPUT ATTR', attrs.r2InputDisabled);
    scope.$watch(attrs.r2InputDisabled, function(val){
      if(val)
        element.removeAttr("disabled");
      else
        element.attr("disabled", "disabled");
    });
  }
});

InputDirectives.directive('r2HttpPrefix', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function(scope, element, attrs, controller) {
            function ensureHttpPrefix(value) {
                // Need to add prefix if we don't have http:// prefix already AND we don't have part of it
                if(value && !/^(https?):\/\//i.test(value)
                   && 'http://'.indexOf(value) === -1) {
                    controller.$setViewValue('http://' + value);
                    controller.$render();
                    return 'http://' + value;
                }
                else
                    return value;
            }
            controller.$formatters.push(ensureHttpPrefix);
            controller.$parsers.splice(0, 0, ensureHttpPrefix);
        }
    };
});