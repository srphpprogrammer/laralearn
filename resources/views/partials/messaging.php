
<div class="container" ng-controller="MessagesController" id="MessageBox">
<div class="col-md-12">



  <div class="panel panel-primary">
                <div class="panel-heading" id="accordion">
                    <span class="glyphicon glyphicon-comment"></span> Messages
                    <div class="btn-group pull-right">
                 <!--        <a type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a> -->
                    </div>
                </div>
            <div class="panel-collapse" id="collapseOne">
                <div class="panel-body">
                    <ul class="chat">
                        <li class="clearfix" ng-repeat="m in messages">
                        <span class="chat-img pull-left">
                            <img src="http://laralearn.dev/uploads/images/{{m.u1image}}" alt="User Avatar" style="width:40px;height:40px;" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">

                                    {{m.u1name}}

                                    </strong>
                                    <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>{{m.created_at}}
                                        </small>
                                </div>
                                <p>
                                   {{m.message}}
                                </p>
                            </div>
                        </li>
<!--                         <li class="right clearfix"><span class="chat-img pull-right">
<img src="http://laralearn.dev/uploads/images/{{u.u1image}}" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>{{m.created_at}}</small>
                                    <strong class="pull-right primary-font">{{m.name}}</strong>
                                </div>
                                <p>
                                     {{m.message}}
                                </p>
                            </div>
                        </li> -->
                        
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." ng-click="sendMessage()" ng-model="message"/>
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat">
                                Send</button>
                        </span>
                    </div>
                </div>
            </div>
            </div>

</div>

</div>

