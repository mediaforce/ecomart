'use strict';
/**
 * SocialNetworksDirectives
 * - addSocialNetworks
 * - btnAddSocialNetwork
 * - socialNetwork
 */

var VideosDirectives = angular.module('VideosDirectives', []);

// TEMPORÁRIO
VideosDirectives.run(function($templateCache) {
   $templateCache.removeAll();
});
VideosDirectives.directive('r2baseAddVideos', [
    function() {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/videos/r2base-add-video.html',
            replace: true,
            scope: {
                videosModel: '=',
                form: '=',
                hasEntity: '=',
            }
        };
    }
]);

VideosDirectives.directive('r2baseBtnAddVideo', [
    '$compile',
    function($compile) {
        return function(scope, element, attrs) {
            element.bind("click", function() {
                console.log('ADICIONANDO...');
                angular.element(document.getElementById('section-to-videos')).prepend($compile("<div data-r2base-video-collection></div>")(scope));
            });
        };
    }
]);

VideosDirectives.directive('r2basePopulateVideo', [
    '$compile',
    '_',
    function($compile, _) {
        return function(scope, element, attrs) {
            scope.$watch('hasEntity', function(newVal) {

                if (newVal) {
                    if(scope.videosModel.length > 0) {
                        _.each(scope.videosModel, function(video) {
                            angular.element(document.getElementById('section-to-videos')).prepend($compile("<div data-r2base-video-collection data-video-id='" + video.id +"' data-to-populate='true'></div>")(scope));
                        });
                    }
                }
            })

        };
    }
]);

VideosDirectives.directive('r2baseVideoCollection', [
    '_',
    function(_) {
        return {
            restrict: 'A',
            templateUrl: 'partials/shared/directives/videos/r2base-video-collection.html',
            replace: true,
            scope: true,
            link: function(scope, element, attrs) {

                if (attrs.toPopulate != undefined && attrs.toPopulate == 'true') {
                    scope.index = scope.videosModel.indexOf(_.findWhere(scope.videosModel, {id: Number(attrs.videoId)} ) );
                } else {
                    scope.videosModel.push({
                        address: null
                    });

                    scope.index = scope.videosModel.length - 1;
                }

                scope.removeElement = function () {
                    setTimeout(function () {
                        scope.$apply(function () {
                            scope.form['video_title['+scope.index+']'].$setValidity('required', true);
                            scope.form['video_address['+scope.index+']'].$setValidity('required', true);
                        });
                    }, 10);
                    
                    scope.videosModel.splice(scope.index, 1);

                    $(element).remove();

                }

                scope.$watchCollection('videosModel', function (_newCol, _oldCol, _scope) {

                    var element = _oldCol[_scope.index];
                    var newIndex = _newCol.indexOf(element);

                    if (newIndex !== scope.index) scope.index = newIndex;
                });
            }
        };
    }
]);