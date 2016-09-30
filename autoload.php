<?php

/*
 * Bear Framework HTML Template
 * https://github.com/bearframework/html-template
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'BearFramework\HTMLTemplate' => 'src/HTMLTemplate.php'
);

spl_autoload_register(function ($class) use ($classes) {
    if (isset($classes[$class])) {
        require __DIR__ . '/' . $classes[$class];
    }
}, true);
