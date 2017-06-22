(function() {
  'use strict';

  var app = angular.module('myapp', ['ngRoute','ngStorage']);

  app.config(['$routeProvider', '$locationProvider', '$httpProvider', function($routeProvider, $locationProvider, $httpProvider) {
    

    $routeProvider.when('/', {
      templateUrl: 'partials/home',
      controller: 'HomeController',
      controllerAs: 'hc',
    }).when('/profile/:id', {
      templateUrl: 'partials/profile',
      controller: 'ProfileController',
      controllerAs: 'pc'
    }).when('/notifications', {
      templateUrl: 'partials/notifications',
      controller: 'NotificationController',
      controllerAs: 'lc'
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
    }).when('/notification/:id/', {
      templateUrl: 'partials/notaction',
      controller: 'NotificationActionController',
      controllerAs: 'nac'
    }).when('/login', {
      templateUrl: 'partials/login',
      controller: 'LoginController',
      controllerAs: 'lc'
    }).when('/wall', {
      templateUrl: 'partials/wall',
      controller: 'WallController',
      controllerAs: 'wc'
    }).when('/friends', {
      templateUrl: 'partials/friends',
      controller: 'FriendController',
      controllerAs: 'fc'
    }).when('/messages/:id/', {
      templateUrl: 'partials/messaging',
      controller: 'MessagesController',
      controllerAs: 'fc'
    }).when('/auth/triggerlogin', {
      resolve: {
        loginService: ['$route', 'AuthFactory', function($route, AuthFactory) {
          return AuthFactory.triggerLogin();
        }]
      }
    }).otherwise({
      redirectTo:'/'
    });

    $locationProvider.html5Mode({
      enabled: true,
      requireBase: true
    });


  }]);


  app.controller('HomeController', function($scope,$http,$route,$localStorage,$location,$rootScope) {
      if($rootScope.isLoggedIn) $location.path('/wall');
  });


  app.run(["$rootScope", "$localStorage","$location","AuthFactory", function($rootScope, $localStorage,$location,AuthFactory) {


    if (!$rootScope.isLoggedIn && $localStorage.isLoggedIn) {
      AuthFactory.authenticate().then(function successCallback(response) {
        $rootScope.isLoggedIn = true;
        $localStorage.isLoggedIn = true;
        $rootScope.auth = response.data;
        //$location.path('/wall');
      }, function errorCallback(response) {
         $localStorage.$reset();
          $location.path('/');return;
      });
    }



  }]);


  app.controller('NavController', function($scope, $http, $location,$localStorage,$route,$rootScope) {

    $scope.search = function(){
       $location.path('/search/'+$scope.qstring);return;
    }

    $scope.logout = function(){
      $http.get('api/user/logout', {}).then(function successCallback(response) {
        $rootScope.isLoggedIn = false;
        $localStorage.$reset();
        $location.path('/');return;
      });
    }


  });



  app.controller('LoginController', function($scope,$http,$route,$localStorage,$location,$rootScope,AuthFactory) {

      if ($rootScope.isLoggedIn) $location.path('/');
      $('#loginform').validator();

      $('#loginform').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()) {
            $http.post('api/user/login',{
                email: $("#email").val(),
                password: $("#password").val(),
            }).then(function successCallback(response) {
                AuthFactory.authenticate().then(function successCallback(response) {
                  $localStorage.isLoggedIn = true;
                  $rootScope.isLoggedIn = true;
                  $rootScope.auth = response.data;
                  $location.path('/wall');
                  return;
                });

            }, function errorCallback(response) {});
        }
        return false;
      });

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


  app.controller('WallController', function($scope, $http,$localStorage,$location,$rootScope) {

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


      //return false;
      $http.post('api/posts/create', {
        content: $scope.content
      }).then(function successCallback(response) {
        $scope.posts.unshift(response.data);
        $scope.offset = $scope.offset + 1;
        $scope.content = '';
      }, function errorCallback(response) {});
    }

    Pusher.logToConsole = false;

    var pusher = new Pusher('aa6903fb73621b6ca6d5', {
      encrypted: false,
      authEndpoint: 'api/authcheck'
    });

    var channel = pusher.subscribe('private-larawall'+$rootScope.auth.user.id);
    //console.log('private-larawall'+$rootScope.auth.user.id);
    channel.bind('newpost', function(data) {
      console.log(data);
        $scope.$apply(function () {
         // $scope.posts.unshift(data);
        });

      $scope.posts.unshift(data);
    });



    



  });

  app.controller('searchController', function($scope, $http, $route) {
    $http.post('api/search/' + $route.current.params.qstring, {}).then(
      function successCallback(response) {
      $scope.users = response.data;
    }, function errorCallback(response) {});
  });

  app.controller('FriendController', function($scope, $http, $route) {
    $http.post('api/friends').then(
      function successCallback(response) {
      $scope.users = response.data;
    }, function errorCallback(response) {});
  });


  app.controller('UserController', function($scope, $http,$route,$location) {
    $http.get('api/user/edit', {}).then(function successCallback(response) {
      $scope.user = response.data;
    }, function errorCallback(response) {});

    $scope.saveProfile = function() {

      $http.post('api/user/edit', {
        brights : $scope.user.brights,
        name : $scope.user.name,
      }).then(function successCallback(response) {
        $location.path('/wall');

      }, function errorCallback(response) {});
    }

  $scope.uploadImage = function(files) {
    var formData = new FormData();
    formData.append("file", files[0]);
    $scope.showLoader = true;
    $http.post('api/user/image', formData, {
      headers: {
        'Content-Type': undefined
      },
      transformRequest: angular.identity
    }).then(function successCallback(response) {
      $scope.user.profile_image = response.data.image;
    }, function errorCallback(response) {});
  }



  });

  app.controller('ProfileController', function($scope, $http, $route,$location) {

    $scope.isFRSent = false;

    $http.get('api/profile/' + $route.current.params.id, {}).then(function successCallback(response) {
      $scope.user = response.data.user;
      $scope.friend = response.data.friend;
      $scope.rights = response.data.rights;
    }, function errorCallback(response) {});

    $scope.sendFriendRequest = function() {

      if($scope.isFRSent) return;
      $http.post('api/friend/request', {
        userid: $scope.user.id,
        action : 'sfr'
      }).then(function successCallback(response) {
          document.getElementById('sfr').innerText = "Friend Request Sent";
          $scope.isFRSent = true;
      }, function errorCallback(response) {});


    }

    $scope.cancelFriendRequest = function() {
      $http.post('api/friend/request', {
        userid: $scope.user.id,
        action : 'cfr'
      }).then(function successCallback(response) {

      }, function errorCallback(response) {});
    }



  });


  app.controller('NotificationController', function($scope, $http,$localStorage,$location) {

    if (!$localStorage.isLoggedIn) {$location.path('/register');}
    
    $scope.notifications = {};
    $scope.offset = 8;

    $http.post('api/notifications', {}).then(function successCallback(response) {
      $scope.notifications = response.data;
    }, function errorCallback(response) {});

   
  });

  app.controller('MessagesController', function($route,$scope, $http,$localStorage,$location) {
   

      $http.get('api/messages/'+$route.current.params.id, {}).then(function successCallback(response) {
        $scope.messages = response.data.messages;
      }, function errorCallback(response) {
        
      });

    $scope.sendMessage = function() {

      $http.post('api/messages/create', {
        message: $scope.message,
        id: $route.current.params.id,
      }).then(function successCallback(response) {
      }, function errorCallback(response) {
        console.log(response);
      });

    }

   
  });




  app.controller('NotificationActionController', function($scope, $http,$localStorage,$location,$route) {

    $http.get('api/notification/' + $route.current.params.id, {}).then(function successCallback(response) {
      $scope.user = response.data.user;
    }, function errorCallback(response) {
        $location.path('/wall');
    });

    if (!$localStorage.isLoggedIn) {$location.path('/register');}
    
    $scope.acceptRequest = function(action){
      $http.post('api/notification/' + $route.current.params.id, {
        action : action,
      }).then(function successCallback(response) {
        $location.path('/wall');
      });

    }

   
  });



  app.factory("AuthFactory", function($location, $http, $localStorage, $rootScope) {
    return {

      authenticate: function(param) {
        return $http.get('api/user/auth');
      },
      triggerLogin: function(param) {
        return $http.get('api/user/auth').then(function successCallback(response) {
          $rootScope.isLoggedIn = true;
          $localStorage.isLoggedIn = true;
          $rootScope.auth = response.data;
          $location.path('/wall');
        }, function errorCallback(response) {
           $localStorage.$reset();
            $location.path('/');return;
        });
      },
    }

  });

/*  app.factory("AuthFactory", function($location, $http, $localStorage, $rootScope) {



  });*/


  app.filter('capitalize', function() {
    return function(input, scope) {
      if (input!=null)
      input = input.toLowerCase();
      return input.substring(0,1).toUpperCase()+input.substring(1);
    }
  })


}());

