<?php

/*
 * Bear Framework HTML Template
 * https://github.com/bearframework/html-template
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'BearFramework\HTMLTemplate' => 'src/HTMLTemplate.php'
);

spl_autoload_register(function ($class) use ($classes): void {
    if (isset($classes[$class])) {
        require __DIR__ . '/' . $classes[$class];
    }
}, true);
