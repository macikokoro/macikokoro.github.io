<?php
$dir = dirname(dirname(__DIR__));
if(!file_exists("{$dir}/git_home")) mkdir("{$dir}/git_home");
chmod("{$dir}/git_home", 0777);
