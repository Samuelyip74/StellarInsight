/**
 * Created by chenqk on 2018/6/6.
 */


    angular.module('main')
        .factory('mainService', mainService);
    mainService.$inject = ['$http','$q','$window'];

    function mainService($http,$q,$window) {

        var service = {
            getLdapAuthForAP:getLdapAuthForAP
        };
        function getLdapAuthForAP(data){
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "https://cportal.al-enterprise.com/cgi-bin/ldap_auth.cgi");
            form.setAttribute("target", "_self");
            var name = document.createElement("input");
            name.setAttribute("type", "hidden");
            name.setAttribute("name", "username");
            name.setAttribute("value", data.username);
            var password = document.createElement("input");
            password.setAttribute("type", "hidden");
            password.setAttribute("name", "password");
            password.setAttribute("value", data.password);
            form.appendChild(name);
            form.appendChild(password);
            document.body.appendChild(form);
            $window.open('', '_self');
            form.submit();
            }
        return service;
    }
