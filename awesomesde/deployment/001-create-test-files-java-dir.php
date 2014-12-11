<?php
$dir = dirname(dirname(__DIR__));
if(!file_exists("{$dir}/test_files")) mkdir("{$dir}/test_files");
chmod("{$dir}/test_files", 0777);
if(!file_exists("{$dir}/test_files/java")) mkdir("{$dir}/test_files/java");
chmod("{$dir}/test_files/java", 0777);
