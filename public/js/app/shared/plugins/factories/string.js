'use strict';
/**
 * Underscore Plugin Module...
 */

var string = angular.module('string', []);

string.factory('S', [

    function() {
        return window.S;
    }
]);