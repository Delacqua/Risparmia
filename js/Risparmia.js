angular.module('blueApp')
.controller('Risparmia', function($scope, $timeout, $location, $urls, $postDB) {


//Config iniziale -----------

	$scope.privati3 = {};
	$scope.formCompilati = false;
	$scope.showForm = true; //toogle form / msg send

//---------------------------


	//check form
	$scope.richiama = function () {
		if (angular.isUndefined($scope.privati3.nome) || angular.isUndefined($scope.privati3.cognome) || angular.isUndefined($scope.privati3.telefono) || angular.isUndefined($scope.privati3.email) || angular.isUndefined($scope.privati3.tipoRisparmio) || $scope.privati3.privacy != true) {
			angular.errorMsg();
		}

			else {
				angular.saveUtente();
				$scope.showForm = false;
			}
	}


	//save dati utenti
	angular.saveUtente =function() {

          var type = $urls.utenteRichiama;
          var dati = {nome:$scope.privati3.nome, cognome:$scope.privati3.cognome, telefono:$scope.privati3.telefono, email:$scope.privati3.email, tipo:$scope.privati3.tipoRisparmio, accetta:$scope.privati3.privacy, iva:true};

	      //save DB
	      var data = {tabella: type, item: dati};
	      $postDB.async($urls.updateUtente, data).then(function(response) {
	      	console.log(response);
	      		if (response=="email") { angular.msgRichiama(true) }
      				else { angular.msgRichiama(false) }
	      });

	  }

	//Per anullare il mensaggio di errore dopo 3000 ms
  	angular.errorMsg = function () {
	    $scope.formCompilati = true;
	    $timeout(function () {
	          $scope.formCompilati = false;
	      }, 3000);

	  }

	//msg di coferma / errore form
	angular.msgRichiama = function  (tipo) {
		if (tipo) {
			$scope.msgRichiama = "Presto vi contatteremo";
		}
			else {
				$scope.msgRichiama = "Si è verificato un errore temporaneo";
			}
	}


});