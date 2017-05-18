@extends('master')

@section('content')
<div class="container">	
<center>	
<div class="row"><h4>Accept Friend Invitation from {{$friend->name}}?</h4></div>
<div class="row">

	<form method="POST" id="myform">
	{{ csrf_field() }}
    <button type="button" class="btn btn-primary" id="accept" >Accept</button>
    <button type="button" id="reject" class="btn btn-alert">Reject</button>
    <input name="action" type="hidden" id="action"></input>
    </form>

</div>
</center>
</div>

<script type="text/javascript">
	
var form = document.getElementById('myform');
document.getElementById('accept').onclick = function() {
	document.getElementById('action').value = "accept";
    form.submit();
}
document.getElementById('reject').onclick = function() {
	document.getElementById('action').value = "reject";
    form.submit();
}

</script>
@endsection


