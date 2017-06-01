
<div class="container">
<div class="col-md-8">


<ul class="list-group" ng-repeat="n in notifications">

  <li class="list-group-item">
  <a href="notification/{{n.id}}">{{ n.description }} </a><span class="pull-right">{{n.created_at}}</span>
  </li>

</ul>

</div>
</div>