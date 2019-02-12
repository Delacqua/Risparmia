angular.module('blueApp')
.factory('$getDB', function($http) {
  var consultaDB = {
    async: function(route) {
      var promise = $http.get(route).then(function (response) {
        // The return value gets picked up by the then in the controller.
        return response.data;
      	}, function(httpError) {
      		// get the error
            throw httpError.data;
      });

      // Return the promise to the controller
      return promise;
    }
  };
  return consultaDB;
})

.factory('$postDB', function($http) {
  var consultaDB = {
    async: function(route,dati) {
      var promise = $http.post(route, dati).then(function (response) {
        // The return value gets picked up by the then in the controller.
        return response.data;
      	}, function(httpError) {
      		// get the error
            throw httpError.data;
      });

      // Return the promise to the controller
      return promise;
    }
  };
  return consultaDB;
})

//Dati input 
.service('DatiInput', function () {
  this.personeCasa = function (menuOn) {
      var personeCasa = [
          {nome:'1',valore:1},
          {nome:'2',valore:2},
          {nome:'3',valore:3},
          {nome:'4',valore:4},
          {nome:'5+',valore:5}];

    return personeCasa;
  };
  this.potenza = function () {
    var potenza = [
        {nome:'1,5',valore:1.5,check:false},
        {nome:'3',valore:3,check:true},
        {nome:'4,5',valore:4.5,check:false},
        {nome:'6',valore:6,check:false}];

    return potenza;
  };

})

//controlla il menu xs / sm (hidden / show) 
.service('TestResolution', function ($window) {
  this.test = function (menuOn) {
    var moveMenu;
    var movePanello;

    if ($window.innerWidth < 992) {
        if (menuOn) { 
            movePanello = "spazioPanelloEntrata"; 
            moveMenu = "spazioMenuEntrata";
        }
            else { 
                movePanello = "spazioPanelloUscita";
                moveMenu = "spazioMenuUscita";
            }
    }
      else {
        moveMenu = "";
        movePanello = "";
      }

    return {menu:moveMenu, panello:movePanello};
    
  };
})

//Monta la tabella dei prezzi con i nomi giusti
.service('ArrayPrezzo', function () {
  this.expand = function (objs) {
      
      angular.nomeGiusto = function (nome) {

          switch (nome) {
              case 'energia':
                  nome = "Energia";
                  break;
              case 'prezzoMateria':
                  nome = "Materia Prima";
                  break;
              case 'rede':
              case 'transporto':
                  nome = "Trasporto";
                  break;
              case 'imposte':
                  nome = "Imposte";
                  break;
              case 'iva':
                  nome = "Iva";
                  break;
              case 'prezzoT':
                  nome = "Totale";
                  break;
          }

           return nome;

      }

      
      angular.templatesAry = function (obj) {
        var ary = [];
        angular.forEach(obj, function (val, key) {
            ary.push({key: angular.nomeGiusto(key), val: val});
        });
        return ary;

      }

      angular.convertObjs = function (_objs) {
        var arrayObjs = [];

        angular.forEach(_objs, function(value, key) {
            value["totale"] = value.prezzoE.prezzoT;
            value.prezzoE = angular.templatesAry(value.prezzoE);
            arrayObjs.push(value);
        });

          return arrayObjs;
        
      }

    return angular.convertObjs(objs);
    
  };
})

// Save - Load cookies 
.service('SetCookie', function ($cookies) {
  this.verifica = function (dove) {
      //Verifica si e gia compilato il form
      if (dove == "fornitoriLuce") {
          var datiConsumoL = $cookies.datiConsumoL;
            if (!angular.isUndefined(datiConsumoL)) {
                return JSON.parse(datiConsumoL);
            }
            else { return false }
      }

      if (dove == "fornitoriGas") {
          var datiConsumoG = $cookies.datiConsumoG;
            if (!angular.isUndefined(datiConsumoG)) {
                return JSON.parse(datiConsumoG);
            }
            else { return false }
      }

      if (dove == "utenti") {
          var utente = {utenteI:false,utenteP:false};

          var utenteI = $cookies.utenteI;
            if (!angular.isUndefined(utenteI)) {
                utente.utenteI = JSON.parse(utenteI);
            }

          var utenteP = $cookies.utenteP;
            if (!angular.isUndefined(utenteP)) {
                utente.utenteP = JSON.parse(utenteP);
            }

          return utente;
      }

  };


  this.save = function (dati,menu) {
      if (menu.tipo == "consumo") {
          if (menu.luce) {
            $cookies.datiConsumoL = JSON.stringify(dati);
          }
            else {
              $cookies.datiConsumoG = JSON.stringify(dati);
            }
        
      }

      if (menu.tipo == "utenti") {
          if (menu.iva) {
            $cookies.utenteI = JSON.stringify(dati);
          }
            else {
              $cookies.utenteP = JSON.stringify(dati);
            }

      }

  };

});