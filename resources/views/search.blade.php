@extends('master')

@section('content')
<div class="container">
<div class="col-md-12">

@foreach ($users as $u)

<div class="col-md-3">
<div class="card">
  <img class="card-img-top" style="max-width: 60%;" src="{{asset('images/default_avatar.png')}}" alt="Card image cap">
  <div class="card-block">
    <h4 class="card-title">{{$u->name}}</h4>
    <p class="card-text">
    <!-- <h4><b>Bragging Rights</b></h4> -->

    {{ str_limit($u->brights,10) }}
    </p>
    <a href="{{url('user',$u->id)}}" class="btn btn-primary">View Profile</a>
  </div>
  <br>
</div>
</div>
@endforeach

{{ $users->links() }}

</div>

</div>


@endsection