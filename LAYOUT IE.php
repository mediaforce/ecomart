<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/">
        <meta charset="utf-8">
        <?php echo $this->headTitle('Ecomart')->setSeparator(' - ')->setAutoEscape(false);?>
        <?php echo $this->headMeta()
        ->appendName('viewport', 'width=device-width, initial-scale=1.0')
        ->appendHttpEquiv('X-UA-Compatible', 'IE=edge')
        ;?>
        <!-- Base style -->
        <!-- build:css(public) /css/base.min.css -->
        <?php
        $this->headLink(array('rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => $this->basePath() . '/img/favicon.ico'))
        ->prependStylesheet($this->basePath('css/screen.css'), 'screen')
        ->prependStylesheet($this->basePath('css/print.css'), 'print');
        echo $this->headLink();
        $this->headLink()->exchangeArray(array());
        ?>
        <!-- endbuild -->
        <!-- Main style -->
        <!-- build:css(public) /css/main.min.css -->
        <?php
        $this->headLink()
        ->prependStylesheet($this->basePath('css/main.css'));
        echo $this->headLink();
        $this->headLink()->exchangeArray(array());
        ?>
        <!-- endbuild -->
        <!-- Third-Party styles -->
        <!-- build:css(public) /css/vendors.min.css -->
        <?php
        $this->headLink()
        ->prependStylesheet($this->basePath('bower_components/angular-block-ui/dist/angular-block-ui.css'))
        ->prependStylesheet($this->basePath('css/barousel.css'))
        ->prependStylesheet($this->basePath('css/easyzoom.css'))
        ->prependStylesheet($this->basePath('bower_components/ngFloatingLabels/src/ng-floating-labels.css'))
        ->prependStylesheet($this->basePath('css/angular-photo-slider.css'))
        ->prependStylesheet($this->basePath('bower_components/ng-dialog/css/ngDialog-theme-default.css'))
        ->prependStylesheet($this->basePath('bower_components/ng-dialog/css/ngDialog.css'))
        ->prependStylesheet($this->basePath('bower_components/angular-ui-notification/dist/angular-ui-notification.css'))
        ->prependStylesheet($this->basePath('bower_components/angular-loading-bar/build/loading-bar.css'));
        echo $this->headLink();
        $this->headLink()->exchangeArray(array());
        ?>
        <!-- endbuild -->
        <!-- Plugins Scripts -->
        <!-- build:js(public) /js/plugins.min.js -->
        <?php
        $this->headScript()
        ->prependFile($this->basePath('js/plugins/jquery.barousel.js'))
        ->prependFile($this->basePath('bower_components/ez-plus/src/jquery.ez-plus.js'))
        ->prependFile($this->basePath('js/plugins/jquery-imagefill.js'))
        ->prependFile($this->basePath('js/plugins/imagesloaded.pkgd.js'))
        ->prependFile($this->basePath('js/plugins/TweenMax.min.js'))
        ->prependFile($this->basePath('bower_components/string/dist/string.js'))
        ->prependFile($this->basePath('js/plugins/polyfiller.js'))
        ->prependFile($this->basePath('js/plugins/underscore.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.accordion.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.offcanvas.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.dropdownMenu.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.responsiveMenu.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.responsiveToggle.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.nest.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.keyboard.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.box.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.mediaQuery.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.motion.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.util.triggers.js'))
        ->prependFile($this->basePath('js/plugins/foundation/foundation.core.js'))
        ->prependFile($this->basePath('bower_components/foundation-sites/dist/foundation.js'))
        ->prependFile($this->basePath('js/plugins/jquery.sticky.js'))
        ->prependFile($this->basePath('bower_components/jquery/dist/jquery.js'));
        echo $this->headScript();
        $this->headScript()->exchangeArray(array());
        ?>
        <!-- endbuild -->
        <!-- Scripts Condicionais  -->
        <?php
        $this->headScript()
        ->prependFile($this->basePath('js/plugins/respond.js'), 'text/javascript', array('conditional' => 'lt IE 9'))
        ->prependFile($this->basePath('js/plugins/html5shiv.js'), 'text/javascript', array('conditional' => 'lt IE 9'));
        echo $this->headScript();
        $this->headScript()->exchangeArray(array());
        ?>
        <script src="https://www.youtube.com/iframe_api"></script>
        <script
        src="https://www.google.com/recaptcha/api.js?onload=vcRecaptchaApiLoaded&render=explicit"
        async defer
        ></script>
        
        <!-- Angular & Resources Scripts -->
        <!-- build:js(public) /js/angular-and-resources.min.js -->
        <?php
        $this->headScript()
        ->prependFile($this->basePath('bower_components/angular-smart-table/dist/smart-table.js'))
        ->prependFile($this->basePath('bower_components/angular-block-ui/dist/angular-block-ui.js'))
        ->prependFile($this->basePath('bower_components/angular-slugify/angular-slugify.js'))
        ->prependFile($this->basePath('bower_components/angular-credit-cards/release/angular-credit-cards.js'))
        ->prependFile($this->basePath('bower_components/angular-recaptcha/release/angular-recaptcha.js'))
        ->prependFile($this->basePath('bower_components/angular-youtube-embed/dist/angular-youtube-embed.min.js'))
        ->prependFile($this->basePath('bower_components/angular-ez-plus/js/angular-ezplus.js'))
        ->prependFile($this->basePath('bower_components/ngFloatingLabels/src/ngFloatingLabels.js'))
        ->prependFile($this->basePath('bower_components/ng-dialog/js/ngDialog.js'))
        ->prependFile($this->basePath('bower_components/ngCart/dist/ngCart.js'))
        ->prependFile($this->basePath('bower_components/angular-ui-notification/dist/angular-ui-notification.js'))
        ->prependFile($this->basePath('bower_components/angular-input-masks/angular-input-masks-standalone.js'))
        ->prependFile($this->basePath('bower_components/angular-i18n/angular-locale_pt-br.js'))
        ->prependFile($this->basePath('bower_components/angular-favicon/angular-favicon.js'))
        ->prependFile($this->basePath('bower_components/angular-messages/angular-messages.js'))
        ->prependFile($this->basePath('bower_components/angular-cookies/angular-cookies.js'))
        ->prependFile($this->basePath('bower_components/angular-ui-router/release/angular-ui-router.js'))
        ->prependFile($this->basePath('bower_components/angular-resource/angular-resource.js'))
        ->prependFile($this->basePath('bower_components/angular-breadcrumb/dist/angular-breadcrumb.js'))
        ->prependFile($this->basePath('bower_components/angular-touch/angular-touch.js'))
        ->prependFile($this->basePath('bower_components/angular-animate/angular-animate.js'))
        ->prependFile($this->basePath('bower_components/angular/angular.js'));
        echo $this->headScript();
        $this->headScript()->exchangeArray(array());
        ?>
        <!-- endbuild -->
    </head>
    <body>
<!--[if lt IE 11]>

            Este navegador não suporta este site!

<![endif]-->

<!--[if gte IE 11 | !IE ]><!-->
        NAVEGADOR OK

        <div id="loading-bar-container"></div>
        <!-- <div data-ng-cloak class="row">
            <div class="large-3 large-offset-9 columns"><div data-ng-translate-language-select></div></div>
        </div> -->
        <div data-ui-view="header"></div>
        <div data-ui-view="banner"></div>
        <div data-ui-view="sidebar_left"></div>
        <div data-ui-view="content"></div>
        <div data-ui-view="sidebar_right"></div>
        <div data-ui-view="footer"></div>
        <div data-ng-cloak data-ui-view="notification"></div>
        <script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js">
        </script>
        <!-- R2TurismoApp Scripts -->
        <!-- build:js(public) /js/R2AdminApp.min.js -->
        <?php
        echo $this->inlineScript()
        // Shared Modules
        ->appendFile($this->basePath('js/app/shared/auth/AuthModule.js'))
        ->appendFile($this->basePath('js/app/shared/auth/TrackerModule.js'))
        // Shared Plugins
        ->appendFile($this->basePath('js/app/shared/plugins/factories/underscore.js'))
        ->appendFile($this->basePath('js/app/shared/plugins/factories/string.js'))
        ->appendFile($this->basePath('js/app/shared/plugins/factories/PagSeguroDirectPayment.js'))
        // Shared Filters
        ->appendFile($this->basePath('js/app/shared/filters/StringFilters.js'))
        // Shared Directives
        ->appendFile($this->basePath('js/app/shared/directives/PluginsDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/DocumentsDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/SocialNetworksDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/EmailsDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/CreditCardsDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/TelephonesDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/AddressesDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/LaguageSelectDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/ValidationDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/InputDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/PersonDirectives.js'))
        ->appendFile($this->basePath('js/app/shared/directives/UsersDirectives.js'))
        // Shared Services
        ->appendFile($this->basePath('js/app/shared/services/BaseServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/UserServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/AclServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/LocaleServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/InventoriesServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/CheckoutServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/NotificationServices.js'))
        ->appendFile($this->basePath('js/app/shared/services/CouponServices.js'))
        // Site App
        ->appendFile($this->basePath('js/app/site/R2Site.js'))
        // Site Controllers
        ->appendFile($this->basePath('js/app/site/controllers/LayoutControllers.js'))
        ->appendFile($this->basePath('js/app/site/controllers/UsersControllers.js'))
        ->appendFile($this->basePath('js/app/site/controllers/StoresControllers.js'))
        ->appendFile($this->basePath('js/app/site/controllers/CheckoutControllers.js'));
        ?>
        <!-- endbuild -->
<![endif]-->
    </body>
</html>