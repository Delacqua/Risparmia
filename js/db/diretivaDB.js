angular.module('diretivaDB',[])
.directive('inputnumero', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		nome: '@',
		valore: '='
	}

	ddo.templateUrl = '../inc/inputNumero.html';

	return ddo;
})
.directive('inputtesto', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		nome: '@',
		valore: '='
	}

	ddo.templateUrl = '../inc/inputTesto.html';

	return ddo;
})
.directive('tabellaHeader', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		nome: '@',
		button: '&',
		type: '=',
		ordine: '='
	}

	ddo.transclude = true;
	ddo.templateUrl = '../inc/tabella-header.html';

	return ddo;
})
.directive('buttonCancela', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		nome: '@',
		button: '&',
	}

	ddo.transclude = true;
	ddo.templateUrl = '../inc/button-cancela.html';

	return ddo;
});