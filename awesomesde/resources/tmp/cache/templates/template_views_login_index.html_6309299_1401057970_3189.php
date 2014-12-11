<?php if ($hidden === 'false') {
    echo '<div class="alert alert-block">';
    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    echo "<h4>Warning!</h4>";
    echo $errorMessage;
    echo '</div>';
}
?>

<div class="container">
    <div class="span6 offset2">
        <div class="container-login" id="container-login">
            <div class="overlay-box">
                <div class="signinup-default beige">

                    <br/>

                    <p>

                    <form id="facebookLogin" action="login/doLogin">
                        <input name="provider" value="facebook" hidden="true">
                        <button id="fb-login" class="facebook" type="submit">
                            <span class="issuuicons">f</span> Connect with Facebook
                        </button>
                    </form>
                    </p>

                    <p>

                    <form id="linkedInLogin" action="login/doLogin">
                        <input name="provider" value="linkedin" hidden="true">
                        <button id="linkedin-login" class="linkedin" type="submit">
                            <span class="issuuicons">L</span> Connect with Linkedin
                        </button>
                    </form>
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