/**
 * Created by chenqk on 2018/6/6.
 */
/**
 * Created by chenqk on 2018/6/6.
 */

angular.module('main')
    .controller("registerController", function ($window,$scope, $translate, $http, mainActionService) {
        var vm = this;
        vm.welcomeLinkedURL = welcomeLinkedURL;
        vm.successLinkedURL = successLinkedURL;
        vm.welcome_logo = welcome_logo;
        vm.success_logo = success_logo;
        vm.welcome_portal_video_1 = welcome_portal_video_1;
        vm.success_portal_video_1 = success_portal_video_1;
        vm.locationEnable = locationEnable;
        vm.locationList = locationList;
        vm.successNotification = successNotification;
        vm.myInterval = 2000;
        vm.noWrapSlides = false;
        vm.welcome_portal_broadcast_1 = welcome_portal_broadcast_1;
	vm.authorizeVerificationCode = authorizeVerificationCode;
	vm.emailRestriction = emailRestriction;
        vm.backToLogin = function () {
            $window.history.back();
        }
        vm.reqiredAttributes = reqiredAttributes;
        vm.selectEmployEmail = allowedEmailSuffix.length > 0 ? allowedEmailSuffix[0] : "";
        vm.allowedEmailSuffix = allowedEmailSuffix;
        mainActionService.decorator(vm, $scope);
    });
