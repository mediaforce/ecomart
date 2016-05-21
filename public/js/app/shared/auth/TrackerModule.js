'use strict';
/**
 * Tracker Module
 * - TrackerFactory
 * - TrackerService
 */
var TrackerModule = angular.module('TrackerModule', [
	'ngResource'
]);

TrackerModule.factory('TrackerFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/tracker/usertracker/:id', {}, {
            mostrar: {
                method: 'GET',
                isArray: false
            },
            registrar: {
                method: 'POST'
            },
            atualizar: {
                method: 'PUT',
                params: {
                    id: '@id'
                }
            },
            deletar: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }
]);

TrackerModule.service('TrackerService', [
	'TrackerFactory',
	'$q',
	'$http',
	function(TrackerFactory, $q, $http){
		var LOCAL_TOKEN_KEY = 'token_tracker';

		var trackerId = '';
		var userId = '';
		var user = '';
		var userRole = '';
		var userCartId = '';

		var isAuthenticated = false;

		var trackToken;

		function loadTrackerCredentials() {
			//console.log('carregando credenciais do tracker...');
			var token = window.localStorage.getItem(LOCAL_TOKEN_KEY);
			var userInit = {};

			if (token) {
				useCredentials(token);
				if (!isAuthenticated && authModule.isAuthenticated()) {
					//console.log('Atualizando tracker, pois o usuario logou-se...Atualizar o userId: ' + userId);
				} else {
					if (userId == authModule.getUserId()) {
						//console.log('Nada muda...');
					} else {
						//console.log('Novo Usuario Logado...Eliminar Token e usar credencial diferente...');

					}
				}
			} else {
				//console.log('Criar credenciais...');

				var date = new Date();
				userInit.userId = date.valueOf() + 'r' + Math.floor((Math.random() * 1000) + 1);
				userInit.userResolution = $(window).innerWidth() + 'x' + $(window).innerHeight();
				userInit.isRegistered = false;

				registrar(userInit).then(function(promise) {
					//console.log(promise);
				});
			}
			/*var token = window.localStorage.getItem(LOCAL_TOKEN_KEY);
			if (token) {
				// useCredentials(token);
				console.log('TOKEN ok', token);
			} else {
				TestApiFactory.registrar(
                    {
                        'isAuthenticated': false,
                        'uniqueId': date.valueOf() + 'r' + Math.floor((Math.random() * 1000) + 1) ,
                        'userResolution': $(window).innerWidth() + 'x' + $(window).innerHeight()

                    },
                    function(result) {
                        console.log(result);
                    }
                );
			}*/
		}

		function setToken(user) {

		}

		function unsetToken() {

		}

		function storeTrackerCredentials(token) {

		}

		function useCredentials(token) {

		}

		function destroyTrackerCredentials() {

		}

		function registrar(userInit) {
			//console.log('registrando...');
			var defObj = $q.defer();
			var trackerReg = TrackerFactory.registrar(userInit);

			trackerReg.$promise.then(function(data) {
				/*var user = data.data.user;
				var token = setToken(user);

				storeUserCredentials(token);*/

				defObj.resolve({'result': 'Success.', 'data': data });
			}, function(error) {
				defObj.resolve({'result': 'Failed.', 'error': error});
			});

			return defObj.promise;
		}

		function eliminar() {

		}

		var atualizar = function(authorizedRoles) {

		};

		var isTracking = function () {
			return trackToken !== undefined;
		}

		loadTrackerCredentials();

		return {
			'atualizar': atualizar,
			'isTracking': isTracking
		};
	}
]);

TrackerModule.run([
    'TrackerService',
    function(TrackerService) {

    }
]);