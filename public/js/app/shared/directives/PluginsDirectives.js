'use strict';
/**
 * Plugins Directives
 * - foundationInit
 * - polyfillerInit
 * - polyfillerUpdate
 */
var PluginsDirectives = angular.module('PluginsDirectives', []);

PluginsDirectives.directive('foundationInit', [

    function() {
        return {
            // Restrict it to be an attribute in this case
            restrict: 'A',
            scope: false,
            // responsible for registering DOM listeners as well as updating the DOM
            link: function(scope, element, attrs) {
                console.log('FOUNDATION INIT');

                $(document).foundation();
            }
        };
    }
]);

PluginsDirectives.directive('stickyContainer', [

    function() {
        return {
            // Restrict it to be an attribute in this case
            restrict: 'A',
            replace: false,
            // responsible for registering DOM listeners as well as updating the DOM
            link: function(scope, element, attrs) {
                $(element).sticky({topSpacing: 0});
            }
        };
    }
]);

PluginsDirectives.directive('polyfillerInit', [

    function() {
        return {
            // Restrict it to be an attribute in this case
            restrict: 'A',
            scope: false,
            // responsible for registering DOM listeners as well as updating the DOM
            link: function(scope, element, attrs) {
                webshim.setOptions('basePath', 'js/plugins/shims/');
                webshims.setOptions('waitReady', false);
                webshims.setOptions('forms-ext', {types: 'date'});
                webshims.polyfill('forms forms-ext');
            }
        };
    }
]);

PluginsDirectives.directive('polyfillerUpdate', [

    function() {
        return {
            // Restrict it to be an attribute in this case
            restrict: 'A',
            scope: false,
            // responsible for registering DOM listeners as well as updating the DOM
            link: function(scope, element, attrs) {
                $(element).updatePolyfill();
            }
        };
    }
]);

PluginsDirectives.directive('r2ShowHoverMenu', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: false,
            link: function(scope, element, attrs) {
                $(element).hover(function(event) {
                    $( ".r2-hover-menu" ).slideDown( "show", function() {
                        $(this).clearQueue();
                    });
                }, function(event) {
                    $( ".r2-hover-menu" ).slideUp( "show", function() {
                        $(this).clearQueue();
                    });
                })
            }
        }
    }
]);

PluginsDirectives.directive('r2ImageFill', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: false,
            link: function(scope, element, attrs) {
                $(element).imagefill(); 
            }
        }
    }
]);

PluginsDirectives.directive('r2ElevateZoom', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: false,
            link: function(scope, element, attrs) {
                attrs.$observe('zoomImage', function(val){
                    $(element).elevateZoom({
                        zoomType    : "inner", cursor: "crosshair"
                    });
                });

            }
        }
    }
]);


PluginsDirectives.directive('r2FancyGallery', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: false,
            link: function(scope, element, attrs) {
                console.log('FANCY GALLERY');
                attrs.$observe('zoomImage', function(val){
                    $(element).elevateZoom(
                        {gallery:'r2_product_gallery', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'}
                    );
                });

            }
        }
    }
]);


PluginsDirectives.directive('r2Easyzoom', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: false,
            link: function(scope, element, attrs) {
                console.log('FANCY GALLERY');
                attrs.$observe('zoom', function(val){
                    var $easyzoom = $(element).easyZoom();

                    // Get an instance API
                    var api = $easyzoom.data('easyZoom');
                });

            }
        }
    }
]);

PluginsDirectives.directive('barouselSlider', [
    function() {
        return {
            restrict: 'C',
            replace: false,
            scope: {
                load: '='
            },
            link: function(scope, element, attrs) {
                scope.$watch('load', function (newVal) {
                    if(newVal) {
                        $(element).barousel({    
                            navType: 2
                        });
                    }
                })
                
            }
        }
    }
]);
