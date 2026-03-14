<?php

namespace Ariefng\FilamentCalculator\Facades;

use Ariefng\FilamentCalculator\CalculatorPlugin;
use Illuminate\Support\Facades\Facade;

/**
 * @see CalculatorPlugin
 */
class FilamentCalculator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CalculatorPlugin::class;
    }
}
