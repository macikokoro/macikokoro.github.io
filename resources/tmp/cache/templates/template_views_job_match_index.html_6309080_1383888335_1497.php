<div class="container">
    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>JobMatcher!</h1>
        <p class="lead">Match jobs to candidates on a click of a button</p>
        <?php echo $this->view()->render(array('element' => "login"), array())?>
    </div>

    <hr>

    <!-- Example row of columns -->
    <div class="row-fluid">
        <div class="span4">
            <h2>Candidates</h2>
            <p>Candidates register and provide their profile with details on their skills.We evaluate your skills using
                experts or expert systems and recommend areas to improve.The candidate decides to make their skills
                public
            </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Employers</h2>
            <p>Employers get pre-evaluated candidates with details on questions asked and candidate responses,
                saving hundreds of thousands of dollars on screening</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Recruiters</h2>
            <p>Cut your work in half by using an automated system to match your candidates,
                Ask the right questions using our expert system to do pre-screens.
                Save a lot of time</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
    </div>

    <hr>

</div> <!-- /container -->