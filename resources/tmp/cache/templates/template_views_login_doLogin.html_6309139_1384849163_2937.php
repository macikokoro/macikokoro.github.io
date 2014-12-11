<div class="alert alert-block" <?php if ($hidden == true) echo "hidden" ?>>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Warning!</h4>
    <?php  echo $errorMessage ?>
</div>

<div class="container">
    <div class="span6 offset2">
        <div class="container-login" id="container-login">
            <div class="overlay-box">
                <div class="signinup-default beige">

                    <br/>

                    <p>
                        <button id="fb-login" class="facebook" type="button"
                                ng-controller="facebookController">
                            <span class="issuuicons">f</span> Connect with Facebook
                        </button>
                    </p>
                    <p>
                        <button id="google-login" class="google" type="button"
                                ng-controller="googleController">
                            <span class="issuuicons">g+</span> Connect with Google+
                        </button>
                    </p>
                    <p>


                    <p>


                    <p class="divider">OR</p>

                    <div id="job-match-login">
                        <form id="login-form" action="login/doLogin">
                            <p>
                                <input id="login-username" type="email" autocapitalize="off"
                                       placeholder="Email or username" maxlength="" value=""
                                       name="username" required ng-model="email">
                            </p>

                            <p>
                                <input id="login-password" type="password" placeholder="Password"
                                       maxlength="" value="" name="password" required ng-model="password">
                            </p>

                            <p>
                                <label class="pull-left" for="persist"> <input
                                        id="persist" type="checkbox"
                                        ng-model="persist"> Remember me
                                </label>
                            </p>
                            <a class="pull-right" href="/forgot-password">Forgot
                                password?</a>
                            <br/>
                            <br/>

                            <p>
                                <button id="login-button" class="positive" type="submit">
                                    <span class="text">Let's start</span> <span class="issuuicons"></span>
                                </button>
                            </p>
                            <p>

                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- /container -->
    </div>
</div> <!-- /container -->