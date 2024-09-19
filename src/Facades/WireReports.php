<?php

namespace Rishadblack\WireReports\Facades;

use Illuminate\Support\Facades\Facade;

class WireReports extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wire-reports';
    }
}
