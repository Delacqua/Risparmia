angular.module('blueAppDB')
.controller('Imposte', function($scope, $http, $filter) {

	$scope.nuovaTassa = {};
	$scope.nuovaAccisa = {};


    $http.get('../php/imposte.php').then (
        function(response){
             $scope.todosAccisa = response.data.accisa;
             $scope.todosIva = response.data.iva;
             $scope.todosTasse = response.data.altritasse;
        }, 
        function(response){
            console.log("Erro: "+response);
        }
    );

    //converte string (da json) in float
    $scope.parse= function(number){
    	return parseFloat(number);
    }

//aggiorna Tasse
    $scope.aggiornaTasse = function (type,item,valore) {
    	item.valore = valore;

    	var data = {tabella: type, item: item};

    	$http.put('../php/imposte.php', data) .then (
            function(response){
                  
            }, 
            function(response){
                 console.log("Erro: " +  response);
            }

        );


    }

//Aggiunge Tasse
    $scope.aggiungeTasse = function (type, item) {
    	var data = {tabella: type, item: item};

    	$http.post('../php/imposte.php', data) .then (
    		function(response){
            	if(type == "altritasse") {
            		var nuovoItem = {id:response.data.id,nome:item.nome,valore:item.valore};
            		$scope.todosTasse.push(nuovoItem);
                    $scope.nuovaTassa.nome = "";
                    $scope.nuovaTassa.valore = "";
                }
                if(type == "accisa") {
                    var nuovoItem = {id:response.data.id,fascia:item.fascia};
                    $scope.todosAccisa.push(nuovoItem);
                    $scope.nuovaAccisa.fascia = "";
                }    			
                 
            },
            function(response){
               console.log("Erro: " +  response);
            }

    	);

    }


//Delete Tasse
    $scope.removeTasse = function (type, item) {

    	var data = {tabella: type, item: item};

    	$http.delete('../php/imposte.php/'+ JSON.stringify(data)) .then (
    		function(response){
    			if (type == "altritasse") {
                    var indice = $scope.todosTasse.indexOf(item);
                    $scope.todosTasse.splice(indice, 1);
                }
                if (type == "accisa") {
                    var indice = $scope.todosAccisa.indexOf(item);
                    $scope.todosAccisa.splice(indice, 1);
                }
                 
            },
            function(response){
               console.log("Erro: " +  response);
            }

    	);

    }


});