<?php

use \App\Controllers\VideoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your WordPress site. These
| routes are loaded from the TypeRocket\Http\RouteCollection immediately
| after the typerocket_routes action is fired.
|
*/



tr_route()->get()->on('video/*', function($arg) {  
    $video = new VideoController();
    return $video->renderPage($arg);
});

tr_route()->get()->on('video', function() {  
    $video = new VideoController();
    return $video->renderPage();
});