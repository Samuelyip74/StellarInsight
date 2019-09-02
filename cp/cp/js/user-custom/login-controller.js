/**
 * Created by chenqk on 2018/6/6.
 */
/**
 * Created by chenqk on 2018/6/6.
 */

angular.module('main')
    .controller("loginController", function ($window,$scope,$translate,$http,localStorageService,mainActionService,mainService,$timeout) {
        var vm = this;
        vm.loginBy = loginBy;
        vm.fixedURL = fixedURL;
        vm.successRedirect = successRedirect;
        vm.socialLogin = socialLogin;
        vm.facebookID = facebookID;
        vm.googleID = googleID;
        vm.selfRegistration = selfRegistration;
        vm.welcomeLinkedURL = welcomeLinkedURL;
        vm.successLinkedURL = successLinkedURL;
        vm.welcome_logo = welcome_logo;
        vm.success_logo = success_logo;
        vm.welcome_portal_video_1 = welcome_portal_video_1;
        vm.success_portal_video_1 = success_portal_video_1;
        vm.welcome_portal_video_preimg = welcome_portal_video_preimg;
        vm.portalServiceUrl = portalServiceUrl;
        var reqCount = 0;
        vm.myInterval = 2000;
        vm.noWrapSlides = false;
        vm.welcome_portal_broadcast_1 = welcome_portal_broadcast_1;
        vm.success_portal_broadcast_1 = success_portal_broadcast_1;

        mainActionService.decorator(vm,$scope);
        vm.action.login = function(){
            vm.block = true;
            rememberMe();
            if(useFor === "Guest"){
                vm.action.loginGuest();
            }else{
                vm.action.loginBYOD();
            }
        };

        function  rememberMe(){
            if(vm.rememberMe){
                localStorageService.set("username",vm.username);
                localStorageService.set("password",vm.password);
                localStorageService.set("rememberMe",vm.rememberMe);
            }else{
                localStorageService.remove("username");
                localStorageService.remove("password");
                localStorageService.remove("rememberMe");
            }
        }
        vm.action.loginGuest = function(){
            //guest login
            var addurl = location.href;
            var backurl = "";
            if(addurl.indexOf("backurl") > 0 ){
                backurl= getQueryString("backurl");
            }else{
                backurl = addurl.split("?")[1];
            }
            var guestcheck = true;
            var username = vm.username;
            if (username == "" || username == undefined || username == null) {
                username = "";
                guestcheck = false;
            }
            var password = vm.password;
            if (password == "" || password == undefined || password == null) {
                password = "";
                guestcheck = false;
            }
                var serviveLevel = vm.level;
                if (typeof (serviveLevel) == "undefined") {
                    serviveLevel = null;
            }
               var mac = getQueryString("mac");
               if (typeof (mac) == "undefined") {
                   mac = "";
                   guestcheck = false;
               }else if(mac == "" || mac == null){
                   guestcheck = false;
               }
            var userIp = getQueryString("ip");
            if (typeof (userIp) == "undefined") {
                userIp = "";
            }
            var url = getQueryString("url");
            if (typeof (url) == "undefined") {
                url = "";
            }
            var data = {
                username: username,
                password: password,
                userIp: userIp,
                strategyName: strategyInfo,
                useFor: "Guest",
                serviceLevel: serviveLevel,
                 mac: mac,
                url: url,
            };
            if(guestcheck==true){
                $http({
                    url: "/portal/api/ham/login/auth",
                    method: "POST",
                    data: data
                }).then(function(response){
                        if (response.data.errorCode == 0) {
                            vm.action.toSuccessPage(data,backurl,response)();
                            }
                        else if(response.data.errorMessage == "upam.alreadyPermissionAccessnetwork"){
                            vm.block = false;
                            reqCount > 0 ? vm.action.toSuccessPage(data,backurl,response)():vm.action.openDialog(true,response.data.errorMessage,false,vm.action.toSuccessPage(data,backurl,response));
                        }else{
                            vm.block = false;
                            vm.action.openDialog(true,$translate.instant(response.data.errorMessage));
        }
                    },function(resp){
                    reqCount++;
                    if(reqCount > 3){
                        vm.block = false;
                        vm.action.openDialog(true,$translate.instant("upam.confirmMsg.innerError"),true);
                        reqCount = 0;
                    }else{
                        $timeout(vm.action.loginGuest,2000);
                    }
                })
            }else if(guestcheck == false){
                vm.block = false;
                vm.action.openDialog(true,"upam.confirmMsg.verifyInformation");
            }
        };
        //取值的方法
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = $window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }
        //下线按钮触发的方法
        vm.action.logout = function() {
            vm.block = true;
            var social =  localStorageService.get('_login_provider');
               if(social){
                   social === "google" ? vm.action.logoutGoogle():vm.action.logoutFB();
               }else{
                   vm.action.logout2();
               }
        };
        //下线按钮触发的方法
        vm.action.logout2 = function() {
            var parm1 = getQueryString("mac");
            var parm2 = getQueryString("username");
            var parm3 = getQueryString("useFor");
            var addurlzhi = getQueryString("backurl");
            var data = {userMac: parm1, username: parm2, useFor: parm3};
            localStorageService.remove('_login_provider');
            $http({
                url: "/portal/api/ham/logoff/do",
                method: "POST",
                data: data
            }).then(function(resp){
                    if (resp.data.errorCode == 0) {
                        $window.location.href = "login.html?" + addurlzhi;
                    } else {
                        vm.action.openDialog(true,resp.data.errorMessage);
                    }
            },function(resp){
                reqCount++;
                if(reqCount > 3){
                    vm.block = false;
                    $window.location.href = "login.html?" + addurlzhi;
                    reqCount = 0;
                }else{
                    $timeout(vm.action.logout,2000);
                }
            });
        };
        /*terms & Condition*/
        vm.action.loginBuildIn = function () {
            vm.block = true;
            var username ="BuiltInAccount";
            var addurl = $window.location.href;
            var backurl = "";
            if(addurl.indexOf("backurl") > 0 ){
                backurl= getQueryString("backurl");
            }else{
                backurl = addurl.split("?")[1];
            }
            var buildcheck = true;
            var serviveLevel = vm.level || "";

            var mac = getQueryString("mac");
            if (typeof (mac) == "undefined") {
                mac = "";
                buildcheck = false;
            }else if(mac == "" || mac == null){
                buildcheck = false;
            }

            var userIp = getQueryString("ip");
            if (typeof (userIp) == "undefined") {
                userIp = "";
            }
            var url = getQueryString("url");
            if (typeof (url) == "undefined") {
                url = "";
            }
            var data = {
                userIp: userIp,
                strategyName: strategyInfo,
                useFor: "Guest",
                serviceLevel: serviveLevel,
                mac: mac,
                url: url,
                username:username
            };
            if(buildcheck == true){
                $http({
                    url: "/portal/api/ham/login/buildin",
                    method: "POST",
                    data: data
                }).then(
                    function (response) {
                        if (response.data.errorCode == 0) {
                            vm.action.toSuccessPage(data,backurl,response)();
                            }
                        else if(response.data.errorMessage == "upam.alreadyPermissionAccessnetwork"){
                            vm.block = false;
                            reqCount > 0 ? vm.action.toSuccessPage(data,backurl,response)():vm.action.openDialog(true,response.data.errorMessage,false,vm.action.toSuccessPage(data,backurl,response));
                        }else{
                            vm.block = false;
                            vm.action.openDialog(true,$translate.instant(response.data.errorMessage));
                        }
                    },function (resp) {
                        reqCount++;
                        if(reqCount > 3){
                        vm.block = false;
                            vm.action.openDialog(true,$translate.instant("upam.confirmMsg.innerError"),true);
                            reqCount = 0;
                        }else{
                            $timeout(vm.action.loginBuildIn,2000);
                        }
                    }
                );

            }else if(buildcheck == false){
                vm.block = false;
                vm.action.openDialog(true,"upam.confirmMsg.verifyInformation");
            }
        };
        vm.action.loginBYOD = function(){
                var byodcheck = true;
                var addurl = $window.location.href;
                var backurl = "";
                if(addurl.indexOf("backurl") > 0 ){
                    backurl= getQueryString("backurl");
                }else{
                    backurl = addurl.split("?")[1];
                }
                var username = vm.username;
                if (username == "" || username == undefined || username == null) {
                    username = "";
                    byodcheck = false;
                }
                var password = vm.password;
                if (password == "" || password == undefined || password == null) {
                    password = "";
                    byodcheck = false;
                }
                var mac = getQueryString("mac");
                if (typeof (mac) == "undefined") {
                    mac = "";
                    byodcheck = false;
                }else if(mac == "" || mac == null){
                    byodcheck = false;
                }

                var userIp = getQueryString("ip");
                if (typeof (userIp) == "undefined") {
                    userIp = "";
                }
                var url = getQueryString("url");
                if (typeof (url) == "undefined") {
                    url = "";
                }
                var data = {
                    username: username,
                    password: password,
                    userIp: userIp,
                    strategyName: strategyInfo,
                    useFor: "BYOD",
                    mac: mac,
                    url: url
                };

                if (byodcheck == true) {
                    if (!On_Premise_LDAP) {
                        $http({
                            url: "/portal/api/ham/login/auth",
                            method: "POST",
                            data: data
                        }).then(function (response) {
                            if (response.data.errorCode == 0) {
                            vm.action.toSuccessPage(data,backurl,response)();
                                }
                        else if(response.data.errorMessage == "upam.alreadyPermissionAccessnetwork"){
                            vm.block = false;
                            reqCount > 0 ? vm.action.toSuccessPage(data,backurl,response)():vm.action.openDialog(true,response.data.errorMessage,false,vm.action.toSuccessPage(data,backurl,response));
                        }else{
                                vm.block = false;
                                vm.action.openDialog(true, $translate.instant(response.data.errorMessage));
                            }
                        }, function (resp) {
                            reqCount++;
                            if (reqCount > 3) {
                                vm.block = false;
                                vm.action.openDialog(true, $translate.instant("upam.confirmMsg.innerError"), true);
                                reqCount = 0;
                            } else {
                                $timeout(vm.action.loginBYOD, 2000);
                            }
                        });
                    } else {
                        mainService.getLdapAuthForAP({username: username, password: password});
                    }
                } else if (byodcheck == false) {
                    vm.block = false;
                    vm.action.openDialog(true, "upam.confirmMsg.verifyInformation");
                }
            };
        vm.action.accessCode = function(){
                vm.block = true;
                var addurl = $window.location.href;
                var backurl = "";
                if(addurl.indexOf("backurl") > 0 ){
                    backurl= getQueryString("backurl");
                }else{
                    backurl = addurl.split("?")[1];
                }
                var guestcheck = true;
                var username =vm.accessCode;
                if (username == "" || username == undefined || username == null) {
                    username = "";
                    guestcheck = false;
                }
                var password = vm.accessCode;
                if (password == "" || password == undefined || password == null) {
                    password = "";
                    guestcheck = false;
                }
                var serviveLevel = vm.level;
                if (typeof (serviveLevel) == "undefined") {
                    serviveLevel = "";
                }
                var mac = getQueryString("mac");
                if (typeof (mac) == "undefined") {
                    mac = "";
                    guestcheck = false;
                }else if(mac == "" || mac == null){
                    guestcheck = false;
                }
                var userIp = getQueryString("ip");
                if (typeof (userIp) == "undefined") {
                    userIp = "";
                }
                var url = getQueryString("url");
                if (typeof (url) == "undefined") {
                    url = "";
                }
                var data = {
                    username: username,
                    password: password,
                    userIp: userIp,
                    strategyName: strategyInfo,
                    useFor: "Guest",
                    serviceLevel: serviveLevel,
                    mac: mac,
                    url: url
                };
                if(guestcheck == true){
                    $http({
                        url: "/portal/api/ham/login/auth",
                        method: "POST",
                        data: data
                    }).then(function(response){
                        if (response.data.errorCode == 0) {
                            vm.action.toSuccessPage(data,backurl,response)();
                            }
                        else if(response.data.errorMessage == "upam.alreadyPermissionAccessnetwork"){
                            vm.block = false;
                            reqCount > 0 ? vm.action.toSuccessPage(data,backurl,response)():vm.action.openDialog(true,response.data.errorMessage,false,vm.action.toSuccessPage(data,backurl,response));
                        }else{
                            vm.block = false;
                            vm.action.openDialog(true,$translate.instant(response.data.errorMessage));
                        }
                    },function (resp) {
                        reqCount++;
                        if(reqCount > 3){
                        vm.block = false;
                            vm.action.openDialog(true,$translate.instant("upam.confirmMsg.innerError"),true);
                            reqCount = 0;
                        }else{
                            $timeout(vm.action.accessCode,2000);
                        }
                    });
                   }else if(guestcheck == false){
                    vm.block = false;
                    vm.action.openDialog(true,response.data.errorMessage);
                }
        }

        vm.action.toSuccessPage = function(data,backurl,response){
            return function() {
                if (response.data.data !== null) {
                    $window.location.href = "success.html?mac=" + data.mac + "&username=" + data.username + "&useFor=" + data.useFor + "&backurl=" + backurl + "&fixandinit=" + response.data.data;
                }
                else {
                    $window.location.href = "success.html?mac=" + data.mac + "&username=" + data.username + "&useFor=" + data.useFor + "&backurl=" + backurl;
                }
            }
        };
        vm.action.logoutFB = function() {
            var  fbApiV = 'v3.1';
            var d = document, fbJs, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            fbJs = d.createElement('script');
            fbJs.id = id;
            fbJs.async = true;
            fbJs.src = "https://connect.facebook.net/en_US/sdk.js";
            fbJs.onload = function() {
                FB.init({
                    appId: facebookID,
                    status: true,
                    cookie: true,
                    xfbml: true,
                    version: fbApiV,
                    scope: 'email'
                });
                FB.getLoginStatus(function(response) {
                    if(response.status === "connected"){
                        FB.api("/me/permissions", "delete", vm.action.logout2);
                    }
                });
            };
            ref.parentNode.insertBefore(fbJs, ref);
        };

        vm.action.logoutGoogle = function(){
            var img = new Image();
            img.onload = img.onerror = function(){
                vm.action.logout2();
                $window.localStorage.removeItem('_login_provider');
            };
            img.src = "https://mail.google.com/mail/u/0/?logout&hl=en";
        };
        vm.action.goServicePortalPage = function () {
            window.open(vm.portalServiceUrl);
        };
    });
