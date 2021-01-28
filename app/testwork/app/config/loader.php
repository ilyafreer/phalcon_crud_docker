<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerNamespaces(
        [
            'App\Controllers' => __DIR__ . '/../controllers/',
            'App\Controllers\Admin' => __DIR__ . '/../controllers/admin',
            'App\Models' => __DIR__ . '/../models/',
        ]
    )->register();
