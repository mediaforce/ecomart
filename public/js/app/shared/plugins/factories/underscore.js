'use strict';
/**
 * Underscore Plugin Module...
 */

var underscore = angular.module('underscore', []);

underscore.factory('_', [

    function() {
        return window._;
    }
]);