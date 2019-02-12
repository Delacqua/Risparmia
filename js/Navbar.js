angular.module('blueApp')
.controller('Navbar', function($scope, $location, $urls, $postDB, TestResolution) {

// Config Ini  --------------------
	$scope.url = $location.url();
	$scope.sitemap = [  {destino:'/main',nome:'Home'},
						{destino:'/luce',nome:'Luce'},
						{destino:'/gas',nome:'Gas'},
						{destino:'/risparmia',nome:'Risparmia'}];

	//hidden footer
	$('.footerChiama').fadeOut(0.1);

	$scope.numeroTelefono;

	// Handler
	$(window).scroll(navSlide);

	$scope.showInput = true;

//--------------------------

	//send number to php
	$scope.richiama = function () {
		var dati = {telefono:$scope.numeroTelefono};
		var data = {tabella: $urls.utenteRichiama, item: dati};	
      	$postDB.async($urls.updateUtente, data).then(function(response) {
      		$scope.showInput = false;
      		if (response=="email") { msgRichiama(true) }
      			else { msgRichiama(false) }
      	});
	}

	function msgRichiama (tipo) {
		if (tipo) {
			$scope.msgRichiama = "Presto vi contatteremo";
		}
			else {
				$scope.msgRichiama = "Si è verificato un errore temporaneo";
			}
	}


	//show footer chiama (sotto 180px)
	function navSlide() {
	  	var scroll_top = $(window).scrollTop();

	//	console.log($('.footerChiama'));
		var y = $(this).scrollTop();
	    if (y > 180) {
	        $('.footerChiama').fadeIn();
	    } else {
	        $('.footerChiama').fadeOut();
	    }
	}


	//cambia pagina
	$scope.cambiaPagina = function (destino) {
		window.scrollTo(0, 0);//move to top
		$location.path(destino);
	}

	$scope.cambiaPath = function (url) {
		switch (url) {
			case '/':
			case '/main':
			case '/':
				$scope.url = "/main";
				break;
			case '/luce':
			case '/confronta/L':
				$scope.url = "/luce";
				break;
			case '/gas':
			case '/confronta/G':
				$scope.url = "/gas";
				break;
			case '/risparmia':
				$scope.url = "/risparmia";
				break;
			default:
				$scope.url = "/main";
				break;
		}
	}

	
	$scope.$on('$locationChangeSuccess', function(next, current) {
		var url = $location.url();
		$scope.cambiaPath(url);
	 });

//show hidden menu (xs sm ) - Fornitori.html ------------
	//set menu xs sm
	$scope.cambiaResolution = function(menuOn) {
	  var posizione = TestResolution.test(menuOn);
	  $scope.moveMenu = posizione.menu;
	  $scope.movePanello = posizione.panello;
	}

	var menuOn = false;

	var mainCtrl = this;
	mainCtrl.test = 'testing mainController';

	$scope.testResolution = function () {
	  $scope.cambiaResolution(false);
	  $scope.$apply();
	}

	$scope.mostraMenuSmall = function () {
	  menuOn = !menuOn;
	  $scope.cambiaResolution(menuOn);
	}

//------------------




});