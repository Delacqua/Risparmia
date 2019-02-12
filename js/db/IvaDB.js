angular.module('blueAppDB')
.controller('IvaDB', function($scope, $http, $filter, $routeParams, $urls, $getDB, $postDB) {

    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.utenteIva).then(function(response) {
            $scope.utenteAggiorna = response[$routeParams.id];
            $scope.utenteAggiorna.telefono =  parseInt($scope.utenteAggiorna.telefono);
            $scope.utenteAggiorna.display =  parseInt($scope.utenteAggiorna.display);
    });

/*
        $http.get($urls.route + $urls.utenti + '/' + $urls.utenteIva).then (
            function(response){
                $scope.utenteAggiorna = response.data[$routeParams.id];
                $scope.utenteAggiorna.telefono =  parseInt($scope.utenteAggiorna.telefono);
                $scope.utenteAggiorna.display =  parseInt($scope.utenteAggiorna.display);
            }, 
            function(response){
                 console.log("Erro Utente: " + response);
               }

        );

*/

    $scope.aggiorna = function(obj) {
        $postDB.async($urls.route + $urls.utenti + '/' + $urls.utenteIva, obj).then(function(response) {
        });

/*        
    	$http.post($urls.route + $urls.utenti + '/' + $urls.utenteIva, obj).then (
            function(response){
            }, 
            function(response){
                 console.log("Erro Aggiornamento: " + response);
            }

        );
*/

    }


})
.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});