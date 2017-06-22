<!DOCTYPE html>
<html>
<head>
  <title>Emit and Broadcast</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>

</head>

<body ng-app="app">


 <div ng-controller="MegaController" style="border:2px solid blue; padding:20px;">
 <h1>Mega Controller</h1>


<input ng-model="message">
<button ng-click="dobroadcast(message);">Broadcast</button>

 <div ng-controller="ParentController" style="border:2px solid #E75D5C; padding:20px;">

 <h1>Parent Controller</h1>
    <input ng-model="message">


   <div ng-controller="ChildController" style="border:2px solid green;padding:20px;">
    <h1>Child Controller</h1>
    <input ng-model="message">
    <button ng-click="doemit(message);">Emit</button>
   </div>

 </div>
 </div>

</body>


<script type="text/javascript">

  (function() {

    'use strict';

    var app = angular.module('app', []);

    app.controller("MegaController", function($scope) {

      $scope.$on('emitMachine', function(event, message) {
        $scope.message = message;
      });

      $scope.dobroadcast = function(msg) {
        $scope.$broadcast("broadCastMachine", msg);
      };


    });

    app.controller("ParentController", function($scope) {


      $scope.$on('broadCastMachine', function(event, message) {
        $scope.message = message;
      });

    });

    app.controller("ChildController", function($scope) {

      $scope.doemit = function(msg) {
        $scope.$emit("emitMachine", msg);
      };




    });

  }());



</script>
</html>