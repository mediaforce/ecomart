'use strict';

var StringFilters = angular.module('StringFilters', ['string']);

StringFilters.filter('capitalize', function (S) {
	return function (input) {
		return S(input).capitalize().s;
	}
});

StringFilters.filter('replaceSpecialChars', function () {
	return function (input) {
        var str_acento = "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
        var str_sem_acento = "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";

        var str = "";
        for (var i = 0; i < input.length; i++) {
            if (str_acento.indexOf(input.charAt(i)) != -1) {
                str += str_sem_acento.substr(str_acento.search(input.substr(i, 1)), 1);
            } else {
                str += input.substr(i, 1);
            }
        }
        return str;
    }
})

StringFilters.filter('snakeToCamel', function () {
    return function (input) {
        return s.replace(/(\_\w)/g, function(m){return m[1].toUpperCase();});
    }
})
