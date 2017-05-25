
<div class="container" ng-controller="RegisterController">
    <div class="row">
          <br>
                    <br>
                    <center>
                
                    <h4>Sign up on Larabook and Make New Friends!</h4>
                    
                    </center>
                    <br>
                    <br>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">


                    <form class="form-horizontal" role="form" novalidate id="regform" >
<!-- 
ng-submit="register()" -->


                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required ng-model="name"  data-minlength="2">
     <span class="help-block with-errors">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" ng-model="email" required data-error="Invalid Email ID"  data-remote="<?php echo "http://$_SERVER[HTTP_HOST]"."/asker/laralearn/public/api/validateemail";?>">
                                     <span class="help-block with-errors" >
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" ng-model="password" required data-minlength="6">
                                     <span class="help-block with-errors" >
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" ng-model="confirmpassword" required data-match="#password" data-match-error="Whoops, these don't match">
                                 <span class="help-block with-errors" >
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

