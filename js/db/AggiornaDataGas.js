angular.module("blueAppDB")
.controller("AggiornaDataGas", function($scope, $filter, $routeParams,$location,$urls, $urlsGas, $getDB, $postDB, $putDB, $deleteDB) {

    $scope.selectionServ = []; //Elenco dei servizi selezionati
    $scope.selectionFat = []; //Elenco dei pagamenti selezionati
    $scope.selectionReg = []; //Elenco dei regioni selezionati
    $scope.ricerca = {};
    $scope.addon = false;
    $scope.nuovoServizo;
    $scope.nuovoFatturazione;

    $scope.tServiziagg = $urls.servizi;
    $scope.tFatturazione = $urls.fatturazione;


    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.regione).then(function(response) {
        $scope.regioni = response;
    });
    
    // Array servizi
    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.servizi).then(function(response) {
        $scope.serv = response;
    });

    //Array fatturazione
    $getDB.async($urls.route + $urls.getAltri + '/'+ $urls.fatturazione).then(function(response) {
        $scope.fatt = response;
    });

    //Array Gruppo delle reggione 
    $getDB.async($urls.route + $urls.getAltri + '/' + $urlsGas.regioneGas).then(function(response) {
            $scope.regioneGas = response;
    });


//Check if is new or update
    $scope.vecchio = {};

    if ($routeParams.id !== "nuovo" && !angular.isUndefined($routeParams.id)) {

        $getDB.async($urls.route + $urls.getAziende + '/' + $routeParams.dove).then(function(response) {
            $scope.vecchio = response[$routeParams.id];
            // Selected Servizi Aggiuntti
            $scope.selectionServ = $scope.vecchio.serviziAgg;
            // Selected fatturazione
            $scope.selectionFat = $scope.vecchio.fatturazione;
            // Selected Regioni 
            $scope.selectionReg = $scope.vecchio.regione;

            //Cambia il valore da string a float
            $scope.vecchio = angular.parseItemToFloat($scope.vecchio);
        });
 
    }


    //converte string (da json) in float
    $scope.parse= function(number){
        return parseFloat(number);
    }

  // Memorizza Servizi Aggiuntivi / Fatturazione
    $scope.toggleSelection = function(arrayS, servizo) {
        var idx = arrayS.indexOf(servizo);

        // gia selezionato
        if (idx > -1) {
          arrayS.splice(idx, 1);
        }

        // nuovo
        else {
          arrayS.push(servizo);
        }
    };


//Apre e chiude Servizi
    $scope.openServ = function(){
        $scope.addon = !$scope.addon;
    }

//remove service/ fatt
    $scope.removeItem = function(type, item) {

        //var data = {tabella: type, item: item.id};
        var data = {params: {tabella: type}};

        $deleteDB.async($urls.route + $urls.serviziUrl +'/'+ item.id, data).then(function(response) {
            if (type == $urls.servizi) {
                var indice = $scope.serv.indexOf(item);
                $scope.serv.splice(indice, 1);
            }
            if (type == $urls.fatturazione) {
                var indice = $scope.serv.indexOf(item);
                $scope.fatt.splice(indice, 1);
            }
        });

    }

//Aggiunge serv / fatt
    $scope.aggiungeItem = function (type, item) {
        var data = {tabella: type, item: item};

        $putDB.async($urls.route + $urls.serviziUrl, data).then(function(response) {
            if(type == $urls.servizi) {
                var nuovoItem = {id:response.id,serviziagg:item};
                $scope.nuovoServizo = "";
                $scope.serv.push(nuovoItem);
            }
            if(type == $urls.fatturazione) {
                var nuovoItem = {id:response.id,fatturazione:item};
                $scope.nuovoFatturazione = "";
                $scope.fatt.push(nuovoItem);
            }
        });

    }

    $scope.ritorna = function() {
        switch ($routeParams.dove) {
            case $urlsGas.agas:
                $location.path('/agas/1');
                break;
            case $urlsGas.agasI:
                $location.path('/agas/2');
                break;
            case $urlsGas.agasD:
                $location.path('/agas/3');
                break;
            case $urlsGas.agasID:
                $location.path('/agas/4');
                break;
            default:
        }

    }


// Send form to php
    $scope.submitForm = function(obj) {
        obj.serviziAgg = $scope.selectionServ;
        obj.fatturazione = $scope.selectionFat;
        obj.regione = $scope.selectionReg;


        if (obj.id) {
            // Aggiorna il registro
            var data = {tabella: $routeParams.dove, item: obj};
            
            $postDB.async($urls.route + $urls.updateAzienda, data).then(function(response) {
                $scope.ritorna();
            });

        }

            else {
                // Aggiunge un nuovo registro
                obj.energiaVariabile = angular.objToArray(obj.energiaVariabile);
                obj.transportoVariabile = angular.objToArray(obj.transportoVariabile);

                var data = {tabella: $routeParams.dove, item: obj};

                $putDB.async($urls.route + $urls.updateAzienda, data).then(function(response) {
                    $scope.ritorna();
                });

            }


    };

    angular.objToArray = function (obj) {
        var array = [];
        for(var key in obj){
            if(!obj.hasOwnProperty(key)){
                continue;
            }
            array.push(obj[key])
        }

        return array;
    }

    angular.stringToFloat = function(item) {
        if (angular.isArray(item)) {
            var itemR = [];

            angular.forEach(item, function(value, key) {
                itemR.push(parseFloat(value));
            });

            item = itemR;
        }

        if (!angular.isArray(item)) {
            item  = parseFloat(item);
        }

        return item;
    }

    angular.parseItemToFloat = function(obj) {
        obj.prezzo = angular.stringToFloat(obj.prezzo);

        obj.prezzoMateria = angular.stringToFloat(obj.prezzoMateria);

        obj.transporto = angular.stringToFloat(obj.transporto);
        obj.stoccaggio = angular.stringToFloat(obj.stoccaggio);

        obj.tasseFise = angular.stringToFloat(obj.tasseFise);

        return obj;
    }

});