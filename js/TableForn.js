angular.module('blueApp')
.controller('TableForn', function($scope, $filter, $rootScope, $urls, $postDB, ArrayPrezzo, SetCookie) {


//Setup iniziale  -------

  $scope.tipoForn = 'luce';

  if (!$rootScope.datiConsumo) {
      var datiConsumo = SetCookie.verifica("fornitoriLuce");
      if (datiConsumo) {
                $rootScope.datiConsumo = datiConsumo;
            }
              else {
                $rootScope.datiConsumo = { comune:'Milano', regione: 'Lombardia', consumo: 1500, f1:1000, f2:500, f3:0, potenza: 3, iva:false };
              }
  }


  var max = 0; // Valore del prezzo piu alto
  $scope.iva = $rootScope.datiConsumo.iva;
  
  
  $scope.cambiaResolution(false); // navbar.js


//----------------------------


  $scope.risparmia = function(valore) {
      return max - valore;
  }


  angular.componeLista = function (dati) {

      if (!dati.iva) {
        var tabella = $urls.aluce;
        var tabellaD = $urls.aluceD;
      }
      if (dati.iva) {
        var tabella = $urls.aluceI;
        var tabellaD = $urls.aluceID;
      }
      
      angular.consultaDB(dati,tabella);
      angular.consultaDB2(dati,tabellaD);
  }

  // Posting data to php file e get array delle aziende
  angular.consultaDB = function (dati,tabella) {
      $postDB.async($urls.getAziende + '/' + tabella, dati).then(function(response) {
            var temp = ArrayPrezzo.expand(response);
            temp = $filter("orderBy")(response,"totale");
            $scope.todos = temp;
            // Prende il valore piu alto
            max = Math.max.apply(Math,$scope.todos.map(function(item){return item.totale;}));
      });
  }

  // Posting data to php file e get array delle aziende in vetrina
  angular.consultaDB2 = function (dati,tabella) {

      $postDB.async($urls.getAziende + '/' + tabella, dati).then(function(response) {
            var temp = ArrayPrezzo.expand(response);
            $scope.vetrina = temp;
      });
  }


  angular.componeLista($rootScope.datiConsumo);

  $scope.aggiornaForm2 = function (regione,consumo,f1,f2,f3,potenza,iva,comune) {
    var dati = {comune:comune, regione: regione, consumo: consumo, f1:f1, f2:f2, f3:f3, potenza:potenza, iva:iva };
    var menu = {tipo:"consumo",iva:iva};
    SetCookie.save(dati,menu);
    angular.componeLista(dati);
  }


  $scope.aggiornaStimaForm2 = function(regione,aggiun,persone,dimensione,potenza) {
    var dati = {regione: regione, consumo: false, potenzaAggiunta: aggiun, personeSelected: persone, dimensioneCasa: dimensione, potenza:potenza};
    var menu = {tipo:"consumo",iva:false};
    SetCookie.save(dati,menu);
    angular.componeLista(dati);
  };


//Cambia l'ordine, tra nome e prezzo
  $scope.sortType     = 'totale'; // Ordine iniziale 
  $scope.sortReverse  = false;  // Dal più piccolo al più grande

  $scope.ordine = function(nome) {
    $scope.sortType = nome;
    if ($scope.sortType == nome) {
      $scope.sortReverse = !$scope.sortReverse;
    }

  }

});