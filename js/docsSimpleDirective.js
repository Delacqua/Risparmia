(function(angular) {
  'use strict';
angular.module('inputNumero', [])
  .controller('Controller', ['$scope', function($scope) {
    $scope.customer = {
      name: 'Naomi',
      address: '16100 Amphitheatre'
    };
  }])
  .directive('myCustomer', function() {
    return {
      templateUrl: 'inc/inputNumero.html'
    };
  });
})(window.angular);