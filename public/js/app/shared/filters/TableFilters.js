'use strict';

var TableFilters = angular.module('TableFilters', ['string']);

TableFilters.filter('genericFilter', [
    '$filter',
    '_',
    function($filter, _) {

        return function(input, predicate) {
            var hasItem = true;

            var keys = _.keys(predicate);


            var search = _.filter(input, function(item) {
                _.each(keys, function(key) {

                    if (_.isObject(predicate[key])) {
                        var subKeys1 = _.keys(predicate[key]);

                        _.each(subKeys1, function(subKey1) {
                            if (_.isObject(predicate[key][subKey1])) {
                                var subKeys2 = _.keys(predicate[key][subKey1]);

                                hasItem = _.every(subKeys2, function(subKey2) {
                                    if (_.has(item[key][subKey1][subKey2])) {
                                        if (_.isNumber(item[key][subKey1][subKey2])) {
                                            if (item[key][subKey1][subKey2].toString().indexOf(predicate[key][subKey1][subKey2]) > -1) {

                                                return true;
                                            }
                                            return false;
                                        }

                                        if (_.isString(item[key][subKey1][subKey2])) {
                                            if (item[key][subKey1][subKey2].toLowerCase().indexOf(predicate[key][subKey1][subKey2].toLowerCase()) > -1) {
                                                return true;
                                            }

                                            return false;
                                        }

                                    }

                                    return true;
                                });


                            } else {

                                hasItem = (function() {
                                    if (_.has(item[key], subKey1)) {

                                        if (_.isNumber(item[key][subKey1])) {
                                            if (item[key][subKey1].toString().indexOf(predicate[key][subKey1]) > -1) {

                                                return true;
                                            }
                                            return false;
                                        }

                                        if (_.isString(item[key][subKey1])) {
                                            if (item[key][subKey1].toLowerCase().indexOf(predicate[key][subKey1].toLowerCase()) > -1) {

                                                return true;
                                            }

                                            return false;
                                        }
                                    }

                                    return true;
                                })();

                            }
                        })

                    } else {

                        hasItem = (function() {
                            if (_.has(item, key)) {

                                if (_.isNumber(item[key])) {
                                    if (item[key].toString().indexOf(predicate[key]) > -1) {
                                        return true;
                                    }
                                    return false;
                                }
                                if (_.isString(item[key])) {
                                    if (item[key].toLowerCase().indexOf(predicate[key].toLowerCase()) > -1) {
                                        return true;
                                    }
                                    return false;
                                }

                            }

                            return true;
                        })();

                    }

                });

                return hasItem;

            });

            return search;
        }
    }
]);

TableFilters.filter('genericStoreFilter', [
    '$filter',
    '_',
    function($filter, _) {

        return function(input, predicate) {
            var hasItem = true;

            var keys = _.keys(predicate);


            var search = _.filter(input, function(item) {
                _.each(keys, function(key) {

                    if (_.isObject(predicate[key])) {
                        var subKeys1 = _.keys(predicate[key]);

                        _.each(subKeys1, function(subKey1) {
                            if (_.isObject(predicate[key][subKey1])) {
                                var subKeys2 = _.keys(predicate[key][subKey1]);

                                hasItem = _.every(subKeys2, function(subKey2) {
                                    if (_.has(item[key][subKey1][subKey2])) {
                                        if (_.isNumber(item[key][subKey1][subKey2])) {
                                            if (item[key][subKey1][subKey2].toString().indexOf(predicate[key][subKey1][subKey2]) > -1) {

                                                return true;
                                            }
                                            return false;
                                        }

                                        if (_.isString(item[key][subKey1][subKey2])) {
                                            if (item[key][subKey1][subKey2].toLowerCase().indexOf(predicate[key][subKey1][subKey2].toLowerCase()) > -1) {
                                                return true;
                                            }

                                            return false;
                                        }

                                    }

                                    return true;
                                });


                            } else {

                                hasItem = (function() {
                                    if (_.has(item[key], subKey1)) {

                                        if (_.isNumber(item[key][subKey1])) {
                                            if (item[key][subKey1].toString().indexOf(predicate[key][subKey1]) > -1) {

                                                return true;
                                            }
                                            return false;
                                        }

                                        if (_.isString(item[key][subKey1])) {
                                            if (item[key][subKey1].toLowerCase().indexOf(predicate[key][subKey1].toLowerCase()) > -1) {

                                                return true;
                                            }

                                            return false;
                                        }
                                    }

                                    return true;
                                })();

                            }
                        })

                    } else {

                        hasItem = (function() {
                            if (_.has(item, key)) {

                                if (_.isNumber(item[key])) {
                                    if (item[key].toString().indexOf(predicate[key]) > -1) {
                                        return true;
                                    }
                                    return false;
                                }
                                if (_.isString(item[key])) {
                                    if (item[key].toLowerCase().indexOf(predicate[key].toLowerCase()) > -1) {
                                        return true;
                                    }
                                    return false;
                                }

                            }

                            return true;
                        })();

                    }

                });

                return hasItem;

            });

            

            search = _.filter(search, function(item) {
            	var hasItem = true;
        		var precoMin = true;            	
            	
                if (predicate.precoMin !== undefined) {

                    if (_.isNumber(Number(predicate.precoMin))) {

                        if (Number(item['unitPrice']) > Number(predicate.precoMin)) {
                            hasItem = true;
                        } else {
                            precoMin = false;
                            hasItem = false;
                        }
                    }
                }

                if (predicate.precoMax !== undefined) {

                    if (_.isNumber(Number(predicate.precoMax))) {

                        if (Number(item['unitPrice']) < Number(predicate.precoMax)) {
                            hasItem = true && precoMin;
                        } else {
                            hasItem = false;
                        }
                    }

                }

                return hasItem;
            });

            return search;
        }
    }
]);