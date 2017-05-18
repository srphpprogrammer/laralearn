@extends('master')

@section('content')
<div class="container">
<div class="col-md-8">

@foreach ($notifications as $n)
<ul class="list-group">

  <li class="list-group-item"><a href="{{url('notification/action',$n->id)}}">{{ $n->description }} </a><span class="pull-right">{{$n->created_at->diffForHumans()}}</span></l	i>

</ul>
@endforeach
    @endsection