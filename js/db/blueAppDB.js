angular.module('blueAppDB', ['ngRoute','diretivaDB','blueAppUrls','ngSanitize'])
.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "main.html",
        controller : "AggiornaDataLuce",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aluce/:quale", {
        templateUrl : "aluce.html",
        controller : "AziendeLuceDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/agas/:quale", {
        templateUrl : "agas.html",
        controller : "AziendeGasDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aggiorna/:id/:dove", {
        templateUrl : "aggiornaLuceDB.html",
        controller : "AggiornaDataLuce",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aggiornaGas/:id/:dove", {
        templateUrl : "aggiornaGasDB.html",
        controller : "AggiornaDataGas",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aggiunge/:id/:dove", {
        templateUrl : "aggiornaLuceDB.html",
        controller : "AggiornaDataLuce",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/imposte/:dove", {
        templateUrl : "imposteLuce.html",
        controller : "Imposte",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/imposteGas/:dove", {
        templateUrl : "imposteGas.html",
        controller : "Imposte",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/utenti/:quale", {
        templateUrl : "utenti.html",
        controller : "UtentiDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aggiornaUtenti/:id", {
        templateUrl : "aggiornaUtenti.html",
        controller : "PrivatiDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/utentiIva/:quale", {
        templateUrl : "utentiIva.html",
        controller : "UtentiDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/aggiornaIva/:id", {
        templateUrl : "aggiornaIva.html",
        controller : "IvaDB",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .when("/login", {
        templateUrl : "formLogin.php",
        resolve: { function(course,$location){ if (!course.getFunc().verifica) { $location.path("/login"); }; } }
    })
    .otherwise({
        redirectTo: '/'
    });

})

.filter('slice', function() {
  return function(arr, start, end) {
    return (arr || []).slice(start, end);
  };
});

