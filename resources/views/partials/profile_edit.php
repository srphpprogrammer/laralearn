<div class="container" ng-controller="UserController">
<div class="row">

    <form action="" method="post" >

    <img src="http://laralearn.dev/uploads/images/{{user.profile_image}}" name="aboutme" width="140" height="140" border="0" class="img-circle">

      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required ng-model="user.name">
      </div>
      <div class="form-group">
        <label>Bio</label>
        <input type="text" name="brights" class="form-control" required  ng-model="user.brights">
      </div>


      <div class="form-group">
        <input type="button" ng-click="saveProfile()"  value="Save" class="btn btn-primary pull-right">
      </div>

      <div class="clearfix"></div>
    </form>


  <input type="file" name="file" onchange="angular.element(this).scope().uploadImage(this.files)">
  

  </div>
</div>

