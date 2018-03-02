<?php

# Un-comment if using composer
# require('vendor/autoload.php');

function load_json($path) {
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}



echo "Reward Cloud PHP Task\n";