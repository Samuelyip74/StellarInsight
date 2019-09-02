/**
 * Created by chenqk on 2018/6/6.
 */
/**
 * Created by chenqk on 2018/6/6.
 */

    angular.module('main')
        .controller("facebookLoginController",function ($scope, $translate, $http,mainActionService,socialLoginService,$window) {
            var vm = this;
            vm.welcome_logo = welcome_logo;
            vm.backToLogin = function(){
                $window.history.back();
            }
            vm.reqiredAttributes = reqiredAttributes;
            vm.selectEmployEmail = '@han-networks.com';
            mainActionService.decorator(vm,$scope);
            var useragent = $window.navigator.userAgent;
            var rules = ['WebView','(iPod|iPad)(?!.*Safari\/)','Android.*(wv|\.0\.0\.0)'];
            var regex = new RegExp(rules.join('|'), 'ig');
            var  webview =  Boolean(useragent.match(regex));
            if(webview){
                vm.action.openDialog(true,"The built in popup client on this device does not support opening social login URL. Recommend to disable the 'Auto-join' or 'Use without internet' setting on the connection service, them open standard browser and access the internet!.");
            }else {
                socialLoginService.initFB(facebookID,vm,$scope);
            }
        });
