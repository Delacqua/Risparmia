angular.module('blueAppDB')
.controller('Login', function($scope, $sanitize, $urls, $routeParams, $location, $postDB, $getDB, service,course, $http) {

	$scope.login = course.getFunc().user;

	$scope.user = {};


	$scope.logIn = function() {

		$postDB.async($urls.route + $urls.login, $scope.user).then(function(response) {
            	angular.verificaLogin(response);
    		});
	}

	$scope.logOut = function() {
		var data = {verifica:false};
		course.setVerifica(data);
		$scope.login = "LogOut";
	}


	
    angular.verificaLogin = function (login) {
        if (login.verifica) {
    		$scope.login = "Registrati: " + login.user;
                course.setVerifica(login);
                $location.path('/');
    	}
    		else {
    			$scope.login = "fail";
                    if(login.hasOwnProperty('erro')) {
                        if (login.erro == 1) {$scope.login = "Login incorreto";}
                        if (login.erro == 2) {$scope.login = "Password incorreto";}
                }
    		}

    }

    $scope.aggiorna = function () {
    	$scope.template = 'login.php';
    }



    

});