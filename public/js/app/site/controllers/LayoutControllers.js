'use strict';
R2Site.controller('HeaderCtrl', [
    '$scope',
    'ngDialog',
    'StoresFactory',
    'AuthService',
    '$state',
    'Slug',
    'blockUI',
    '$rootScope',
    function (
        $scope,
        ngDialog,
        StoresFactory,
        AuthService,
        $state,
        Slug,
        blockUI,
        $rootScope
        ) {
        blockUI.start();
        $scope.badNavigator = false;
        $rootScope.$on('badNavigator', function (event, next, current) {
            $scope.badNavigator = true;
        })
        $scope.userLogged = false;
        $scope.searchProduct = '';
        if (AuthService.isAuthenticated()) {
            $scope.userLogged = true;
            $scope.userName = AuthService.getUserName();
        }
        $scope.loginShow = function () {
            ngDialog.openConfirm({
                template: '/partials/site/pages/user/login/form.html',
                controller: 'LoginCtrl',
                className: 'ngdialog-theme-default',
                closeByEscape: true, // Assuming you want the same closing abilities.
                closeByDocument: true
            }).then(function(value) {
                console.log('VALUE', value);
            }).catch(function(value) {
                console.log('CATCH', value);
            });
        };
        $scope.logout = function() {
            AuthService.logout();
            $state.go('root', {}, {
                reload: true
            });
        };
        $scope.searchProducts = function () {
            console.log('PROCURAR POR', $scope.searchProduct);
            $state.go('root.searchProducts', {search: $scope.searchProduct});
        }
        $scope.storesDeptLimpeza = [];
        $scope.storesDeptEletro = [];
        $scope.storesDeptFerram = [];
        $scope.storesDeptPecas = [];
        $scope.storeDetailLimpeza = {};
        $scope.storeDetailEletro = {};
        $scope.storeDetailFerram = {};
        $scope.storeDetailPecas = {};
        $scope.selectStoreDetailLancamento = function (store) {
            store.slug = Slug.slugify(store.product.title);
            $scope.storeDetailLancamento = store;
        }
        $scope.selectStoreDetailLimpeza = function (store) {
            store.slug = Slug.slugify(store.product.title);
            $scope.storeDetailLimpeza = store;
        }
        $scope.selectStoreDetailEletro = function (store) {
            store.slug = Slug.slugify(store.product.title);
            $scope.storeDetailEletro = store;
        }
        $scope.selectStoreDetailFerram = function (store) {
            store.slug = Slug.slugify(store.product.title);
            $scope.storeDetailFerram = store;
        }
        $scope.selectStoreDetailPecas = function (store) {
            store.slug = Slug.slugify(store.product.title);
            $scope.storeDetailPecas = store;
        }
        function getImgCover (images) {
            var cover = _.find(images, function(image) {
                if (image.isCover) return true;
            });
            return cover;
        }
        StoresFactory.show(function(result) {
            console.log('STORES FACTORY HEADER LAYOUT', result);
            if (result.success) {
                var i = 0;
                var limit = 5;
                $scope.storesDeptLimpeza = _.filter(result.data, function (store) {
                    if (store.product.department.name === "ROBÔS DE LIMPEZA" && i < limit) {
                        if (i == 0) {
                            store.slug = Slug.slugify(store.product.title);
                            $scope.storeDetailLimpeza = store;
                        }
                        i++;
                        store.cover = getImgCover(store.product.images);
                        return true;
                    }
                });
                var i = 0;
                $scope.storesDeptLancamento = _.filter(result.data, function (store) {
                    if (store.product.isLaunch !== undefined && i < limit) {
                        if (store.product.isLaunch) {
                            if (i == 0) {
                                store.slug = Slug.slugify(store.product.title);
                                $scope.storeDetailLancamento = store;
                            }
                            i++;
                            store.cover = getImgCover(store.product.images);
                            return true;
                        }
                    }
                });
                i = 0;
                $scope.storesDeptEletro = _.filter(result.data, function (store) {
                    if (store.product.department.name === "ELETRODOMÉSTICOS" && i < 3) {
                        if (i == 0) {
                            store.slug = Slug.slugify(store.product.title);
                            $scope.storeDetailEletro = store;
                        }
                        i++;
                        store.cover = getImgCover(store.product.images);
                        return true;
                    }
                });
                i = 0;
                $scope.storesDeptFerram = _.filter(result.data, function (store) {
                    if (store.product.department.name === "FERRAMENTAS" && i < limit) {
                        if (i == 0) {
                            store.slug = Slug.slugify(store.product.title);
                            $scope.storeDetailFerram = store;
                        }
                        i++;
                        store.cover = getImgCover(store.product.images);
                        return true;
                    }
                });
                i = 0;
                $scope.storesDeptPecas = _.filter(result.data, function (store) {
                    if (store.product.department.name === "PEÇAS DE REPOSIÇÃO" && i < limit) {
                        if (i == 0) {
                            store.slug = Slug.slugify(store.product.title);
                            $scope.storeDetailPecas = store;
                        }
                        i++;
                        store.cover = getImgCover(store.product.images);
                        return true;
                    }
                });
            }
            blockUI.stop();
        });
    }
]);
'use strict';
R2Site.controller('HomeCtrl', [
    '$scope',
    'StoresFactory',
    'Slug',
    'blockUI',
    function (
        $scope,
        StoresFactory,
        Slug,
        blockUI
        ) {
        blockUI.start();
        $scope.storesHighlighted = [];
        $scope.storesSoldMore = [];
        StoresFactory.show({toSell:true}, function(result) {
            console.log('STORES FACTORY HOME LAYOUT', result);
            if (result.success) {
                console.log('RESULT', result);
                 result.data = _.reject(result.data, function (store) {
                    store.slug = Slug.slugify(store.product.title);
                    if(store.sellDiscountPrice) {
                        store.price = store.unitDiscountPrice;
                    } else {
                        store.price = store.unitPrice;
                    }
                    if (store.product.department.name === "PEÇAS DE REPOSIÇÃO") {
                        return true;
                    }
                });
                var qtdeHL = 4;
                var listHL = _.filter(result.data, function(store) {
                    store.slug = Slug.slugify(store.product.title);
                    if (store.product.isHighlighted) {
                        return true;
                    }
                });
                for (var i = 0; i < qtdeHL; i++) {
                    $scope.storesHighlighted[i] = listHL[i];
                    var cover = _.find(listHL[i].product.images, function(image) {
                        if (image.isCover) return true;
                    });
                    $scope.storesHighlighted[i].cover = cover;
                    result.data = _.reject(result.data, function(store) {
                        return $scope.storesHighlighted[i].id === store.id;
                    })
                }
                var qtdeSM = 4;
                var listSM = _.filter(result.data, function(store) {
                    store.slug = Slug.slugify(store.product.title);
                    return true;
                });
                for (var i = 0; i < qtdeSM; i++) {
                    $scope.storesSoldMore[i] = listSM[i];
                    var cover = _.find(listSM[i].product.images, function(image) {
                        if (image.isCover) return true;
                    });
                    $scope.storesSoldMore[i].cover = cover;
                    result.data = _.reject(result.data, function(store) {
                        return $scope.storesSoldMore[i].id === store.id;
                    });
                }
            }
            blockUI.stop();
        });
    }
]);
R2Site
.controller('BannerCtrl', [
    '$scope',
    '$timeout',
    function ($scope, $timeout) {
        var INTERVAL = 7000;
        $scope.slides = [
            {image: '/img/banners/banner-04.jpg', description: 'Imagem 1'},
            {image: '/img/banners/banner-05.jpg', description: 'Imagem 2'},
            {image: '/img/banners/banner-06.jpg', description: 'Imagem 3'},
            {image: '/img/banners/banner-07.jpg', description: 'Imagem 4'},
        ];
        $scope.direction = 'left';
        $scope.currentIndex = 0;
        $scope.setCurrentSlideIndex = function (index) {
            $scope.direction = (index > $scope.currentIndex) ? 'left' : 'right';
            $scope.currentIndex = index;
        };
        $scope.isCurrentSlideIndex = function (index) {
            return $scope.currentIndex === index;
        };
        $scope.prevSlide = function () {
            $scope.direction = 'left';
            $scope.currentIndex = ($scope.currentIndex < $scope.slides.length - 1) ? ++$scope.currentIndex : 0;
        };
        $scope.nextSlide = function () {
            $scope.direction = 'right';
            $scope.currentIndex = ($scope.currentIndex > 0) ? --$scope.currentIndex : $scope.slides.length - 1;
            //$timeout($scope.nextSlide, INTERVAL);
        };
        $timeout($scope.nextSlide, INTERVAL);
    }
])
.animation('.slide-animation', function () {
    return {
        beforeAddClass: function (element, className, done) {
            var scope = element.scope();
            if (className == 'ng-hide') {
                var finishPoint = element.parent().width();
                console.log('ELEM IMG', element.context.currentSrc);
                if(scope.direction !== 'right') {
                    finishPoint = -finishPoint;
                }
                TweenMax.to(element, 1, {left: finishPoint, onComplete: done, ease: Power2.easeInOut, opacity:0});
            }
            else {
                done();
            }
        },
        removeClass: function (element, className, done) {
            var scope = element.scope();
            if (className == 'ng-hide') {
                element.removeClass('ng-hide');
                var startPoint = element.parent().width();
                if(scope.direction === 'right') {
                    startPoint = -startPoint;
                }
                TweenMax.fromTo(element, 1, { left: startPoint, ease: Power2.easeInOut}, {left: 0, onComplete: done, opacity:1 });
            }
            else {
                done();
            }
        }
    };
});