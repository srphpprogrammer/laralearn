@extends('master')

@section('content')



<div class="container">
<div class="col-md-8">

    <div class="row">
                <br>
                              <br>
                              <br>
<br>
       
<div class="well"> 
              

                                   <form class="form-horizontal" role="form" method="post" action="{{url('status')}}">
                                    <h4>What's New</h4>
    {{ csrf_field() }}

                                     <div class="form-group" style="padding:14px;">
  <textarea class="form-control" placeholder="Update your status" required name="status"></textarea>
                                    </div>
                                    <button class="btn btn-primary pull-right" type="submit">Post</button>

                                    <ul class="list-inline">&nbsp;</ul>
                                  </form>
                              </div>

                              </div>


    <div class="row">

      @foreach ($posts as $p)

<div class="panel panel-default">
                                 <div class="panel-heading"><a href="#" class="pull-right">

                                 {{$p->created_at->diffForHumans()}}</a> <h4> {{ $p->user->name }}</h4></div>
                                  <div class="panel-body">

                                  {{ $p->content }}

                                  <!-- 
                                    <img src="//placehold.it/150x150" class="img-circle pull-right"> <a href="#">Keyword: Bootstrap</a>
                                    <div class="clearfix"></div>
                                    <hr>
                                    
                                    <p>If you're looking for help with Bootstrap code, the <code>twitter-bootstrap</code> tag at <a href="http://stackoverflow.com/questions/tagged/twitter-bootstrap">Stackoverflow</a> is a good place to find answers.</p>
                                     -->
                                    <hr>
                                    <form>
                         <!--            <div class="input-group">
                                      <div class="input-group-btn">
                                      <button class="btn btn-default">+1</button><button class="btn btn-default"><i class="glyphicon glyphicon-share"></i></button>
                                      </div>
                                      <input type="text" class="form-control" placeholder="Add a comment..">
                                    </div> -->
                                    </form>
                                    
                                  </div>
                               </div>

@endforeach

                              </div>
        {{ $posts->links() }}



                              </div>

                      

                              </div>
