<?php
$dir = dirname(dirname(__DIR__));
if(!file_exists("{$dir}/solution_files")) mkdir("{$dir}/solution_files");
chmod("{$dir}/solution_files", 0777);
if(!file_exists("{$dir}/solution_files/java")) mkdir("{$dir}/solution_files/java");
chmod("{$dir}/solution_files/java", 0777);
