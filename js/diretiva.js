angular.module('diretiva', [])
.directive('affidabile', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		next: '&',
		preview: '&',
		carousel: '='
	}

	ddo.templateUrl = 'inc/affidabile.html';

	return ddo;
})

.directive('buttonNavbar', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		img: '@',
		testo: '@'
	}

	//ddo.replace = true;
	ddo.templateUrl = 'inc/button-navbar.html';

	return ddo;
})

.directive('formularioComune', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		comuni: '=',
		comune: '=',
		iniziale: '@',
		retifica: '&'
	}

	ddo.replace = true;
	ddo.templateUrl = 'inc/formulario-comune.html';

	return ddo;
})

.directive('formularioConosci', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		consumo: '=',
		iniziale: '@',
		f1: '=',
		f2: '=',
		inputc: '&',
		input1: '&',
		input2: '&',
		potenzaSelected: '=',
		potenza: '=',
		ivaIniziale: '='
	}

	ddo.transclude = true;
	ddo.templateUrl = 'inc/formulario-conosci.html';

	return ddo;
})

.directive('formularioCalcolare', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		personeSelected: '=',
		personeCasa: '=',
		dimensioneCasa: '=',
		elettrodomestici: '=',
		toggle: '&',
		potenzaSelected: '=',
		potenza: '='
	}

	ddo.link = function(scope, element, attrs) {
		scope.toggle({param:false});
    }


	ddo.transclude = true;
	ddo.templateUrl = 'inc/formulario-calcolare.html';

	return ddo;
})

.directive('formularioConosciGas', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		consumo: '=',
		iniziale: '@',
		inputc: '&',
		ivaIniziale: '='
	}

	ddo.transclude = true;
	ddo.templateUrl = 'inc/formulario-conosci-gas.html';

	return ddo;
})

.directive('formularioCalcolareGas', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		personeSelected: '=',
		personeCasa: '=',
		dimensioneCasa: '=',
		elettrodomestici: '=',
		toggle: '&'
	}

	ddo.link = function(scope, element, attrs) {
		scope.toggle({param:false});
    }


	ddo.transclude = true;
	ddo.templateUrl = 'inc/formulario-calcolare-gas.html';

	return ddo;
})

.directive('formularioPotenza', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		potenzaSelected: '=',
		potenza: '='
	}

	ddo.templateUrl = 'inc/formulario-potenza.html';

	return ddo;
})

.directive('footerChiama', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
	}

	ddo.templateUrl = 'inc/footer-chiama.html';

	return ddo;
})

.directive('footerSocial', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
	}

	ddo.templateUrl = 'inc/footer-social.html';

	return ddo;
})

.directive('headerFornitori', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		ricerca: '=',
		ordinaNome: '&',
		ordinaPrezzo: '&',
		sortType: '=',
		sortReverse: '='
	}

	ddo.replace = true;
	ddo.templateUrl = 'inc/header-fornitori.html';

	return ddo;
})

.directive('iconeAnteprima', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		icone: '@',
		titolo: '@',
	}

	ddo.transclude = true;
	ddo.template = '<img src="{{icone}}" alt="Icone {{titolo}}" class="pull-left"> <em id="luce3">{{titolo}}</em> <span ng-transclude></span>';

	return ddo;
})

.directive('inputConosci', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
	}

	ddo.replace = true;
	ddo.templateUrl = 'inc/input-conosci.html';

	return ddo;
})

.directive('inputIniziale', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		iniziale: '=',
		sfondo: '@'
	}

	ddo.templateUrl = 'inc/input-iniziale.html';

	return ddo;
})

.directive('menuFornitori', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		open: '&'
	}

	ddo.replace = true;
	ddo.templateUrl = 'inc/menu-fornitori.html';

	return ddo;
})

.directive('panello', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		azienda: '=',
		risparmia: '&',
		vetrina: '='
	}

	ddo.link = function(scope, element, attrs) {
            scope.risparmia(element);
    }

	ddo.transclude = true;

	ddo.templateUrl = 'inc/panello.html';

	return ddo;
})

.directive('testoMain1', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		quale: '@'
	}

	ddo.templateUrl = 'inc/testo-main1.html';

	return ddo;
})

.directive('testoMainPromo', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		icone: '@',
		titolo: '@',
	}

	ddo.transclude = true;
	ddo.template = '<img src="{{icone}}" alt="Icone {{titolo}}" class="img-responsive center-block"> <em>{{titolo}}</em> <span ng-transclude></span>';
	//ddo.templateUrl = 'inc/testo-main-promo.html';

	return ddo;
})

.directive('testoPre', function(){
	var ddo = {};

	ddo.restric = "AE";

	ddo.scope = {
		quale: '@'
	}

	ddo.transclude = true;
	ddo.templateUrl = 'inc/testo-pre.html';

	return ddo;
})

// Directive js --------------------------

.directive('prendeSchermo', ['$window', function ($window) {
     return {
        link: link,
        restrict: 'A'           
     };
     function link(scope, element, attrs){
        scope.width = $window.innerWidth;
                    
            function onResize(){
                if (scope.width !== $window.innerWidth) {
                	scope.testResolution();
                    //scope.width = $window.innerWidth;
                    scope.$digest();
                }
            };

            function cleanUp() {
                angular.element($window).off('resize', onResize);
            }

            angular.element($window).on('resize', onResize);
            scope.$on('$destroy', cleanUp);
     }    
 }]);