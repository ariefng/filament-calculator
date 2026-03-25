<?php

namespace Ariefng\FilamentCalculator\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Illuminate\Support\Js;

class CalculatorAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->icon($this->getCalculatorIcon())
            ->color($this->getCalculatorColor())
            ->actionJs(fn (): string => <<<'JS'
                window.filamentCalculatorOriginInput = $el.closest('.fi-input-wrp')?.querySelector('input') ?? null

                JS
                . '; ' . $this->getJsClickHandler())
            ->tooltip(__('filament-calculator::calculator.title'))
            ->modalHeading(__('filament-calculator::calculator.title'))
            ->modalDescription(__('filament-calculator::calculator.description'))
            ->modalContent(fn (TextInput $component) => view('filament-calculator::action.calculator-action', [
                'maxDigits' => $this->getMaxDigits(),
                'maxDigitsMessage' => __('filament-calculator::calculator.max_digits_reached', ['max' => $this->getMaxDigits()]),
                'invalidExpressionMessage' => __('filament-calculator::calculator.invalid_expression'),
                'operatorButtonsColor' => $this->getOperatorButtonsColor(),
                'decimalSeparator' => $this->getConfiguredDecimalSeparator(),
                'defaultValue' => $this->getConfiguredInitialValue(),
                'currentValue' => $this->resolveComponentValue($component),
                'locale' => app()->getLocale(),
                'targetInputId' => $this->resolveTargetInputId($component),
                'targetInputStatePath' => $this->resolveTargetInputStatePath($component),
            ]))
            ->modalSubmitAction(false)
            ->modalWidth($this->getConfiguredModalWidth())
            ->extraModalFooterActions(fn (Action $action, TextInput $component): array => [
                $action->makeModalAction('insert')
                    ->label(__('filament-calculator::calculator.actions.insert'))
                    ->color($this->getInsertActionColor())
                    ->icon($this->getInsertActionIcon())
                    ->iconPosition($this->getInsertActionIconPosition())
                    ->size(Size::Large)
                    ->extraAttributes(['class' => 'fc-calculator-insert-action'])
                    ->actionJs(sprintf(
                        <<<'JS'
                        window.dispatchEvent(new CustomEvent('calculator-insert-requested', {
                            detail: {
                                targetInputId: %s,
                                targetInputStatePath: %s,
                            },
                        }))
                        JS,
                        Js::from($this->resolveTargetInputId($component))->toHtml(),
                        Js::from($this->resolveTargetInputStatePath($component))->toHtml(),
                    )),
            ])
            ->modalCancelAction(false);
    }

    public static function getDefaultName(): ?string
    {
        return 'calculator';
    }

    protected function getMaxDigits(): int
    {
        return (int) config('filament-calculator.max_digits', 15);
    }

    protected function getConfiguredInitialValue(): string
    {
        $value = config('filament-calculator.initial_value', 'field');

        return match ($value) {
            0, '0', 'zero' => '0',
            default => 'field',
        };
    }

    protected function getConfiguredDecimalSeparator(): ?string
    {
        $separator = config('filament-calculator.decimal_separator');

        return match ($separator) {
            '.', 'dot' => '.',
            ',', 'comma' => ',',
            'locale', null => null,
            default => null,
        };
    }

    protected function getOperatorButtonsColor(): string | array
    {
        $color = config('filament-calculator.operator_buttons.color', 'gray');

        return is_array($color) ? $color : (string) $color;
    }

    protected function getCalculatorIcon(): string
    {
        return (string) config('filament-calculator.action.icon', 'heroicon-o-calculator');
    }

    protected function getCalculatorColor(): string
    {
        return (string) config('filament-calculator.action.color', 'gray');
    }

    protected function getConfiguredModalWidth(): Width | string
    {
        $width = (string) config('filament-calculator.action.modal_width', Width::Small->value);

        return Width::tryFrom($width) ?? $width;
    }

    protected function getInsertActionColor(): string
    {
        return (string) config('filament-calculator.insert_action.color', 'gray');
    }

    protected function getInsertActionIcon(): string
    {
        return (string) config('filament-calculator.insert_action.icon', 'heroicon-o-arrow-down-tray');
    }

    protected function getInsertActionIconPosition(): IconPosition | string
    {
        $position = (string) config('filament-calculator.insert_action.icon_position', IconPosition::After->value);

        return IconPosition::tryFrom($position) ?? $position;
    }

    protected function resolveTargetInputId(TextInput $component): ?string
    {
        $id = $component->getId();

        if (blank($id)) {
            return null;
        }

        return $id;
    }

    protected function resolveComponentValue(TextInput $component): string | int | float | null
    {
        $value = $component->getState();

        return is_scalar($value) || $value === null ? $value : null;
    }

    protected function resolveTargetInputStatePath(TextInput $component): ?string
    {
        $statePath = $component->getStatePath();

        if (blank($statePath)) {
            return null;
        }

        return $statePath;
    }
}
