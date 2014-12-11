<ul class="pull-left nav nav-tabs nav-stacked">
    <li class="<?php echo $h(empty($controller)?'active':''); ?>"><a href="/awesomesde/admin">Main</a></li>
    <li class="<?php echo $h($controller=="questions"?'active':''); ?>"><a href="/awesomesde/admin-questions">Questions</a></li>
    <li class="<?php echo $h($controller=="gen_settings"?'active':''); ?>"><a href="/awesomesde/admin-general-settings">General Settings</a></li>
</ul>
