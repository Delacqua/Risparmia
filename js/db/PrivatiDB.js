angular.module('blueAppDB')
.controller('PrivatiDB', function($scope, $filter, $routeParams, $urls, $getDB, $postDB) {


    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.utentePrivati).then(function(response) {
            $scope.utenteAggiorna = response[$routeParams.id];
            $scope.utenteAggiorna.telefono =  parseInt($scope.utenteAggiorna.telefono);
            $scope.utenteAggiorna.display =  parseInt($scope.utenteAggiorna.display);
    });


    $getDB.async($urls.route + $urls.getAziende + '/' + $urls.aluce).then(function(response) {
            $scope.fornitori = response;
    });


    $scope.aggiorna = function(obj) {
        $postDB.async($urls.route + $urls.utenti + '/' + $urls.utentePrivati, obj).then(function(response) {
        });
    }


})

.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});