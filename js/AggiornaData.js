angular.module("blueAppDB")
.controller("AggiornaData", function($scope, $http, $filter, $routeParams,$location,urls,$injector) {

    $scope.mensage;
    $scope.selectionServ = []; //Elenco dei servizi selezionati
    $scope.selectionFat = []; //Elenco dei pagamenti selezionati
    $scope.selectionReg = []; //Elenco dei regioni selezionati
    $scope.ricerca = {};
    $scope.addon = false;
    $scope.nuovoServizo;
    $scope.nuovoFatturazione;

//    $injector.get('imposte');
    
    $http.get(urls.getAziendeLuce).then (
        function(response){
             $scope.todos = response.data;
        }, 
        function(response){
            console.log("Erro: "+response);
        }
    );

    $http.get('../php/consultaDB.php/' + 'regione').then (
        function(response){
            $scope.regioni = response.data;
        }, 
        function(response){
            console.log("Erro regione: " + response);
        }
    );

    // Array servizi
    $http.get('../php/servizi.php/'+ 'serviziagg').then (
        function(response){
             $scope.serv = response.data;
        }, 
        function(response){
            console.log("Erro: " + response);
        }
    );

    //Array fatturazione
    $http.get('../php/servizi.php/'+ 'fatturazione').then (
        function(response){
             $scope.fatt = response.data;
        }, 
        function(response){
            console.log("Erro: " + response);
        }
    );

    $http.get('../php/imposte.php').then (
        function(response){
             $scope.imposte = response.data;
        }, 
        function(response){
            console.log("Erro: " + response);
        }
    );


//Check if is new or update

    $scope.vecchio = {};

    if ($routeParams.id) {

        $http.get(urls.getAziendeLuce).then (
   
            function(response){
                $scope.vecchio = response.data[$routeParams.id];
                // Selected Servizi Aggiuntti
                $scope.selectionServ = $scope.vecchio.serviziAgg;
                // Selected fatturazione
                $scope.selectionFat = $scope.vecchio.fatturazione;
                // Selected Regioni 
                $scope.selectionReg = $scope.vecchio.regione;
                //Cambia il valore da string a float
                $scope.vecchio.prezzo = parseFloat($scope.vecchio.prezzo);
                $scope.vecchio.f1 = parseFloat($scope.vecchio.f1);
                $scope.vecchio.f2 = parseFloat($scope.vecchio.f2);
                $scope.vecchio.f3 = parseFloat($scope.vecchio.f3);

                $scope.vecchio.energiaCotaFissa = parseFloat($scope.vecchio.energiaCotaFissa);
                $scope.vecchio.energiaPotenza = parseFloat($scope.vecchio.energiaPotenza);

                $scope.vecchio.energiaVariabile[0] = parseFloat($scope.vecchio.energiaVariabile[0]);
                $scope.vecchio.energiaVariabile[1] = parseFloat($scope.vecchio.energiaVariabile[1]);
                $scope.vecchio.energiaVariabile[2] = parseFloat($scope.vecchio.energiaVariabile[2]);
                $scope.vecchio.energiaVariabile[3] = parseFloat($scope.vecchio.energiaVariabile[3]);

                $scope.vecchio.transportoVariabile[0] = parseFloat($scope.vecchio.transportoVariabile[0]);
                $scope.vecchio.transportoVariabile[1] = parseFloat($scope.vecchio.transportoVariabile[1]);
                $scope.vecchio.transportoVariabile[2] = parseFloat($scope.vecchio.transportoVariabile[2]);
                $scope.vecchio.transportoVariabile[3] = parseFloat($scope.vecchio.transportoVariabile[3]);

                $scope.vecchio.transportoCotaFissa = parseFloat($scope.vecchio.transportoCotaFissa);
                $scope.vecchio.perequazione = parseFloat($scope.vecchio.perequazione);

                //Aggiunge cancelatti ma ancora registrati (vecchio.serviziR)
                //Aggiunge cancelatti ma ancora registrati (vecchio.fatturazioneR)

            }, 
            function(response){
                 console.log("Erro: " + response);
               }

        );

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



    $scope.aggiorna = function(obj){
        $scope.index = $scope.todos.indexOf(obj);
    }  


//Cancela il registro
    $scope.cancela = function(obj){

        $http.delete('../php/updateAzienda.php/'+ obj.id).then (
            function(response){
                var indice = $scope.todos.indexOf(obj);
                $scope.todos.splice(indice, 1);
            }, 
            function(response){
                 console.log("Erro: " + response);
               }

        );
        
    }


//Apre e chiude Servizi
    $scope.openServ = function(){
        $scope.addon = !$scope.addon;
    }

//remove service/ fatt
    $scope.removeItem = function(type, item) {

        var data = {tabella: type, item: item.id};

        $http.delete('../php/servizi.php/' + JSON.stringify(data)) .then (
            function(response){
                if (type == "serviziagg") {
                    var indice = $scope.serv.indexOf(item);
                    $scope.serv.splice(indice, 1);
                }
                if (type == "fatturazione") {
                    var indice = $scope.serv.indexOf(item);
                    $scope.fatt.splice(indice, 1);
                }
                
            }, 
            function(response){
                 console.log("Erro: " + response);
               }

        );

    }

//Aggiunge serv / fatt
    $scope.aggiungeItem = function (type, item) {
        var data = {tabella: type, item: item};

        $http.put('../php/servizi.php', data) .then (
            function(response){
                    if(type == "serviziagg") {
                        var nuovoItem = {id:response.data.id,serviziagg:item};
                        $scope.nuovoServizo = "";
                        $scope.serv.push(nuovoItem);
                    }
                    if(type == "fatturazione") {
                        var nuovoItem = {id:response.data.id,fatturazione:item};
                        $scope.nuovoFatturazione = "";
                        $scope.fatt.push(nuovoItem);
                    }
            }, 
            function(response){
                 console.log("Erro: " +  response);
               }

        );
    }



// Send form to php
    $scope.submitForm = function(obj) {

        obj.serviziAgg = $scope.selectionServ;
        obj.fatturazione = $scope.selectionFat;
        obj.regione = $scope.selectionReg;
        obj.prezzo = parseFloat(obj.prezzo);


        if (obj.id) {
            // Aggiorna il registro
            $http.post('../php/updateAzienda.php', obj).then (
                function(response){
                }, 
                function(response){
                     console.log("Erro Aggiorna: " + response.data);
                }
            );

        }

            else {
                // Aggiunge un nuovo registro
                obj.energiaVariabile = angular.objToArray(obj.energiaVariabile);
                obj.transportoVariabile = angular.objToArray(obj.transportoVariabile);


                $http.put('../php/updateAzienda.php', obj ).then (
                    function(response){
                    }, 
                    function(response){
                         console.log("Erro aggiunge: " + response);
                       }
                    );
            }


    };

});
/*
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

    */