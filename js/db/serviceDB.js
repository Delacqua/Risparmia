angular.module('blueAppDB')
.service('service', function ($http,$urls) {
    var data1 = false;

    this.verifica = function(value){
        data1 = value;
    };

    this.getData1=function(){
      return data1;
    };
})
.factory('course', function () {
    var verifica = {verifica:false ,user:"Manca il login"};
    function getFunc() {
        return verifica;
    }
    function setVerifica(value) {
        verifica = value;
    }

    return {
          getFunc: getFunc,
          setVerifica: setVerifica
        };
})
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
.factory('$putDB', function($http) {
  var consultaDB = {
    async: function(route,dati) {
      var promise = $http.put(route, dati).then(function (response) {
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
.factory('$deleteDB', function($http) {
  var consultaDB = {
    async: function(route,dati) {
      var promise = $http.delete(route, dati).then(function (response) {
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
});
