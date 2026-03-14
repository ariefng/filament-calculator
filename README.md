# Filament Calculator

[![Latest Version](https://img.shields.io/packagist/v/ariefng/filament-calculator.svg?style=flat-square)](https://packagist.org/packages/ariefng/filament-calculator)

Provides a calculator modal action for Filament `TextInput` fields in Filament Admin Panel.

> **Note:** Supports Filament **v4** and **v5**. For changes and updates, see the [CHANGELOG](CHANGELOG.md).

![Filament Calculator modal](resources/images/filament-calculator-plugin.gif)

## Table of Contents

-   [Features](#features)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Quick Start](#quick-start)
-   [Usage](#usage)
-   [Configuration](#configuration)
-   [Styling](#styling)
-   [Testing](#testing)
-   [Contributing](#contributing)
-   [Security Vulnerabilities](#security-vulnerabilities)
-   [Credits](#credits)
-   [License](#license)

## Features

-   🖼️ **Calculator Modal** - Full-featured calculator with basic arithmetic operations
-   🔧 **Flexible Attachment** - Attach as prefix or suffix action to any TextInput
-   ⚙️ **Configurable** - Customize icon, color, modal width, and more
-   🌐 **Multi-language** - Built-in translations for English and Indonesian
-   🔢 **Digit Limit** - Configurable maximum digits for input validation
-   ⚡ **Zero Configuration** - Works out of the box with sensible defaults
-   🎨 **Responsive** - Works seamlessly on desktop and mobile

## Requirements

-   PHP 8.2+
-   Laravel 10.0+ (for Panels) or standalone Forms package
-   Filament 4.0 or 5.0

## Installation

Install the package via Composer:

```bash
composer require ariefng/filament-calculator
```

Publish the package configuration (optional):

```bash
php artisan vendor:publish --tag="filament-calculator-config"
```

Publish the package translations (optional):

```bash
php artisan vendor:publish --tag="filament-calculator-translations"
```

Currently, the package ships with translations for English (`en`) and Indonesian (`id`) only.

If you are using Filament Panels, register the plugin in your panel provider:

```php
use Ariefng\FilamentCalculator\CalculatorPlugin;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(CalculatorPlugin::make());
}
```

## Quick Start

Attach the calculator action to a `TextInput` using `prefixAction()` or `suffixAction()`:

```php
use Ariefng\FilamentCalculator\Actions\CalculatorAction;
use Filament\Forms\Components\TextInput;

TextInput::make('amount')
    ->suffixAction(CalculatorAction::make());

TextInput::make('amount')
    ->prefixAction(CalculatorAction::make());
```

## Configuration

The published config file looks like this:

```php
return [
    'max_digits' => 15,

    'action' => [
        'icon' => 'heroicon-o-calculator',
        'color' => 'gray',
        'modal_width' => 'sm',
    ],

    'insert_action' => [
        'color' => 'gray',
        'icon' => 'heroicon-o-arrow-down-tray',
        'icon_position' => 'after',
    ],
];
```

Available options:

- `max_digits`: maximum numeric digits allowed in the calculator.
- `action.icon`: calculator trigger icon. Default: `heroicon-o-calculator`.
- `action.color`: calculator trigger color. Default: `gray`.
- `action.modal_width`: modal width. Default: `sm`.
- `insert_action.color`: insert button color. Default: `gray`.
- `insert_action.icon`: insert button icon. Default: `heroicon-o-arrow-down-tray`.
- `insert_action.icon_position`: insert button icon position. Default: `after`.

Example:

```php
return [
    'max_digits' => 12,

    'action' => [
        'icon' => 'heroicon-o-bolt',
        'color' => 'success',
        'modal_width' => 'md',
    ],

    'insert_action' => [
        'color' => 'danger',
        'icon' => 'heroicon-o-arrow-left',
        'icon_position' => 'before',
    ],
];
```

## Styling

The calculator styles are automatically loaded globally - no need to run `php artisan filament:assets`.

If you need to customize the calculator's appearance, you can override the CSS by publishing the package's views and adding your custom styles to your application's CSS file.

The calculator modal uses Filament's built-in styling system and will automatically match your panel's theme.

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Arief Nugraha](https://github.com/ariefng)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
