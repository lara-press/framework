<?php
/*
Plugin Name: LaraPress framework
Plugin URI: http://larapress.com/
Description: A framework for WordPress developers.
Version: 1.0.0
Author: Jeff Berry
Author URI: http://portonefive.com
License: GPLv2
*/

$app = require_once __DIR__ . '/../../../bootstrap/app.php';

/** @var App\Http\Kernel $kernel */
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$kernel->init($request = Illuminate\Http\Request::capture());
