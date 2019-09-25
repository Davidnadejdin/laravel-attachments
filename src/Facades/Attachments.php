<?php

namespace Envant\Attachments\Facades;

use Illuminate\Support\Facades\Facade;

class Attachments extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'attachments';
    }
}
