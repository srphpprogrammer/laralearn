
<div class="container" ng-controller="WallController">
<div class="col-md-8">

    <div class="row">
                <br>
                              <br>
         
       
<div class="well"> 
              

                                   <form class="form-horizontal" role="form" method="post" action="{{url('status')}}">
                                    <h4>What's New</h4>

                                     <div class="form-group" style="padding:14px;">
  <textarea class="form-control" ng-model="content" placeholder="Update your status" required name="status"></textarea>
                                    </div>
                                    <button ng-click="makePost()" class="btn btn-primary pull-right" type="button">Post</button>

                                    <ul class="list-inline">&nbsp;</ul>
                                  </form>
                              </div>

                              </div>


    <div class="row">


<div class="panel panel-default" ng-repeat="p in posts">
                                 <div class="panel-heading"><a href="#" class="pull-right">

                                 {{p.created_at  }}</a> <h4> {{ p.user.name }}</h4></div>
                                  <div class="panel-body">

                                  {{ p.content }}

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



                              </div>
        <!-- {{ $posts->links() }} -->

<ul class="pager">
  <li><a href="javascript::void(0)" ng-click="loadmore()">Load More Posts</a></li>
</ul>

        <!--                         </div>
<div class="col-sm-2 "  >
<br>
<br>
<br>
<br>
            <nav class="nav-sidebar">
                <ul class="nav">
                    <li class="active"><a style="background-color: #eee;" href="javascript:;">Posts</a></li>
                  <li><a href="javascript:;">About</a></li>
          <li><a href="javascript:;">Products</a></li>
          <li><a href="javascript:;">FAQ</a></li>
          <li class="nav-divider"></li>
          <li><a href="javascript:;"><i class="glyphicon glyphicon-off"></i> Sign in</a></li>
                           </ul>
            </nav>
        </div>-->
                      

                              </div>
