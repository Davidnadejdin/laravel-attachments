<?php

return [
    'table' => 'attachments',
    'attachment_class' => Envant\Attachments\Models\Attachment::class,
    'user_model' => null,
    'storage' => [
        'disk' => 'public',
        'directory' => 'attachments',
    ],
    'routes' => [
        'enabled' => true,
        'controller' => 'Envant\Attachments\Controllers\AttachmentController',
        'middleware' => 'api',
        'prefix' => 'api',
    ],
];