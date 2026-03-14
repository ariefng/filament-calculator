<?php

namespace Ariefng\FilamentCalculator;

use Filament\Contracts\Plugin;
use Filament\Panel;

class CalculatorPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-calculator';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}

    public static function make(): static
    {
        return app(static::class);
    }
}
