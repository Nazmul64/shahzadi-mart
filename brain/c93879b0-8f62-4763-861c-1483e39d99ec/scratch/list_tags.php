<?php
$content = file_get_contents('resources/views/frontend/pages/header.blade.php');
preg_match_all('/@\w+/', $content, $matches);
$tags = array_unique($matches[0]);
sort($tags);
print_r($tags);
