/**
 * Created by chenqk on 2018/6/6.
 */
/**
 * Created by chenqk on 2018/6/6.
 */

    angular.module('main')
        .controller("googleLoginController",function ($scope, $translate, $http,mainActionService,socialLoginService,$window) {
            var vm = this;
            vm.welcome_logo = welcome_logo;
            mainActionService.decorator(vm,$scope);
            var googleId = googleID;
            var useragent = $window.navigator.userAgent;
            var rules = ['WebView','(iPhone|iPod|iPad)(?!.*Safari\/)','Android.*(wv|\.0\.0\.0)'];
            var regex = new RegExp(rules.join('|'), 'ig');
            var  webview =  Boolean(useragent.match(regex));
            if(webview){
                vm.action.openDialog(true,"The built in popup client on this device does not support opening social login URL. Recommend to disable the 'Auto-join' or 'Use without internet' setting on the connection service, them open standard browser and access the internet!.");
            }else {
                socialLoginService.initGoogle(googleId, vm, $scope);
            }
        });
