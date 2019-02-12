angular.module('blueApp', ['diretiva','ngSanitize','ngAnimate','ui.bootstrap','ngRoute','ngCookies','blueAppUrls'])
.run(function($rootScope) {
    $rootScope.datiConsumo = null;
})
.config(function($locationProvider, $routeProvider) {
//    $locationProvider.html5Mode(true);
    $routeProvider
    .when("/", {
        templateUrl : "main.html",
        controller : "Anteprima",
    })
    .when("/main", {
        templateUrl : "main.html",
        controller : "Anteprima"
    })
    .when("/luce", {
        templateUrl : "anteprima.html",
        controller : "Anteprima"
    })
    .when("/gas", {
        templateUrl : "anteprima.html",
        controller : "Anteprima"
    })
    .when("/confronta/:tipo", {
        templateUrl : "confronta.html",
        controller : "Confronta"
    })
    .when("/fornitori", {
        templateUrl : "fornitori.html",
        controller : "TableForn"
    })
    .when("/fornitoriGas", {
        templateUrl : "fornitori.html",
        controller : "TableFornGas"
    })
    .when("/risparmia", {
        templateUrl : "risparmia.html",
        controller : "Risparmia"
    })
    .when("/privacy", {
        templateUrl : "privacy.html"
    })
    .when("/luceF", {
        templateUrl : "luceF.html",
        controller : "Luce"
    })
    .otherwise({
        redirectTo: "/",
        controller : "TableForn"
    });

});