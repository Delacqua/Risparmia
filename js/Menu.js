angular.module('blueApp')
.controller('Menu', function($scope, $rootScope, $urls, $location ,$urlsGas, $getDB, $postDB, $timeout, SetCookie, TestResolution, DatiInput) {

//Valore delle voce
	var max = 0;
	$scope.destaque = [];

  $scope.personeCasa = DatiInput.personeCasa();
  $scope.potenza = DatiInput.potenza();

	$scope.personeSelected = 3; //Numero di persone
	$scope.potenzaAggiunta = 0; //Potenza degli elettrodomestici
	$scope.dimensioneCasa = 75; //Dimenzione iniziale

  $scope.comuneSelected = {};
  $scope.formComuneValid = false;
  $scope.potenzaSelected = 3; //Potenza
  $scope.formPost = {};
  $scope.privati2 = {};

  $scope.showLuce = true;
//  $scope.iva = $rootScope.datiConsumo.iva;


//verifica se ha gia compilato - set valore
  var datiConsumoL = SetCookie.verifica("fornitoriLuce");
  var datiConsumoG = SetCookie.verifica("fornitoriGas");
  var datiUtenti = SetCookie.verifica("utenti");


  if (datiConsumoL) {
        $scope.potenzaSelected = datiConsumoL.potenza; //Potenza
        $scope.formPost["consumo"] = datiConsumoL.consumo;

        $scope.comuneSelected["comune"] = datiConsumoL.comune;
        $scope.comuneSelected["regione"] = datiConsumoL.regione;
        $scope.formComuneValid = true;

    }

  if (datiConsumoG) {
//        $scope.formPost["consumo"] = datiConsumoG.consumo;

        $scope.comuneSelected["comune"] = datiConsumoL.comune;
        $scope.comuneSelected["regione"] = datiConsumoL.regione;
        $scope.formComuneValid = true;
    }

  if (datiUtenti.utenteP) {
        $scope.privati2.nome = datiUtenti.utenteP.nome;

        $scope.privati2["cognome"] = datiUtenti.utenteP.cognome;
        $scope.privati2["telefono"] = datiUtenti.utenteP.telefono;
        $scope.privati2["email"] = datiUtenti.utenteP.email;
        $scope.privati2["privacy"] = datiUtenti.utenteP.accetta;
  }

  if (datiUtenti.utenteI) {
        $scope.iva2["ragioneSociale"] = datiUtenti.utenteI.ragioneSociale;
        $scope.privati2["telefono"] = datiUtenti.utenteP.telefono;
        $scope.privati2["email"] = datiUtenti.utenteP.email;
        $scope.privati2["privacy"] = datiUtenti.utenteP.accetta;
  }


//-------


  	// Database Comune
    $getDB.async($urls.getAltri + '/'+ $urls.comune).then(function(response) {
        $scope.comuni = response;
    });

    // Database elettrodomestici
    $getDB.async($urls.getAltri + '/' + $urls.elettro).then(function(response) {
        $scope.elettrodomestici = response;
    });

    $getDB.async($urls.getAltri + '/' + $urlsGas.elettroGas).then(function(response) {
        $scope.elettrodomesticiGas = response;
    });


  potenzaIniziale = function() {
    
    angular.forEach($scope.elettrodomestici, function (value, key) {
      if (value.valore) { 
            $scope.potenzaAggiunta = $scope.potenzaAggiunta + value.potenza;
        }
      });
	}

	potenzaIniziale();

//Menu Input ----------------------------------
  //toogle luce / gas / telefono
  $scope.cambiaInput = function(quale) {
      if (quale == 'luce') {
          $scope.showLuce = true;
      }

      if (quale == 'gas') {
          $scope.showLuce = false;
      }
  }

  //Config iniziale
  $scope.sfondoMenu = {height:'520px', margin:'0px'};
  $scope.formCompleti = true;  
  $scope.ivaIniziale = false;
  $scope.pathAtuale = 'cominciamo';
  $scope.datiConsumo = true;
  $scope.msgComune = false;
  $scope.privati2 = {};

//  $scope.comuneIniziale = $rootScope.datiConsumo.comune;
//  $scope.consumoIniziale = $rootScope.datiConsumo.consumo;

  //toggle form completi /stima
  $scope.cambiaFormCompleti = function(quale) {
      $scope.formCompleti = !$scope.formCompleti;
  }

  //verifica se il form e stato compilato
  angular.checkForm = function() {
      if ($scope.formCompleti) {
          if ($scope.formComuneValid && $scope.consumo) {
              return true;
          }
            else{
              return false;
            }
      }
        else {
            if ($scope.formComuneValid) {
              return true;
            }
              else{
                return false;
              }
        }
  }


  //pulsante input iniziale 
  $scope.aggiornaForm = function() {
      if ($scope.pathAtuale == 'cominciamo') {
          if (angular.checkForm()) {
            angular.nextForm();
          }
            else {
              angular.errorMsg($scope.msgComune);
            }

      }

        else {
            if (!$scope.privati2.nome && !$scope.privati2.cognome) {
               angular.errorMsg($scope.msgComune);
            }
              else{
                angular.saveUtente();
                angular.nextForm();
              }
        }

  }

  //Dati Consumi -> personale -> comparatore 
  angular.nextForm = function() {
      if ($scope.pathAtuale == 'cominciamo') {
          angular.salvaDatiConsumo();
          $scope.datiConsumo = false;                                
          $scope.pathAtuale = 'dati';
          $scope.sfondoMenu = {height:'400px', margin:'60px'};
      }

      else {
          if ($scope.showLuce) {
            $location.path('fornitori');
          }
            else {
              $location.path('fornitoriGas');
            }
      }
  }




  //Ritorno- Path 
  $scope.ritornoForm = function() {
      $scope.datiConsumo = true;                         
      $scope.pathAtuale = 'cominciamo';
      $scope.sfondoMenu = {height:'520px', margin:'0px'};
  }

  //save dati consumo cookie / $rootscope
  angular.salvaDatiConsumo = function() {
      if (!$scope.formCompleti) {$scope.consumo = false; }
 
      if ($scope.showLuce) {
          $rootScope.datiConsumo = { comune:$scope.comuneSelected.comune, 
                            regione: $scope.comuneSelected.regione, 
                            consumo: $scope.consumo, 
                            f1:$scope.consumo*0.6, 
                            f2:$scope.consumo*0.4, 
                            f3:0, 
                            potenza: $scope.potenzaSelected,
                            potenzaAggiunta:$scope.elettrodomestici,
                            personeSelected:$scope.personeSelected,
                            dimensioneCasa:$scope.dimensioneCasa,
                            iva:$scope.ivaIniziale };
          var menu = {tipo:"consumo",luce:true};
          SetCookie.save($rootScope.datiConsumo,menu);
      }

      if (!$scope.showLuce) {
          $rootScope.datiConsumo = { comune:$scope.comuneSelected.comune, 
                            regione: $scope.comuneSelected.regione, 
                            consumo: $scope.consumo,
                            tipologiaConsumo: $scope.elettrodomesticiGas,
                            personeSelected:$scope.personeSelected,
                            dimensioneCasa:$scope.dimensioneCasa,
                            iva:$scope.ivaIniziale };
          var menu = {tipo:"consumo",luce:false};
          SetCookie.save($rootScope.datiConsumo,menu);
      }

  }



  //save dati utenti
  angular.saveUtente =function() {

      if ($scope.ivaIniziale) {
        var type = $urls.utenteIva;
        var dati = {comune:$scope.comuneSelected.comune, regione:$scope.comuneSelected.regione, ragioneSociale:$scope.iva2.ragioneSociale, 
          telefono:$scope.privati2.telefono, email:$scope.privati2.email, accetta:$scope.privati2.privacy, iva:true};
      }
        else {
          var type = $urls.utentePrivati;
          var dati = {comune:$scope.comuneSelected.comune, regione:$scope.comuneSelected.regione, nome:$scope.privati2.nome, 
           cognome:$scope.privati2.cognome, telefono:$scope.privati2.telefono, email:$scope.privati2.email, accetta:$scope.privati2.privacy, iva:true};
        }

      //save cookie
      var menu = {tipo:"utenti",iva:$scope.ivaIniziale};
      SetCookie.save(dati,menu);
      
      //save DB
      var data = {tabella: type, item: dati};
      $postDB.async($urls.updateUtente, data).then(function(response) {
      });

  }



//Per anullare il mensaggio di errore dopo 3000 ms
  angular.errorMsg = function () {
    $scope.formCompilati = true;
    $timeout(function () {
          $scope.formCompilati = false;
      }, 3000);

  }


//------------------


	//Compila il campo comune
  $scope.rettifica = function(){
    $scope.formComuneValid = false;

    if (!angular.isUndefined($scope.comuneSelected.comune)) {
        angular.forEach($scope.comuni, function (value, key) {
           if (cercaString($scope.comuneSelected.comune,value.denominazione)) { 
              $scope.comuneSelected.regione = value.regione;
              $scope.formComuneValid = true;
            }
        });
    }
  }

//  $scope.rettifica();

  //check il form conosci consumo
  $scope.isFormValid = function(){
    if ($scope.formComuneValid && $scope.formConosci.$valid) {
        return false;
      }
      else { 
        return true;
      }

  }


//check il form stima
  $scope.isFormStimaValid = function(){

    if ($scope.formComuneValid) {
        return false;
      }
      else { 
        return true;
      }

  }

  //cerca string
  var cercaString = function(nome1, nome2){
    var _nome1 = nome1.toLowerCase();
    var _nome2 = nome2.toLowerCase();
    
    if (_nome1.match(_nome2)) {
        return true;
        }
      else { 
        return false; 
        }
   }


// Form post:consumo/dati - get:aziende
	$scope.inputConsumo = function() {
	    $scope.formPost.f1 = $scope.formPost.consumo * 0.6;
	    $scope.formPost.f2 = $scope.formPost.consumo * 0.4;

	}

	$scope.inputFascia1 = function() {
	    if(!$scope.formPost.f2) {
	      $scope.formPost.consumo = $scope.formPost.f1 + 0;
	    }
	      else {
	        $scope.formPost.consumo = $scope.formPost.f1 + $scope.formPost.f2;
	      }
	}

	$scope.inputFascia2 = function() {
	        if(!$scope.formPost.f1) {
	      $scope.formPost.consumo = $scope.formPost.f2 + 0;
	    }
	      else {
	        $scope.formPost.consumo = $scope.formPost.f2 + $scope.formPost.f1;
	      }
	}

	$scope.submitForm = function() {
		//Data to fornitori
	    $rootScope.datiConsumo = {regione: $scope.comuneSelected.regione, consumo: $scope.formPost.consumo, f1:$scope.formPost.f1, f2:$scope.formPost.f2, f3:0, potenza:$scope.potenzaSelected };
	};

	$scope.submitFormStima = function() {
		//Data to fornitori - set Consumo to false for stima
		$rootScope.datiConsumo = {regione: $scope.comuneSelected.regione, consumo: false, potenzaAggiunta: $scope.elettrodomestici, personeSelected: $scope.personeSelected,
		dimensioneCasa: $scope.dimensioneCasa, potenza:$scope.potenzaSelected };
	};


});