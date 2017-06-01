
<div class="container" ng-controller="NotificationActionController">	
<center>	
<div class="row"><h4>Accept Friend Invitation from {{user.name}}?</h4></div>
<div class="row">

	<form method="POST" id="myform">
    <button type="button" class="btn btn-primary" ng-click="acceptRequest('accept')">Accept</button>
    <button type="button" class="btn btn-alert" ng-click="rejectRequest('reject')">Reject</button>
    </form>

</div>
</center>
</div>

<script type="text/javascript">
/*	
var form = document.getElementById('myform');
document.getElementById('accept').onclick = function() {
	document.getElementById('action').value = "accept";
    form.submit();
}
document.getElementById('reject').onclick = function() {
	document.getElementById('action').value = "reject";
    form.submit();
}
*/
</script>



