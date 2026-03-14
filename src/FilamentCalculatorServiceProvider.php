<?php

namespace Ariefng\FilamentCalculator;

use Ariefng\FilamentCalculator\Testing\TestsFilamentCalculator;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentCalculatorServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-calculator';

    public static string $viewNamespace = 'filament-calculator';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('ariefng/filament-calculator');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }
        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        $stubsPath = __DIR__ . '/../stubs/';

        if (app()->runningInConsole() && is_dir($stubsPath)) {
            foreach (app(Filesystem::class)->files($stubsPath) as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-calculator/{$file->getFilename()}"),
                ], 'filament-calculator-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentCalculator);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'ariefng/filament-calculator';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('calculator-styles', __DIR__ . '/../resources/css/index.css')
                ->loadedOnRequest(),
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }
}
