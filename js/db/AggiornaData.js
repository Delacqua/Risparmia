angular.module("blueAppDB")
.controller("AggiornaData", function($scope, $filter, $routeParams,$location,$urls, $getDB, $postDB, $putDB, $deleteDB) {

    $scope.selectionServ = []; //Elenco dei servizi selezionati
    $scope.selectionFat = []; //Elenco dei pagamenti selezionati
    $scope.selectionReg = []; //Elenco dei regioni selezionati
    $scope.ricerca = {};
    $scope.addon = false;
    $scope.nuovoServizo;
    $scope.nuovoFatturazione;


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

    //Array Imposte
    $getDB.async($urls.route + $urls.getAltri + '/' + $urls.accisa).then(function(response) {
            $scope.accisa = response;
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
            case $urls.aluce:
                $location.path('/aluce/1');
                break;
            case $urls.aluceI:
                $location.path('/aluce/2');
                break;
            case $urls.aluceD:
                $location.path('/aluce/3');
                break;
            case $urls.aluceID:
                $location.path('/aluce/4');
                break;
            default:
        }

    }


// Send form to php
    $scope.submitForm = function(obj) {
        obj.serviziAgg = $scope.selectionServ;
        obj.fatturazione = $scope.selectionFat;
        obj.regione = $scope.selectionReg;
        obj.prezzo = parseFloat(obj.prezzo);


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
        obj.prezzo = angular.stringToFloat(obj.prezzo[0]);

        obj.f1 = angular.stringToFloat(obj.f1);
        obj.f2 = angular.stringToFloat(obj.f2);
        obj.f3 = angular.stringToFloat(obj.f3);

        obj.energiaCotaFissa = angular.stringToFloat(obj.energiaCotaFissa);
        obj.energiaPotenza = angular.stringToFloat(obj.energiaPotenza);

        obj.energiaVariabile = angular.stringToFloat(obj.energiaVariabile);
        obj.transportoVariabile = angular.stringToFloat(obj.transportoVariabile);

        obj.transportoCotaFissa =angular.stringToFloat(obj.transportoCotaFissa);
        obj.perequazione = angular.stringToFloat(obj.perequazione);


        return obj;
    }

});