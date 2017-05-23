
<div class="container" ng-controller="ProfileController">
    <div class="row">
    <br><br>
        <br><br>
    <center>
    <img src="images/default_avatar.png" name="aboutme" width="140" height="140" border="0" class="img-circle">
    <h3 class="media-heading">{{ user.name }}</h3>

	<div ng-if="friend == null">
	<br>
	<a href="profile/edit" class="btn btn-primary btn-small">Edit Profile</a>
	<br>
	<br>
	</div>


	<div ng-if="friend != null">
<br>	
	<form action="{{url('profile/friend')}}" method="post">
<!-- 		<input type="hidden" value="unfriend" name="action" />
<input type="hidden" value="{{$user->id}}" name="userid" /> -->
		<div  ng-if="friend.is_confirmed == 1">
		<!-- @if(!empty($friend) && $friend->is_confirmed == 1) -->
			<button type="submit" class="btn btn-primary btn-small">Unfriend</button>
		<input type="hidden" value="unfriend" name="action" />
		</div>
		<div  ng-if="friend == null">

		<!-- @elseif(empty($friend)) -->
			<input type="hidden" value="send" name="action" />
			<button type="submit" class="btn btn-primary btn-small">Send Friend Request</button>
			</div>
	<!-- 	@else -->
		<div  ng-if="friend != null && friend.is_confirmed == 0">

			<input type="hidden" value="cancel" name="action" />
			<button type="submit" class="btn btn-primary btn-small">Cancel Friend Request</button>
			</div>

	<!-- 	@endif -->
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
