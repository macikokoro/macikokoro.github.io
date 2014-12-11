<div class="container">
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>Awesome SDE!</h1>
        <p class="lead">Make Yourself More Awesome</p>
        <?php echo $this->view()->render(array('element' => "login"), array())?>
    </div>

    <hr>

    <!-- Example row of columns -->
    <div class="row-fluid">
        <div class="span4">
            <h2>Candidates</h2>
            <p>As a software developer, you always want to be with worlds top-notch software organizations, where innovation and hard work go hand in hand.
                AwesomeSDE's trains you and connects you with worlds best organizations. With our help , you become better interviewees, sharper coders and more importantly better engineers.
            </p>
            <p><a class="btn" href="candidate">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Employers</h2>
            <p>AwesomeSDE's is bringing latent talent directly to you to fill open positions. We believe people grow become better with time. With our verified and detailed training process,
                we provide an environment to become better engineers.Search our database for people meeting your hiring bar.Our process makes your companies hiring simple.
                Bringing quality candidates to successful companies.</p>
            <p><a class="btn" href="employer">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Recruiters</h2>
            <p>
                It is hard to find good candidates - but may be it is easier to train a few decent candidates to awesome candidates.
                Think about it!!!!
            </p>
            <p><a class="btn" href="recruiter">View details &raquo;</a></p>
        </div>
    </div>

    <hr>

</div> <!-- /container -->