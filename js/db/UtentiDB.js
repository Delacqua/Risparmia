angular.module('blueAppDB')
.controller('UtentiDB', function($scope, $filter,$urls,$routeParams,$getDB) {

	$scope.page = 0;
	$scope.numeriPerPage = 20;

// 1 utenti privati - 2 utenti IVA
    if ($routeParams.quale == 1) {
        $getDB.async($urls.route + $urls.getAltri + "/" + $urls.utentePrivati).then(function(response) {
            $scope.utenti = response;
        });

    }

    if ($routeParams.quale == 2) {
        $getDB.async($urls.route + $urls.getAltri + "/" + $urls.utenteIva).then(function(response) {
            $scope.utenti = response;
        });

    }

//Tabella regione
    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.regione).then(function(response) {
            $scope.regioni = response;
    });


//Cambia pagina
    $scope.mudaPagina = function(qt) {
    	$scope.page = $scope.page + qt;
       	if ($scope.page<0) { $scope.page = 0}
    	if ($scope.page>Math.ceil($scope.utenti.length/$scope.numeriPerPage)-1) { $scope.page = Math.ceil($scope.utenti.length/$scope.numeriPerPage)-1}
    }

//Prende index della pagina attuale
    $scope.aggiornaIndex = function(obj){
        $scope.index = $scope.utenti.indexOf(obj);
    }  


//Cambia ordine della tabella 
    $scope.sortType     = 'data'; // Ordine iniziale 
    $scope.sortReverse  = true;  // Dal più piccolo al più grande

    $scope.ordine = function(nome) {
	    if ($scope.sortType == nome) {
	        $scope.sortReverse = !$scope.sortReverse;
	      }
	    $scope.sortType = nome;
    }

});