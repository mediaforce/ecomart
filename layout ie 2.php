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