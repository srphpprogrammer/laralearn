
<div class="container" ng-controller="searchController">
<div class="col-md-12">


<div class="col-md-3" ng-repeat="u in users">
<div class="card">
    <img src="http://laralearn.dev/uploads/images/{{u.profile_image}}" name="aboutme" width="140" height="140" border="0" class="img-circle">
  <div class="card-block">
    <h4 class="card-title">{{u.name | capitalize}}</h4>
    <p class="card-text">
    <h4><b>Bragging Rights</b></h4>
    {{u.brights | limitTo: 20 }} {{u.brights > 20 ? '...' : ''}}
    </p>
    <a href="profile/{{u.id}}" class="btn btn-primary">View Profile</a>
  </div>
  <br>
</div>
</div>


</div>

</div>

