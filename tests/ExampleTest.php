<?php

use Ariefng\FilamentCalculator\Actions\CalculatorAction;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Width;

it('configures the calculator action modal', function () {
    $action = CalculatorAction::make();

    expect($action->getName())->toBe('calculator')
        ->and($action->getModalHeading())->toBe(__('filament-calculator::calculator.title'))
        ->and($action->getModalDescription())->toBe(__('filament-calculator::calculator.description'))
        ->and($action->getIcon())->toBe('heroicon-o-calculator')
        ->and($action->getColor())->toBe('gray')
        ->and($action->getModalWidth())->toBe(Width::Small);
});

it('renders calculator blade with digit limit messaging', function () {
    $html = view('filament-calculator::action.calculator-action', [
        'maxDigits' => 15,
        'maxDigitsMessage' => __('filament-calculator::calculator.max_digits_reached', ['max' => 15]),
        'invalidExpressionMessage' => __('filament-calculator::calculator.invalid_expression'),
    ])->render();

    expect($html)->toContain('data-max-digits="15"')
        ->and($html)->toContain(e(__('filament-calculator::calculator.max_digits_reached', ['max' => 15])))
        ->and($html)->toContain(e(__('filament-calculator::calculator.invalid_expression')))
        ->and($html)->toContain('calculator-insert-requested')
        ->and($html)->toContain('data-calculator-display');
});

it('makes the insert modal action full width', function () {
    $action = CalculatorAction::make();
    $reflection = new ReflectionProperty($action, 'extraModalFooterActions');
    $reflection->setAccessible(true);
    $extraModalFooterActions = $reflection->getValue($action);
    $component = new class('amount') extends TextInput
    {
        public function getId(): string
        {
            return 'amount';
        }
    };

    $insertAction = $extraModalFooterActions($action, $component)[0];

    expect($insertAction->getExtraAttributes())
        ->toMatchArray(['class' => 'fc-calculator-insert-action']);
});

it('uses the configured calculator action options', function () {
    config()->set('filament-calculator.action.icon', 'heroicon-o-bolt');
    config()->set('filament-calculator.action.color', 'success');
    config()->set('filament-calculator.action.modal_width', 'md');
    config()->set('filament-calculator.insert_action.color', 'danger');
    config()->set('filament-calculator.insert_action.icon', 'heroicon-o-arrow-left');
    config()->set('filament-calculator.insert_action.icon_position', 'before');

    $action = CalculatorAction::make();
    $reflection = new ReflectionProperty($action, 'extraModalFooterActions');
    $reflection->setAccessible(true);
    $extraModalFooterActions = $reflection->getValue($action);
    $component = new class('amount') extends TextInput
    {
        public function getId(): string
        {
            return 'amount';
        }
    };

    $insertAction = $extraModalFooterActions($action, $component)[0];

    expect($action->getIcon())->toBe('heroicon-o-bolt')
        ->and($action->getColor())->toBe('success')
        ->and($action->getModalWidth())->toBe(Width::Medium)
        ->and($insertAction->getColor())->toBe('danger')
        ->and($insertAction->getIcon())->toBe('heroicon-o-arrow-left')
        ->and($insertAction->getIconPosition())->toBe(IconPosition::Before);
});
