@extends('master')

@section('content')
<div class="container">
    <div class="row">

<form action="" method="post">
    {{ csrf_field() }}

     <div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required value="{{$user->name}}">
    </div>
     <div class="form-group">
    <label>Bragging rights (Comma Separated)</label>
    <input type="text" name="brights" class="form-control" required value="{{$user->brights}}">
    </div>



  <div class="form-group">

    <!-- <label><input type="checkbox" name="terms"> I agree with the <a href="#">Terms and Conditions</a>.</label> -->
    <input type="submit" value="Save" class="btn btn-primary pull-right">
    </div>

    <div class="clearfix"></div>
    </form>










    </div>
    </div>
    @endsection
