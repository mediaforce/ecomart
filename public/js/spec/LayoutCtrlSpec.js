describe('LayoutCtrl', function() {

	beforeEach(module('R2TuApp'));

	var LayoutCtrl,
	scope;
  

 	beforeEach(inject(function ($rootScope, $controller) {
		scope = $rootScope.$new();
		LayoutCtrl = $controller('LayoutCtrl', {
			$scope: scope
		});

	}));

	it('says hello world!', function () {
		expect(scope.greeting).toEqual("Hello world!");
	});
	
});
