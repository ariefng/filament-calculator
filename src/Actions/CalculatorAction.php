<?php

namespace Ariefng\FilamentCalculator\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
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
            ->tooltip(__('filament-calculator::calculator.title'))
            ->modalHeading(__('filament-calculator::calculator.title'))
            ->modalDescription(__('filament-calculator::calculator.description'))
            ->modalContent(view('filament-calculator::action.calculator-action', [
                'maxDigits' => $this->getMaxDigits(),
                'maxDigitsMessage' => __('filament-calculator::calculator.max_digits_reached', ['max' => $this->getMaxDigits()]),
                'invalidExpressionMessage' => __('filament-calculator::calculator.invalid_expression'),
            ]))
            ->modalSubmitAction(false)
            ->modalWidth($this->getConfiguredModalWidth())
            ->extraModalFooterActions(fn (Action $action, TextInput $component): array => [
                $action->makeModalAction('insert')
                    ->label(__('filament-calculator::calculator.actions.insert'))
                    ->color($this->getInsertActionColor())
                    ->icon($this->getInsertActionIcon())
                    ->iconPosition($this->getInsertActionIconPosition())
                    ->extraAttributes(['class' => 'fc-calculator-insert-action'])
                    ->actionJs(sprintf(
                        <<<'JS'
                        window.dispatchEvent(new CustomEvent('calculator-insert-requested', {
                            detail: {
                                targetInputId: %s,
                                invalidMessage: %s,
                                maxDigits: %s,
                                maxDigitsMessage: %s,
                            },
                        }))
                        JS,
                        Js::from($this->resolveTargetInputId($component))->toHtml(),
                        Js::from(__('filament-calculator::calculator.finish_before_insert'))->toHtml(),
                        Js::from($this->getMaxDigits())->toHtml(),
                        Js::from(__('filament-calculator::calculator.max_digits_reached', ['max' => $this->getMaxDigits()]))->toHtml(),
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
        return (string) config('filament-calculator.insert_action.color', 'primary');
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
}
