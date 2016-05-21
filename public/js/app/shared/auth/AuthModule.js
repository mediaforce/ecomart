'use strict';

/**
 * Auth Module:
 * - AUTH_EVENTS
 * - LoginFactory
 * - AuthService
 * - AuthInterceptor
 */

var AuthModule = angular.module('AuthModule', [
	'ngResource',
]);

AuthModule.config(function ($httpProvider) {
  $httpProvider.interceptors.push('AuthInterceptor');
});

AuthModule.constant('AUTH_EVENTS', {
	notAuthenticated: 'auth-not-authenticated',
	notAuthorized: 'auth-not-authorized',
});

AuthModule.factory('LoginFactory', [
    '$resource',
    function($resource) {
        return $resource('/api/user/users/auth/:id', {}, {
            checkIdentity: {
                method: 'GET',
                isArray: false
            },
            login: {
                method: 'POST'
            },
            logout: {
                method: 'DELETE',
                params: {
                    id: '@id'
                }
            }
        });
    }
]);

AuthModule.service('AuthService', [
	'LoginFactory',
	'$q',
	'$http',
	'AUTH_EVENTS',
	function(LoginFactory, $q, $http, AUTH_EVENTS){
		var LOCAL_TOKEN_KEY = 'token_user';
		var userId = '';
		var user = '';
		var userRole = '';
		var userName = '';
		var isAuthenticated = false;
		var authToken;

		function loadUserCredentials() {
			var token = window.localStorage.getItem(LOCAL_TOKEN_KEY);
			if (token) {
				console.log('TOKEN', token);
				useCredentials(token);
			} else {
				LoginFactory.checkIdentity(function(data) {
					console.log('CHECK IDENTITY', data);

					if (data.data.success) {
						token = setToken(data.data.user);
						storeUserCredentials(token);
					}
				});
			}
		}

		function setToken(user) {
			var token = '';

			token += user.id + '|';
			token += user.user + '|';
			token += user.role.name + '|';
			token += user.person.name;

			return token;
		}

		function unsetToken() {
			authToken = undefined;
		    userId = '';
			user = '';
			userRole = '';
			userName = '';
		}

		function storeUserCredentials(token) {
			window.localStorage.setItem(LOCAL_TOKEN_KEY, token);
			useCredentials(token);
		}

		function useCredentials(token) {
			var secToken = token.split('|');

			userId = secToken[0];
			user = secToken[1];
			userRole = secToken[2];
			userName = secToken[3];

			isAuthenticated = true;
			authToken = token;

			console.log('AUTH TOKEN', authToken);

			$http.defaults.headers.common['X-Auth-Token'] = token;
		}

		function destroyUserCredentials() {
		    unsetToken();
		    isAuthenticated = false;
		    $http.defaults.headers.common['X-Auth-Token'] = undefined;
		    window.localStorage.removeItem(LOCAL_TOKEN_KEY);
		}

		var run = function () {
			loadUserCredentials();
		}

		var login = function (user, password) {

			var defObj = $q.defer();
			var login = LoginFactory.login({'user': user, 'password': password});

			login.$promise.then(function(data) {
				var user = data.data.user;
				var token = setToken(user);

				storeUserCredentials(token);

				defObj.resolve({'result': 'Login success.' });
			}, function(error) {
				defObj.reject({'result': AUTH_EVENTS.notAuthenticated, 'error': error});
			});

			return defObj.promise;

		}

		var logout = function() {
			LoginFactory.logout({'id': userId});
			destroyUserCredentials();
		}

		var isAuthorized = function(authorizedRoles) {
			console.log('USER ROLE', userRole);
			console.log('AUTHORIZED ROLES', authorizedRoles);
			if (!angular.isArray(authorizedRoles)) {
				authorizedRoles = [authorizedRoles];
			}

			return (isAuthenticated && authorizedRoles.indexOf(userRole) !== -1);
		};

		loadUserCredentials();

		return {
			run: run,
			login: login,
			logout: logout,
			isAuthorized: isAuthorized,
			isAuthenticated: function() { return isAuthenticated; },
			getUserId: function() { return userId; },
			getUser: function() { return user; },
			getUserName: function() { return userName; },
			getUserRole: function() { return userRole; },
			getAuthToken: function() { return authToken; }
		};
	}
]);

AuthModule.factory('AuthInterceptor', function($rootScope, $q, AUTH_EVENTS) {
	return {
		responseError: function (response) {
			console.log('response', response);
			if(response.status == 401) {
				$rootScope.$broadcast('notLogged', true);
			}
			$rootScope.$broadcast({
				401: AUTH_EVENTS.notAuthenticated,
				403: AUTH_EVENTS.notAuthorized,
			}[response.status], response);

			return $q.reject(response);
		}
	}
});

AuthModule.run(function($templateCache) {
   $templateCache.removeAll();
});

/*
// TODO I don't fully understand this method yet....
AuthModule.run(
[
	'$rootScope',
	'$state',
	'AuthService',
	'AUTH_EVENTS',
	function($rootScope, $state, AuthService, AUTH_EVENTS) {
	    $rootScope.$on('$stateChangeStart', function (event, next, nextParams, fromState) {
	    	console.log('stateChangeStart level 0');
	    	console.log('NEXT', next);
	    	if ('data' in next && 'authorizedRoles' in next.data) {
	    		console.log('1 stateChangeStart [if data in next and ...] level 1');
				var authorizedRoles = next.data.authorizedRoles;
				if (!AuthService.isAuthorized(authorizedRoles)) {
					console.log('2 stateChangeStart [if not AuhService.isAuthorized ...] level 2');
					event.preventDefault();
					$state.go($state.current, {}, {reload: true});
					W$rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
				}
			}

			if (!AuthService.isAuthenticated()) {
				console.log('3 stateChangeStart [if not AuthService.isAuthenticated ...] level 1');
				if (next.name !== 'login_usuario') {
					console.log('4 sadasd stateChangeStart [if next.name not equal login ...] level 2');
					event.preventDefault();
					$state.go('login_usuario');
				}
			}
	    });
	}
]);
*/