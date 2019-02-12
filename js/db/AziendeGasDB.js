angular.module("blueAppDB")
.controller("AziendeGasDB", function($scope, $filter, $routeParams, $location, $urls, $urlsGas, $getDB, $deleteDB) {

    $scope.page = 0;
    $scope.numeriPerPage = 30;

    $scope.mensaggioDB = "";

    switch ($routeParams.quale) {
                case '1':
                    var tabella = $urlsGas.agas;
                    break;
                case '2':
                    var tabella = $urlsGas.agasI;
                    break;
                case '3':
                    var tabella = $urlsGas.agasD;
                    break;
                case '4':
                    var tabella = $urlsGas.agasID;
                    break;
                default:

        }


    $getDB.async($urls.route + $urls.getAziende + '/' + tabella).then(function(response) {
            $scope.todos = response;
    });

	//Aggiunge
    $scope.aggiunge = function(){
        $location.path('/aggiornaGas/' + "nuovo" + "/" + tabella);
    }  

	//Aggiorna
    $scope.aggiorna = function(obj){
        var index = $scope.todos.indexOf(obj);  //Prende index dell'oggeto
        $location.path('/aggiornaGas/' + index + "/" + tabella);
    }  


	//Cancela il registro
    $scope.cancela = function(obj){
    	var data = {params: {tabella: tabella}};

        $deleteDB.async($urls.route + $urls.updateAzienda +'/'+ obj.id, data).then(function(response) {
            var indice = $scope.todos.indexOf(obj);
            $scope.todos.splice(indice, 1);
        });

        $scope.mensaggioDB = obj.nome + " - Cancellato correttamente "
   
    }

    $scope.editImposte = function (){
        $location.path('/imposteGas/'+ tabella);
    }


    //Cambia pagina
    $scope.mudaPagina = function(qt) {
        $scope.page = $scope.page + qt;
        if ($scope.page<0) { $scope.page = 0}
        if ($scope.page>Math.ceil($scope.todos.length/$scope.numeriPerPage)-1) { $scope.page = Math.ceil($scope.todos.length/$scope.numeriPerPage)-1}
    }


});