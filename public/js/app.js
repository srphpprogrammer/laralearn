(function() {
  'use strict';

  var app = angular.module('myapp', ['ngRoute','ngStorage']);

  app.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
    

    $routeProvider.when('/', {
      templateUrl: 'partials/wall',
      controller: 'WallController',
      controllerAs: 'wc'
    }).when('/profile/:id', {
      templateUrl: 'partials/profile',
      controller: 'ProfileController',
      controllerAs: 'pc'
    }).when('/user/edit', {
      templateUrl: 'partials/profile_edit',
      controller: 'UserController',
      controllerAs: 'xs'
    }).when('/search/:qstring', {
      templateUrl: 'partials/search',
      controller: 'searchController',
      controllerAs: 'sc'
    }).when('/register', {
      templateUrl: 'partials/register',
      controller: 'RegisterController',
      controllerAs: 'rc'
    }).when('/login', {
      templateUrl: 'partials/login',
      controller: 'LoginController',
      controllerAs: 'lc'
    }).otherwise({
      redirectTo:'/'
    });

    $locationProvider.html5Mode({
      enabled: true,
      requireBase: true
    });









  }]);
  app.controller('UserController', function($scope, $http,$route) {
    $http.get('api/user/edit', {}).then(function successCallback(response) {
      $scope.user = response.data;
    }, function errorCallback(response) {});
  });
  app.controller('ProfileController', function($scope, $http, $route) {
    $http.get('api/profile/' + $route.current.params.id, {}).then(function successCallback(response) {
      $scope.user = response.data.user;
      $scope.friend = response.data.friend;
      $scope.rights = response.data.rights;
    }, function errorCallback(response) {});
  });

  app.controller('RegisterController', function($scope, $http,$route,$localStorage,$location,$rootScope) {

    if ($rootScope.isLoggedIn) $location.path('/');



    $('#regform').validator();

    $('#regform').validator().on('submit', function (e) {
      if (!e.isDefaultPrevented()) {




      $http.post('api/user/create',{
          name: $scope.name,
          email: $scope.email,
          password: $scope.password
      }).then(function successCallback(response) {
          $localStorage.isLoggedIn = 1;
          $location.path('/');return;
      }, function errorCallback(response) {});



      
      }
      return false;
    });



  });


  


  app.controller('LoginController', function($scope,$http,$route,$localStorage,$location,$rootScope) {
      //if ($rootScope.isLoggedIn) $location.path('/');

      $('#loginform').validator();

      $scope.submit = function(){
      }

      $('#loginform').validator().on('submit', function (e) {


        if (!e.isDefaultPrevented()) {

            $http.post('api/user/login',{
                email: $("#email").val(),
                password: $("#password").val(),
            }).then(function successCallback(response) {
                $localStorage.isLoggedIn = true;
                $rootScope.isLoggedIn = true;
                $location.path('/');
                console.log([
                   $localStorage.isLoggedIn,$rootScope.isLoggedIn
                ]);
                return;
            }, function errorCallback(response) {});
        }

        return false;
      });

  });
  app.controller('searchController', function($scope, $http, $route) {

    $http.post('api/search/' + $route.current.params.qstring, {}).then(
      function successCallback(response) {
      $scope.users = response.data;
    }, function errorCallback(response) {});



  });

  app.controller('NavController', function($scope, $http, $location,$localStorage,$route,$rootScope) {

    $scope.isLoggedIn = $rootScope.isLoggedIn;

    $scope.search = function(){
       $location.path('/search/'+$scope.qstring);return;
    }

    $scope.logout = function(){
      $http.get('api/user/logout', {}).then(function successCallback(response) {
        $rootScope.isLoggedIn = false;
        $localStorage.$reset();

          window.location.reload();

        $location.path('/');return;

      });
    }

  });


    app.run(["$rootScope", "$localStorage","$location", function($rootScope, $localStorage,$location) {


      if (!$rootScope.isLoggedIn && $localStorage.isLoggedIn) {
          $rootScope.isLoggedIn = true;

      }



    }]);


  app.controller('WallController', function($scope, $http,$localStorage,$location) {

    if (!$localStorage.isLoggedIn) {$location.path('/register');}
    
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
