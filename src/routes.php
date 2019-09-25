<?php

Route::prefix(config('attachments.routes.prefix'))->middleware([config('attachments.routes.middleware')])->group(function () {
    Route::post('attachments', config('attachments.routes.controller') . '@store');
    Route::get('attachments/{attachment}', config('attachments.routes.controller') . '@show');
    Route::delete('attachments/{attachment}', config('attachments.routes.controller') . '@destroy');
});