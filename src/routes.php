<?php

Route::middleware(config("visitorcount.middleware"))
    ->namespace("Ovde\Visitorcount\Controllers")
    ->group(function () {
        Route::get("visitorcount/graphdata", "GraphController@data");
    });
