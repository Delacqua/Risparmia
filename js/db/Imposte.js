angular.module('blueAppDB')
.controller('Imposte', function($scope, $filter, $urls, $urlsGas, $routeParams, $location, $getDB, $postDB, $putDB, $deleteDB) {

	$scope.nuovaTassa = {};
	$scope.nuovaAccisa = {};
    $scope.tabellaAccisa =  $urls.accisa;
    
    switch ($routeParams.dove) {
            case $urls.aluce:
            case $urls.aluceI:
            case $urls.aluceD:
            case $urls.aluceID:
                $scope.tabellaIva =  $urls.iva;
                $scope.tabellaAltritasse =  $urls.altritasse;
                break;
            case $urlsGas.agas:
            case $urlsGas.agasI:
            case $urlsGas.agasD:
            case $urlsGas.agasID:
                $scope.tabellaIva =  $urlsGas.ivaGas;
                $scope.tabellaAltritasse =  $urlsGas.altriTasseGas;
                break;
        }



/*    if () {}
    $scope.tabellaIva =  $urls.iva;
    $scope.tabellaAltritasse =  $urls.altritasse;
*/

    $getDB.async($urls.route + $urls.getAltri + '/' + $scope.tabellaIva).then(function(response) {
            $scope.todosIva = response;
    });

    $getDB.async($urls.route + $urls.getAltri + '/' + $scope.tabellaAltritasse).then(function(response) {
            $scope.todosTasse = response;
    });
    
    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.accisa).then(function(response) {
            $scope.todosAccisa = response;
    });




//converte string (da json) in float
    $scope.parse= function(number){
    	return parseFloat(number);
    }

//aggiorna Tasse
    $scope.aggiornaTasse = function (type,item,valore) {
    	item.valore = valore;

    	var data = {tabella: type, item: item};

        $putDB.async($urls.route + $urls.getImposte, data).then(function(response) {
        });

    }

//Aggiunge Tasse
    $scope.aggiungeTasse = function (type, item) {
    	var data = {tabella: type, item: item};

        $postDB.async($urls.route + $urls.getImposte, data).then(function(response) {
            if(type == $scope.tabellaAltritasse) {
                    var nuovoItem = {id:response.id,nome:item.nome,valore:item.valore};
                    $scope.todosTasse.push(nuovoItem);
                    $scope.nuovaTassa.nome = "";
                    $scope.nuovaTassa.valore = "";
                }
            if(type == $urls.accisa) {
                var nuovoItem = {id:response.id,fascia:item.fascia};
                $scope.todosAccisa.push(nuovoItem);
                $scope.nuovaAccisa.fascia = "";
            }

        });

    }


//Delete Tasse
    $scope.removeTasse = function (type, item) {

        var data = {params: {tabella: type}};

        $deleteDB.async($urls.route + $urls.getImposte +'/'+ item.id, data).then(function(response) {
            if (type == $scope.tabellaAltritasse) {
                    var indice = $scope.todosTasse.indexOf(item);
                    $scope.todosTasse.splice(indice, 1);
                }
            if (type == $urls.accisa) {
                var indice = $scope.todosAccisa.indexOf(item);
                $scope.todosAccisa.splice(indice, 1);
            }
        });

    }

//Ritorno 
    $scope.ritorna = function() {
        //Luce
        if ($routeParams.dove === $urls.aluce) { $location.path('/aluce/'+ 1); }
        if ($routeParams.dove === $urls.aluceI) { $location.path('/aluce/'+ 3); }
        if ($routeParams.dove === $urls.aluceD) { $location.path('/aluce/'+ 1); }
        if ($routeParams.dove === $urls.aluceID) { $location.path('/aluce/'+ 4); }
    
        //Gas
        if ($routeParams.dove === $urlsGas.agas) { $location.path('/agas/'+ 1); }
        if ($routeParams.dove === $urlsGas.agasI) { $location.path('/agas/'+ 3); }
        if ($routeParams.dove === $urlsGas.agasD) { $location.path('/agas/'+ 1); }
        if ($routeParams.dove === $urlsGas.agasID) { $location.path('/agas/'+ 4); }
    }


});