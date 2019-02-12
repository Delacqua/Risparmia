angular.module("blueAppDB")
.controller("AziendeLuceDB", function($scope, $filter, $routeParams, $location, $urls, $getDB, $deleteDB) {

    $scope.page = 0;
    $scope.numeriPerPage = 30;

    $scope.mensaggioDB = "";

    switch ($routeParams.quale) {
                case '1':
                    var tabella = $urls.aluce;
                    break;
                case '2':
                    var tabella = $urls.aluceI;
                    break;
                case '3':
                    var tabella = $urls.aluceD;
                    break;
                case '4':
                    var tabella = $urls.aluceID;
                    break;
                default:

        }


    $getDB.async($urls.route + $urls.getAziende + '/' + tabella).then(function(response) {
            $scope.todos = response;
    });

	//Aggiunge
    $scope.aggiunge = function(){
        $location.path('/aggiorna/' + "nuovo" + "/" + tabella);
    }  

	//Aggiorna
    $scope.aggiorna = function(obj){
        var index = $scope.todos.indexOf(obj);  //Prende index dell'oggeto
        $location.path('/aggiorna/' + index + "/" + tabella);
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
        $location.path('/imposte/'+ tabella);
    }

    //Cambia pagina
    $scope.mudaPagina = function(qt) {
        $scope.page = $scope.page + qt;
        if ($scope.page<0) { $scope.page = 0}
        if ($scope.page>Math.ceil($scope.todos.length/$scope.numeriPerPage)-1) { $scope.page = Math.ceil($scope.todos.length/$scope.numeriPerPage)-1}
    }


});