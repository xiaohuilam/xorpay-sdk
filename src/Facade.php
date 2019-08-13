<?php
namespace Xorpay;

use Illuminate\Support\Facades\Facade;

class Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xorpay';
    }
}