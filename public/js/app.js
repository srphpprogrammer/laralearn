(function() {
  'use strict';

  var app = angular.module('myapp', ['ngRoute']);

  app.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
    

    $routeProvider.when('/', {
      templateUrl: 'partials/wall',
      controller: 'WallController',
      controllerAs: 'wc'
    }).when('/user/:id', {
      templateUrl: 'partials/profile',
      controller: 'ProfileController',
      controllerAs: 'pc'
    }).when('/profile/edit', {
      templateUrl: 'partials/profile_edit',
      controller: ' UserController',
      controllerAs: 'prc'
    }).otherwise({
      redirectTo:'/'
    });

    $locationProvider.html5Mode({
      enabled: true,
      requireBase: true
    });

  }]);

  app.controller('ProfileController', function($scope, $http, $route) {
    $http.get('api/user/' + $route.current.params.id, {}).then(function successCallback(response) {
      $scope.user = response.data.user;
      $scope.friend = response.data.friend;
      $scope.rights = response.data.rights;
    }, function errorCallback(response) {});
  });


  app.controller('UserController', function($scope, $http,$route) {
/*    $http.get('api/user/edit/', {}).then(function successCallback(response) {
      $scope.user = response.data;
    }, function errorCallback(response) {});*/
  });


  app.controller('WallController', function($scope, $http) {
    $scope.posts = {};
    $scope.offset = 3;
    $http.post('api/posts', {}).then(function successCallback(response) {
      $scope.posts = response.data;
    }, function errorCallback(response) {});
    $scope.loadmore = function() {
      $http.post('api/posts', {
        offset: $scope.offset
      }).then(function successCallback(response) {
        $scope.posts.push.apply($scope.posts, response.data);
        $scope.offset = $scope.offset + 3;
      }, function errorCallback(response) {});
    }
    $scope.makePost = function() {
      $http.post('api/posts/create', {
        content: $scope.content
      }).then(function successCallback(response) {
        $scope.posts.unshift(response.data);
        $scope.offset = $scope.offset + 1;
        $scope.content = '';
      }, function errorCallback(response) {});
    }
  });




}());
