'use strict';

R2Admin.controller('HomeCtrl', [
    '$scope',

    function (
    	$scope,
    	ImagesFactory
    	) {

    }
]);

R2Admin.controller('TestCtrl', [
    '$scope',
    'ImagesFactory',
    'Upload',
    function (
    	$scope,
    	ImagesFactory,
    	Upload
    	) {
    	console.log('TESTE CONTROLLER');

    	$scope.images = [];

    	$scope.enviar = function () {

    		Upload.upload({
	            url: '/api/base/images',
	            data: {files: $scope.files}
	        }).then(function (resp) {
	            console.log('Success ', resp);
	        }, function (resp) {
	            console.log('Error status: ', resp);
	        }, function (evt) {
	            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
	            //console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
	        });

    	};

    	$scope.selectedCover = function(index) {
    		console.log(index);
    	}

    	$scope.fileUploadedAndFormSubmitted = function (img, msg) {
    		console.log('IMAGE', img);
    		console.log('MESSAGE', msg);

    	}
    }
]);