<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" ng-app="myapp">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Larabook</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="{{asset('style.css')}}">

  </head>

  <body id="app-layout" ng-class="(isLoggedIn != true) ? 'unauthbg' : ''"

<!-- 
  class="{{Auth::guest()? 'unauthbg' :'' }}" -->
 <!--  <base href="/asker/laralearn/public/" />   -->

    <nav class="navbar navbar-default xnavbar-fixed-top" ng-controller="NavController">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <a ng-if="isLoggedIn != true" class="navbar-brand" href="{{ url('') }}"><span class="glyphicon glyphicon-fire"></span>
 &nbsp; Larabook</a>

      <a ng-if="isLoggedIn == true" class="navbar-brand" href="wall/"><span class="glyphicon glyphicon-fire"></span>
 &nbsp; Larabook</a>

        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">

                        <li ng-if="isLoggedIn != true" ><a href="{{ url('/login') }}">Login</a></li>
                        <li ng-if="isLoggedIn != true" ><a href="register/">Register</a></li>
    
         
   <li ng-if="isLoggedIn"><a href="{{ url('/notifications') }}"> <span class="badge badge-notify">@{{auth.notcount}}</a></li>
<!--  <li><a href="javascript::void(0)" ng-click="logout()"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
-->

                        <li class="dropdown" ng-if="isLoggedIn == true">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
                             @{{auth.user.name}} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                  <li><a href="profile/@{{auth.user.id}}">My Profile</a></li>

                                     <li><a href="{{ url('/friends') }}">Friends</a></li>
                                <li><a href="javascript::void(0)" ng-click="logout()"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                         
                            </ul>
                        </li>
                
          </ul>
          <form class="navbar-form navbar-right" ng-submit="search()" ng-show="isLoggedIn">
            <input required type="text" class="form-control" placeholder="Search..." ng-model="qstring">
            <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>

          </form>
        </div>
      </div>
    </nav>

    <div id="wrap" class="container-fluid">

      <div ng-view>
      </div>


    </div>

<style type="text/css">
.navbar-default {
background-color: #8686CF;
border-color: #FFFFFF;
}

.navbar-default .navbar-brand {
color: #FFF;
}

.navbar-default .navbar-nav>li>a {
color: #FFF;
}

.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover {
background-color: #8686CF;
color: #FFF;

}

.badge {

background-color: #5252BB;

}

.navbar-default .navbar-brand:focus, .navbar-default .navbar-brand:hover {
color: #FFF;
background-color: transparent;
}

* {
  -webkit-border-radius: 0 !important;
     -moz-border-radius: 0 !important;
          border-radius: 0 !important;
}
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>




    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular-route.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.6/ngStorage.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>
  <script src="https://js.pusher.com/4.0/pusher.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script> 




<script type="text/javascript">


 /* 
      // Enable pusher logging - don't include this in production
 

*/
</script>
  </body>

</html>
