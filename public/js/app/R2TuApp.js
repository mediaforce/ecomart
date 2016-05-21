'use strict';

var R2TuApp = angular.module('R2TuApp',[]);

R2TuApp.config(function($locationProvider){
    $locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});
});