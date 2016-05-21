var ConstantsModule = angular.module('ConstantsModule', []);

ConstantsModule.constant('AUTH_EVENTS', {
	notAuthenticated: 'auth-not-authenticated',
	notAuthorized: 'auth-not-authorized',
});
