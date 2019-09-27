<?php

return [
    'table' => 'attachments',
    'model' => Envant\Attachments\Attachment::class,
    'user_model' => null,
    'storage' => [
        'disk' => 'public',
        'directory' => 'attachments',
    ],
    'routes' => [
        'enabled' => true,
        'controller' => Envant\Attachments\AttachmentController::class,
        'middleware' => 'api',
        'prefix' => 'api',
    ],
];