
<div class="container" ng-controller="ProfileController">
    <div class="row">
    <br><br>
        <br><br>
    <center>
    <img src="images/default_avatar.png" name="aboutme" width="140" height="140" border="0" class="img-circle">

    <h3 class="media-heading">{{ user.name | capitalize}}</h3>
	<div ng-if="friend == null && auth.user.id == user.id">
	<br>
	<a href="user/edit" class="btn btn-primary btn-small">Edit Profile</a>
	<br>
	<br>
	</div>


	<div ng-if="auth.user.id != user.id">
<br>	
	<form action="{{url('profile/friend')}}" method="post">
		<div  ng-if="friend.is_confirmed == 1">
			<button type="button" class="btn btn-primary btn-small">Unfriend</button>
		<input type="hidden" value="unfriend" name="action" />
		</div>
		<div  ng-if="friend == null">
 
			<button type="button" id="sfr" ng-click="sendFriendRequest()" class="btn btn-primary btn-small" >Send Friend Request</button>
			</div>
		<div  ng-if="friend != null && friend.is_confirmed == 0">

			<button type="button" ng-click="cancelFriendRequest()" class="btn btn-primary btn-small">Cancel Friend Request</button>
			</div>
	</form>
<br>
<br>
	</div>








                    <span>
                    <strong>Bragging Rights </strong></span>
                    <span style="margin-right:10px;" class="label label-success"  ng-repeat="r in rights">{{ r }}</span>
                    </center>
                    <hr>
                </div>
                              </div>
