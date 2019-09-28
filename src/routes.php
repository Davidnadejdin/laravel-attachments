<?php

Route::prefix(config('attachments.routes.prefix'))->middleware(config('attachments.routes.middleware'))->group(function () {
    Route::resource('attachments', config('attachments.routes.controller'))->only(['store', 'show', 'destroy']);
});