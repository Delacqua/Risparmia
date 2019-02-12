angular.module('blueApp')
.controller('Confronta', function($routeParams, $scope) {


//Config iniziale

	//Menu - true = luce / false = gas
	if ($routeParams.tipo == "L") {
		$scope.formIniziale = true;
		$scope.sfondoInput = "formComparatoreLuce";
		
	}
	
	if ($routeParams.tipo == "G") {
		$scope.formIniziale = false;
		$scope.sfondoInput = 'formComparatoreGas';
	}


//-----------------


});