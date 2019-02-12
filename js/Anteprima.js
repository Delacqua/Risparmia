angular.module('blueApp')
.controller('Anteprima', function($scope, $location) {

	var url = $location.url();

	if (url == '/luce') {
		$scope.icone = ['img\\titolo-luce.png','img\\umg-luce.png'];
		$scope.pulsante = ['img\\icon-luce.png','CONFRONTO OFFERTE LUCE'];
		$scope.testoGenerale = ['confrontoL','miglioreL',"titoloL","luce"];
	}

	if (url == '/gas') {
		$scope.icone = ['img\\titolo-gas.png','img\\img-gas.png'];
		$scope.pulsante = ['img\\icon-gas.png','CONFRONTO OFFERTE GAS'];
		$scope.testoGenerale = ['confrontoG','miglioreG',"titoloG","gas"];
	}


	$scope.apreForn = function () {
		window.scrollTo(0, 0);//move to top

		if (url == '/luce') { $location.path("/confronta/L"); }

		if (url == '/gas') { $location.path("/confronta/G"); }
		
	}

	$scope.mostraA = [{senso:"entrataCar",esibe:true},{senso:"entrataCar",esibe:false},{senso:"entrataCar",esibe:false}];
	var indexCar = 0;

	$scope.next = function() {
		$scope.mostraA[indexCar] = {senso:"entrataCar",esibe:false};
		indexCar++;
		if (indexCar >= $scope.mostraA.length) { indexCar = 0; }
		$scope.mostraA[indexCar] = {senso:"entrataCar",esibe:true} ;
	}

	$scope.preview = function() {
		$scope.mostraA[indexCar] = {senso:"uscitaCar",esibe:false};
		indexCar--;
		if (indexCar < 0) { indexCar = ($scope.mostraA.length-1); }
		$scope.mostraA[indexCar] = {senso:"uscitaCar",esibe:true } ;
	}


});