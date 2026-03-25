# Filament Calculator

[![Latest Version](https://img.shields.io/packagist/v/ariefng/filament-calculator.svg?style=flat-square)](https://packagist.org/packages/ariefng/filament-calculator)

Provides a calculator modal action for Filament `TextInput` fields in Filament Admin Panel.

> **Note:** Supports Filament **v4** and **v5**. For changes and updates, see the [CHANGELOG](CHANGELOG.md).

![Filament Calculator plugin](resources/images/filament-calculator-plugin.webp)

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

-   🖼️ **Calculator Modal** - Full-featured calculator with arithmetic, percentage, sign toggle, and live result preview
-   🔎 **Readable Display** - Shows locale-aware decimal and thousands separators while typing in the calculator modal
-   🔁 **State Aware Reopen** - Reopens with the current field value, or falls back to a configurable initial value
-   🔧 **Flexible Attachment** - Attach as prefix or suffix action to any TextInput
-   ⚙️ **Configurable** - Customize icon, color, modal width, decimal separator, and more
-   🌐 **Multi-language** - Built-in translations for English and Indonesian
-   🔢 **Digit Limit** - Configurable maximum digits for input validation
-   ⚡ **Zero Configuration** - Works out of the box with sensible defaults
-   🎨 **Responsive** - Works seamlessly on desktop and mobile

## Requirements
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

Register the plugin in your Filament panel, then attach the calculator action to your form field.

## Usage

Attach the calculator action to a `TextInput` using `prefixAction()` or `suffixAction()`:

```php
use Ariefng\FilamentCalculator\Actions\CalculatorAction;
use Filament\Forms\Components\TextInput;

TextInput::make('amount')
    ->suffixAction(CalculatorAction::make());

TextInput::make('amount')
    ->prefixAction(CalculatorAction::make());
```

Since `CalculatorAction` extends Filament's default `Action`, you can use any supported action customization methods on it. If you place the calculator inside another Filament modal or slide-over form, you may want the calculator modal to open on top of the parent modal instead of closing and reopening the parent. Filament documents this pattern here:

https://filamentphp.com/docs/5.x/actions/modals#overlaying-child-action-modals-on-top-of-parent-action-modals

Example:

```php
TextInput::make('amount')
    ->suffixAction(
        CalculatorAction::make()
            ->overlayParentActions()
    );
```

Example preview:

![Filament Calculator modal example](resources/images/filament-calculator-plugin.gif)

The calculator shows the current expression on the first line and the live computed result on the second line. Both lines use locale-aware thousands and decimal separators in the modal display to keep larger values readable while typing. Pressing `Insert` writes the computed result back to the field, so users do not need to press the equals button first.

When the field already has a value, opening the calculator again will preload that value instead of resetting to `0`. If the field is blank, the calculator falls back to `0`.

When the calculator is used with Filament numeric inputs, the inserted value is normalized before it is written to the field:

- thousands separators are removed
- decimal separators are converted to `.`

This keeps the inserted value compatible with Filament numeric fields and browser `type="number"` inputs, even if the calculator UI is currently displaying values like `1.000,50`.

## Configuration

The published config file looks like this:

```php
return [
    'max_digits' => 15,

    'initial_value' => 'field',

    'decimal_separator' => 'locale',

    'operator_buttons' => [
        'color' => 'gray',
    ],

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
- `initial_value`: controls how the calculator starts. Use `'field'` to preload the current field value and fall back to `0` when blank, or use `0` / `'zero'` to always start from `0`. Default: `'field'`.
- `decimal_separator`: controls the decimal separator used by the calculator. Use `'locale'` to follow the current app locale automatically, `'.'` / `'dot'` to force a dot, or `','` / `'comma'` to force a comma.
- `operator_buttons.color`: color alias used by the `+`, `-`, `*`, `/`, and `=` buttons. Default: `gray`.
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

    'initial_value' => 'zero',

    'decimal_separator' => ',',

    'operator_buttons' => [
        'color' => 'warning',
    ],

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

The calculator modal uses Filament's built-in color variables. By default, the operator buttons and evaluate button use the `gray` color alias, and you can switch them to another Filament color alias through `operator_buttons.color`.

Decimal separator behavior follows the active locale by default. For example, `id` locales use `,` while `en` locales use `.`. The calculator display also applies locale-aware thousands separators while values are being entered. You can override the decimal behavior through the `decimal_separator` config option.

The grouped formatting is display-only inside the calculator modal. Inserted values are always written back as plain numeric strings without thousands separators, and comma decimals are normalized to dots before dispatching the input and change events.

When reopening the calculator, the current field value is preferred when `initial_value` is set to `'field'`. If you prefer a clean calculator every time, set `initial_value` to `0` or `'zero'`.

Calculator insertion also supports `TextInput` components inside Filament `Repeater` items by targeting the field's unique state path instead of relying only on the DOM input id.

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

Security summary from a Claude Opus 4.6 code review:

| Category | Status |
| --- | --- |
| XSS | No vulnerabilities |
| Code injection | Protected (custom parser, no eval) |
| CSRF | N/A (no server-side mutations) |
| Input validation | Proper (max digits, whitelisted separators) |

This summary is informational and does not replace responsible disclosure. If you discover a vulnerability, please report it through the security policy linked above.

## Credits

- [Arief Nugraha](https://github.com/ariefng)
- [All Contributors](../../contributors)

This plugin was built entirely with Codex.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
