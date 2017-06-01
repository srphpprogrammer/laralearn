
<div class="container" ng-controller="FriendController">
<div class="col-md-12">


<div class="col-md-3" ng-repeat="u in users">
<div class="card">
  <img class="card-img-top" style="max-width: 60%;" src="images/default_avatar.png" alt="Card image cap">
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

